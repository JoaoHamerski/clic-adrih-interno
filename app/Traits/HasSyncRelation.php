<?php 

namespace App\Traits;

trait HasSyncRelation {
    /**
     * Sincroniza o array $requestItems com os registro de uma 
     * relação de Um para Muitos.
     * 
     * @param array $requestItems Requisição com os registros
     * @param string $relationmethod Método que faz a relação hasMany no Model usado.
     *
     * @return void
     **/
	public function sync(array $requestItems, $relationMethod)
	{
		$itemIds = $this->{$relationMethod}->pluck('id')->toArray();
        $requestIds = [];

        foreach ($requestItems as $requestItem) {
            if (isset($requestItem['id']) && in_array($requestItem['id'], $itemIds)) {
                $requestIds[] = $requestItem['id'];

                $this->$relationMethod()
                    ->find($requestItem['id'])
                    ->update($requestItem);
            } else {
                $this->$relationMethod()
                    ->create($requestItem);
            }
        }

        if (! empty($idsToDelete = array_diff($itemIds, $requestIds))) {
            $this->$relationMethod()->whereIn('id', $idsToDelete)->delete();
        }
	}
}