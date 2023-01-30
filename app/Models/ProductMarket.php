<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMarket extends Model {
    use HasFactory;

    protected $fillable = ['title', 'image', 'description'];

    public function categories() {
        return $this->belongsToMany(CategoryMarket::class, 'category_product_market', 'product_market_id', 'category_market_id');
    }

    /**
     * Cateroies not linked with this product
     */
    public function categoriesAvailable($filter = null) {
        $categories = CategoryMarket::whereNotIn('category_markets.id', function ($query) {
            $query->select('category_product_market.category_market_id');
            $query->from('category_product_market');
            $query->whereRaw("category_product_market.product_market_id={$this->id}");
        })
            ->where(function ($queryFilter) use ($filter) {
                if ($filter)
                    $queryFilter->where('categories.name', 'LIKE', "%{$filter}%");
            })
            ->paginate();

        return $categories;
    }
}
