<?php

namespace App\Util;

use \Carbon\Carbon;

class Formatter {

	public static function getFormatted($options, array $data) 
	{
		foreach ($options as $keys => $method) {
			foreach (explode('|', $keys) as $index => $key) {
				if (!! strpos($key, '.')) {
					$keys = explode('.', $key);
					
					if (isset($data[$keys[0]])) {
						foreach ($data[$keys[0]] as $index => $value) {
							if (isset($data[$keys[0]][$index][$keys[1]]))
								$data[$keys[0]][$index][$keys[1]] = self::$method(
									$data[$keys[0]][$index][$keys[1]]
								);
						}
					}
				} else if (isset($data[$key])) {
					$data[$key] = self::$method($data[$key]);
				}
			}
		}

		return $data;
	}

	/**
	 * Remove qualquer caractere que não é um digito da string
	 * 
	 * @param string $str
	 * @return string or null
	 */
	public static function stripNonDigits($str)
	{
		 return $str != null ? preg_replace('/\D/', '', $str) : null;
	}

	/**
	 * Formata um nome passado:
	 * - Removendo todos espaços duplos ou mais.
	 * - Capitalizando as palavras com algumas exceções.
	 * 
	 * @param string $str
	 * @return string
	 */
	public static function name($str)
	{
		$str = mb_strtolower($str, mb_detect_encoding($str));
		$str = trim(preg_replace('/\s+/', ' ', $str));

		return Helper::ucsentence($str, ['da', 'do', 'das', 'dos', 'de', "d'"]);
	}

	/**
	 * Formata o valor em dinheiro BRL para o formato padrão.
	 * 
	 * Ex.: R$ 123,45 => 123.45
	 * 
	 * @param string $str
	 * @return string or null
	 */
	public static function money($str)
	{
		$str = str_replace(' ', '', $str);
		$str = str_replace('.', '', $str);
		$str = str_replace(',', '.', $str);
		$str = filter_var(
			$str, 
			FILTER_SANITIZE_NUMBER_FLOAT, 
			FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND
		);

		return (! empty($str) ? $str : null);	
	}

	/**
	 * Retorna um instância de carbon para a data passada em formado de d/m/Y
	 * 
	 * @param string $date Data em formato d/m/Y
	 * @return \Carbon\Carbon || string $date
	 */
	public static function date($date)
	{
		if (! preg_match('/^[0-9]{2}[-|\/]{1}[0-9]{2}[-|\/]{1}[0-9]{4}$/', $date))
			return $date;

		return Carbon::createFromFormat('d/m/Y', $date)->toDateString();
	}

	/**
	 * Wrapper utilizado para fazer o hash de senhas através da classe Formatter
	 *
	 * @param string $str 
	 *
	 * @return string
	 **/
	public static function bcrypt($str) 
	{
		return bcrypt($str);
	}
}