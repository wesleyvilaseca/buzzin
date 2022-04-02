<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CategoryProductController extends Controller
{
    protected $product, $category;

    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;

        // $this->middleware(['can:products']);
    }

    public function categories($product_id)
    {
        $product = $this->product->find($product_id);
        if (!$product)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Categorias produto ' . $product->title;
        $data['toptitle']           = 'Categorias produto ' . $product->title;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Categorias vinculadas produto ' . $product->title, 'active' => true];
        $data['prod']               = true;
        $data['categories']         = $product->categories()->paginate();
        $data['product']            = $product;

        return view('admin.products.categories.categories', $data);
    }

    public function categoriesAvailable(Request $request, $product_id)
    {
        $product = $this->product->find($product_id);
        if (!$product)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Categorias produto ' . $product->title;
        $data['toptitle']           = 'Categorias produto ' . $product->title;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('product.categories', $product->id) , 'title' => 'Categorias vinculadas produto ' . $product->title];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Categorias produto ' . $product->title, 'active' => true];
        $data['filters'] = $request->except('_token');
        $data['categories'] = $product->categoriesAvailable($request->filter);
        $data['prod']               = true;
        $data['product'] = $product;

        return view('admin.products.categories.available', $data);
    }

    public function products($idCategory)
    {
        if (!$category = $this->category->find($idCategory)) {
            return redirect()->back();
        }

        $products = $category->products()->paginate();

        return view('admin.pages.categories.products.products', compact('category', 'products'));
    }

    public function attachCategoriesProduct(Request $request, $product_id)
    {
        $product = $this->product->find($product_id);
        if (!$product) 
            return Redirect::back()->with('error', 'Operação não autorizada');

        if (!$request->categories || count($request->categories) == 0) 
            return Redirect::back()->with('warning', 'Precisa escolher pelo menos uma permissão');
        
        $product->categories()->attach($request->categories);

        return Redirect::route('product.categories', $product->id);
    }

    public function detachCategoryProduct($idProduct, $idCategory)
    {
        $product = $this->product->find($idProduct);
        $category = $this->category->find($idCategory);

        if (!$product || !$category) 
            return Redirect::back()->with('error', 'Operação não autorizada');
        
        $product->categories()->detach($category);

        return Redirect::route('product.categories', $product->id);
    }
}
