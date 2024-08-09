<?php

namespace App\Factories;

use App\Models\AdditionalExpenseAccount;
use Illuminate\Database\Eloquent\Collection;

final class AdditionalExpenseAccountFactory
{
    /**
     * Obtiene todos los registros disponibles
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return AdditionalExpenseAccount::all();
    }

    /**
     * Crear un registro
     *
     * @param array $data       datos a almacenar
     * @return AdditionalExpenseAccount       el registro creado
     */
    public function store(array $data): AdditionalExpenseAccount
    {
        return AdditionalExpenseAccount::create($data);
    }

    /**
     * Crear un registro
     *
     * @param array $data                           datos a almacenar
     * @param AdditionalExpenseAccount $model       el registro a actualizar
     * @return AdditionalExpenseAccount             el registro actualizado
     */
    public function update(array $data, AdditionalExpenseAccount $model): bool
    {
        return $model->update($data);
    }
}
