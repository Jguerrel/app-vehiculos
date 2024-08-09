<?php

namespace App\Http\Controllers;

use App\Factories\AdditionalExpenseAccountFactory;
use App\Http\Requests\CreateAdditionalExpenseAccount;
use App\Http\Requests\UpdateAdditionalExpenseAccount;
use App\Models\AdditionalExpenseAccount;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdditionalExpenseAccountController extends Controller
{
    public function __construct(
        private AdditionalExpenseAccountFactory $factory
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('AdditionalExpenseAccount/Index', [
            'data' => $this->factory->getAll()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAdditionalExpenseAccount  $request
     * @return RedirectResponse
     */
    public function store(CreateAdditionalExpenseAccount $request): RedirectResponse
    {
        $this->factory->store($request->validated());

        return to_route('expense_account.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAdditionalExpenseAccount  $request
     * @param  AdditionalExpenseAccount  $account
     * @return RedirectResponse
     */
    public function update(
        UpdateAdditionalExpenseAccount $request,
        AdditionalExpenseAccount $account
    ): RedirectResponse {
        $this->factory->update($request->validated(), $account);

        return to_route('expense_account.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AdditionalExpenseAccount  $account
     * @return RedirectResponse
     */
    public function destroy(AdditionalExpenseAccount $account): RedirectResponse
    {
        if ($account->repairOrders->isNoTEmpty()) {
            return to_route('expense_account.index')
                ->with(['error' => 'No puede eliminar un gasto asociado a ordenes ya creadas']);
        }

        $account->delete();
        return to_route('expense_account.index');
    }
}
