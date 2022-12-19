<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairOrder extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repair_orders';

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'workshop_id',
        'send_date',
        'status',
    ];

    /**
     * Get the vehicle that owns the repair order.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the user that owns the repair order.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the workshop that owns the repair order.
     */
    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    /**
     * Get the repair for the repair order.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(RepairCategory::class, 'repair_vehicle_categories', 'repair_order_id', 'repair_category_id');
    }

    /**
     * Devolver las subcategorias de la orden de reparación
     */
    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(RepairSubcategory::class, 'repair_vehicle_categories', 'repair_order_id', 'repair_sub_category_id')->withPivot(['cost']);
    }

    /**
     * Get the quotation for the repair order.
     */
    public function quotation(): HasOne
    {
        return $this->hasOne(Quotation::class, 'repair_order_id');
    }
}
