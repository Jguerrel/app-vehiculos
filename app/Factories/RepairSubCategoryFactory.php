<?php

namespace App\Factories;
use App\Models\RepairSubCategory;
use Illuminate\Database\Eloquent\Collection;



class RepairSubCategoryFactory {

    public function getRepairSubCategoryWithRelationShip(): Collection
    {
        return RepairSubCategory::with('repaircategory')->orderBy('id', 'DESC')->get();

    }

    public function findModelWithId(int $id): RepairSubCategory
    {
      return RepairSubCategory::findOrFail($id);
    }

    public function updateModel(array $data, $model): bool
    {
      $model->name = $data['name'];
      $model->repair_category_id = $data['repair_category_id'];

      return $model->save();
    }

}
