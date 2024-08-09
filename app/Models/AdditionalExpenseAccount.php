<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdditionalExpenseAccount extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'additional_expense_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_number', 'account_name'];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['account_number' => 'integer'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['created_at_formatted'];


    /**
     * Get the created at formatted
     *
     * @return string
     */
    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at?->format('d-m-Y H:i A');
    }

    /**
     * Ordenes de reparación relacionadas
     *
     * @return HasMany
     */
    public function repairOrders(): HasMany
    {
        return $this->hasMany(RepairOrderAdditionalExpense::class);
    }
}
