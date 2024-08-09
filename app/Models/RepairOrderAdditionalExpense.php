<?php

namespace App\Models;

use App\Enum\SupplierEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairOrderAdditionalExpense extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repair_order_additional_expenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'repair_order_id',
        'additional_expense_account_id',
        'supplier',
        'amount',
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'created_at_formatted',
        'order_name',
        'expense_name',
        'supplier_name',
    ];


    /**
     * Get the created at formatted
     *
     * @return string
     */
    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at?->format('d-m-Y');
    }

    public function getOrderNameAttribute(): string
    {
        $id = $this->repairOrder?->id;
        $workshop = $this->repairOrder?->workshop?->name;
        return '000' . $id . ' - ' . $workshop;
    }

    public function getExpenseNameAttribute(): ?string
    {
        return $this->additionalExpense?->account_name;
    }

    public function getSupplierNameAttribute(): string
    {
        return SupplierEnum::getName($this->supplier);
    }

    /**
     * orden de reparación
     *
     * @return BelongsTo
     */
    public function repairOrder(): BelongsTo
    {
        return $this->belongsTo(RepairOrder::class);
    }

    /**
     * gasto adicional
     *
     * @return BelongsTo
     */
    public function additionalExpense(): BelongsTo
    {
        return $this->belongsTo(AdditionalExpenseAccount::class, 'additional_expense_account_id');
    }
}
