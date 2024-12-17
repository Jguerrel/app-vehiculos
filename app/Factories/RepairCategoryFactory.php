<?php

namespace App\Factories;
use App\Models\RepairCategory;
use Illuminate\Database\Eloquent\Collection;


class RepairCategoryFactory {

    public function getAllRepairCategory(): Collection
    {
        return RepairCategory::orderBy('id', 'DESC')->get(['id', 'name']);

    }

}
