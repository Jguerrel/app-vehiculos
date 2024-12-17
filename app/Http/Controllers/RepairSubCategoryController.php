<?php

namespace App\Http\Controllers;

use App\Models\RepairSubCategory;
use App\Http\Requests\{CreateSubCategoryRequest,EditRepairSubCategoryRequest};
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Factories\{RepairSubCategoryFactory,RepairCategoryFactory};

class RepairSubCategoryController extends Controller
{


    public function __construct(
        private RepairSubCategoryFactory $repairsubcategoryF,
        private RepairCategoryFactory $repaircategoryF,
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('RepairSubCategories/Index',[
            'repairsubcategories' => $this->repairsubcategoryF->getRepairSubCategoryWithRelationShip()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('RepairSubCategories/Create',[
            'repaircategories' =>$this->repaircategoryF->getAllRepairCategory(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(CreateSubCategoryRequest $request): RedirectResponse
    {
        RepairSubCategory::create([
            'name' => $request->name,
            'repair_category_id' => $request->repair_category_id,
        ]);

        return Redirect::route('repairsubcategories.index')->with('success', 'Sub Categoria agregada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('RepairSubCategories/Edit',[
            'repairsubcategory' => $this->repairsubcategoryF->findModelWithId($id),
            'repaircategories' =>$this->repaircategoryF->getAllRepairCategory(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRepairSubCategoryRequest $request, RepairSubCategory $repairsubcategory)
    {
        $this->repairsubcategoryF->updateModel($request->validated(),$repairsubcategory);

        return Redirect::route('repairsubcategories.index')->with('success', 'Subcategoria modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RepairSubCategory $repairsubcategory)
    {
        if($repairsubcategory->repairvehiclecategory->count() >= 1){
            return Redirect::route('repairsubcategories.index')->with('error', 'No se puede eliminar la subcategoria, tiene ordenes asociadas');
        }
        $repairsubcategory->delete();
        return Redirect::route('repairsubcategories.index')->with('success', 'Subcategoria eliminado con éxito');
    }
}
