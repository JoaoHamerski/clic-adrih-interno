<?php 

namespace App\Util;

use Carbon\Carbon;

class Helper {
	/**
	 * Converte a primeira letra de cada palavra de uma sentença 
	 * para maíuscula usando ucfirst(), podendo ser informado um 
	 * array com exceções (palavras que não devem ser transformadas para ucfirst())
	 * 
	 * @param string $sentence
	 * @param string|array $except
	 * @return string;
	 */
	public static function ucsentence(String $sentence, $except = '')
	{
		$sentence = explode(' ', $sentence);

		$sentence = array_map(function($value) use ($except) {
			return \Str::is($except, $value)
				? $value
				: \Str::ucfirst($value);
		}, $sentence);

		return implode(' ', $sentence);
	}

	/**
     * Formata a data usando strftime.
     * Referências para $format: https://www.php.net/manual/en/function.strftime.php.
     *
     * @param string $format
     * @param string | \Carbon\Carbon $datetime
     * @return string
     */
	public static function date($datetime, $format)
	{
		if (! $datetime) {
			return '';
		}

		$datetime = self::dateToTimestamp($datetime);

		return strftime(self::replaceDateExceptions($format, $datetime), $datetime);
	}

	/**
     * Converte o valor informado para uma timestamp de valor inteiro.
     * 
     * @param  string | \Carbon\Carbon $timestamp
     * @return int $timestamp
     */
	public static function dateToTimestamp($datetime)
	{
		if (is_string($datetime)) {
			return strtotime($datetime);
		}

		if (is_object($datetime) && $datetime instanceof Carbon) {
			return $datetime->getTimestamp();
		}

		return $datetime;
	}

	/**
     * Substitui quando o formato retorna alguma string com caractere acentuado
     * ao utilizar strftime(), isso foi feito pois o Laravel lança um exception quando 
     * a função strftime() retorna uma string com caracteres de acento ou cedilha.
     * 
     * @param  mix $timestamp
     * @return int $timestamp
     */ 
	private static function replaceDateExceptions($format, $timestamp)
	{
		if (\Str::contains($format, "%B") && date('n', $timestamp) == 3) {
			$format = str_replace("%B", "março", $format);
		}

		if (\Str::contains($format, "%A") && date('N', $timestamp) == 6) {
			$format = str_replace("%A", "sábado", $format);
		}

		if (\Str::contains($format, "%A") && date('N', $timestamp) == 2) {
			$format = str_replace("%A", "terça-feira", $format);
		}

		return $format;
	}

	/**
	 * Verifica se a URL passada é uma imagem
	 * 
	 * @param string $str
	 * 
	 * @return string
	**/
	public static function isImage($str) 
	{
		$extensions = ['.jpg', '.jpeg', '.jpe', '.jif', '.jfif', '.jfi', '.png', '.gif', '.web', '.tiff', 'tif','.bmp', '.svg'];

		return \Str::endsWith($str, $extensions);
	}

	/**
	 *	Retorna a extensão da URL passada.
	 * 
	 * @param string $str
	 * 
	 * @return string 
	**/
	public static function getExtension($str) 
	{
		return pathinfo($str, PATHINFO_EXTENSION);
	}

	/**
	 *	Converte o URL da image passada para base64.
	 * 
	 * @param string $imagePath
	 * 
	 * @return string
	**/
	public static function imageToBase64($imagePath) 
	{
		$type = pathinfo($imagePath, PATHINFO_EXTENSION);
		$data = file_get_contents($imagePath);

		return 'data:image/' . $type . ';base64,' . base64_encode($data);
	}

	/**
	 * Substitui uma chave de um array por outra.
	 * 
	 * @param array $array
	 * @param string $oldKey
	 * @param string $newKey
	 * 
	 * @return array
	 */
	public static function replaceKey($array, $oldKey, $newKey) {

	    if (! array_key_exists($oldKey, $array)) {
	        return $array;
	    }

	    $keys = array_keys($array);
	    $keys[array_search($oldKey, $keys)] = $newKey;

	    return array_combine($keys, $array);
	}

	/**
	 * Renderiza os atributos HTML passados em forma de array associativo 
	 * como atributos de tag HTML.
	 * 
	 * @param array $attributes
	 * 
	 * @return string
	 */
	public static function renderAttributes($attributes)
	{
		$attr = '';

		foreach($attributes as $key => $value) {
			$attr .= "$key=\"$value\"";

			if (array_key_last($attributes) != $key) {
				$attr .= ' ';
			}
		}

		return $attr;
	}

	/**
	 * Verifica se o valor passado é em formato monetário BRL.
	 * 
	 * @param string $str 
	 *
	 * @return boolean
	 **/
	public static function isValueBRL($str) 
	{
		return !! preg_match('/^R\$\ ?(\d{1,3}(\.\d{3})*|\d+)(\,\d{2})?$/', $str);
	}

	/**
	 * Emite várias flash messages passadas em forma de array.
	 *
	 * @param array $data
	 *
	 * @return void
	 **/
	public static function flash(array $data)
	{
		foreach ($data as $key => $value) {
			session()->flash($key, $value);
		}
	}

	/**
	 * Retorna uma mensagem de cumprimento de acordo com a hora do dia,
	 * tendo como padrão de comparação a hora atual. 
	 *
	 * @param \Carbon\Carbon $datetime
	 *
	 * @return string
	 **/
	public static function getComplimentByTime($datetime = null)
	{
		if ($datetime === null)
			$datetime = Carbon::now();

		$carbon5h30m = Carbon::createFromTimeString('05:30');
		$carbon12h = Carbon::createFromTimeString('12:00');
		$carbon18h = Carbon::createFromTimeString('18:00');
		$carbon24h = Carbon::createFromTimeString('23:59');

		if ($datetime->between($carbon5h30m, $carbon12h)) {
			return 'Bom dia, boas-vindas novamente.';
		} else if ($datetime->between($carbon12h, $carbon18h)) {
			return 'Boa tarde, boas-vindas novamente.';
		} else if ($datetime->between($carbon18h, $carbon24h)) {
			return 'Boa noite, boas-vindas novamente.';
		} else {
			return 'Boa madrugada, boas-vindas novamente.';
		}
	}
}