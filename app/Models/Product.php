<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use TenantTrait;
    use HasFactory;

    protected $fillable = ['title', 'flag', 'price', 'stock_controll', 'quantity', 'status', 'description', 'image'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    /**
     * Cateroies not linked with this product
     */
    public function categoriesAvailable($filter = null)
    {
        $categories = Category::whereNotIn('categories.id', function($query) {
            $query->select('category_product.category_id');
            $query->from('category_product');
            $query->whereRaw("category_product.product_id={$this->id}");
        })
        ->where(function ($queryFilter) use ($filter) {
            if ($filter)
                $queryFilter->where('categories.name', 'LIKE', "%{$filter}%");
        })
        ->paginate();

        return $categories;
    }

    public function search($filter = null)
    {
        $results = $this->where([
            ['name', 'LIKE', "%{$filter}%"],
            // ['tenant_id', '=', auth()->user()->tenant_id]
        ])
            ->orWhere([
                ['description', 'LIKE', "%{$filter}%"],
                // ['tenant_id', '=', auth()->user()->tenant_id]
            ])
            ->paginate();

        return $results;
    }
}
