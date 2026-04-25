<?php

namespace Modules\Superadmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'custom_permissions' => 'array',
    ];

    /**
     * Accessor: is_popular (alias de mark_package_as_popular)
     */
    public function getIsPopularAttribute()
    {
        return (bool) $this->mark_package_as_popular;
    }

    /**
     * Accessor: símbolo de moneda (USD por defecto)
     */
    public function getCurrencyAttribute()
    {
        return '$';
    }

    /**
     * Accessor: precio anual con 20% de descuento
     */
    public function getAnnualPriceAttribute()
    {
        return round($this->price * 12 * 0.8, 2);
    }

    /**
     * Scope a query to only include active packages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Returns the list of active pakages
     *
     * @return object
     */
    public static function listPackages($exlude_private = false)
    {
        $packages = Package::active()
                        ->orderby('sort_order');

        if ($exlude_private) {
            $packages->notPrivate();
        }

        return $packages->get();
    }

    /**
     * Scope a query to exclude private packages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotPrivate($query)
    {
        return $query->where('is_private', 0);
    }
}
