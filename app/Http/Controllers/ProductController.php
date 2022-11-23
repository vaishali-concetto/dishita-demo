<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProduct;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasPermissionTo('view product')) {
            $products = Product::all();
            $logout = route('seller.logout');

            return view('product.list', compact('products', 'logout'));
        }
        return redirect()->route("seller.login-view");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasPermissionTo('add product')) {
            $logout = route('seller.logout');
            $brands = Brand::all();
            $categories = Category::where('parent_category_id', 0)->get();

            return view('product.create', compact('logout', 'brands', 'categories'));
        }
        return redirect()->route("seller.login-view");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveProduct $request)
    {
        if (Auth::user()->hasPermissionTo('add product')) {
            $Product = Product::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'brand_id' => $request->brand_id,
            ]);

            $product_cat = ProductCategory::create([
                'product_id' => $Product->id,
                'category_id' => $request->category_id,
            ]);

            if (isset($request->sub_category_id) && $request->sub_category_id != "") {
                $product_sub_cat = ProductCategory::create([
                    'product_id' => $Product->id,
                    'category_id' => $request->sub_category_id,
                    'is_sub' => 1
                ]);
            }

            return redirect('seller/products')->with('success', 'Product added successfully.');
        }
        return redirect()->route("seller.login-view");
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
        if (Auth::user()->hasPermissionTo('edit product')) {
            $data['Product'] = Product::findOrFail($id);
            $data['Product_cat'] = ProductCategory::where('product_id', $id)->where('is_sub', 0)->first();
            $data['Product_sub_cat'] = ProductCategory::where('product_id', $id)->where('is_sub', 1)->first();
            $data['logout'] = route('seller.logout');
            $data['brands'] = Brand::all();
            $data['categories'] = Category::where('parent_category_id', 0)->get();
            if (!empty($data['Product_sub_cat'])) {
                $data['sub_cats'] = Category::where('parent_category_id', $data['Product_cat']->category_id)->get(['id', 'name']);
            }

            return view('product.edit', $data);
        }
        return redirect()->route("seller.login-view");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveProduct $request, $id)
    {
        if (Auth::user()->hasPermissionTo('edit product')) {
            $updateData = [
                'name' => $request->name,
                'desc' => $request->desc,
                'brand_id' => $request->brand_id,
            ];
            Product::whereId($id)->update($updateData);

            $updateData = [
                'category_id' => $request->category_id,
            ];
            ProductCategory::where('product_id', $id)->where('is_sub', 0)->update($updateData);

            $sub_cat = ProductCategory::where('product_id', $id)->where('is_sub', 1)->first();
            if (isset($request->sub_category_id) && $request->sub_category_id != "") {
                if (empty($sub_cat)) {
                    $sub_cat = new ProductCategory();
                    $sub_cat->product_id = $id;
                    $sub_cat->is_sub = 1;
                }
                $sub_cat->category_id = $request->sub_category_id;
                $sub_cat->save();
            } else {
                if (!empty($sub_cat)) {
                    $sub_cat->delete();
                }
            }

            return redirect('seller/products')->with('success', 'Product updated successfully.');
        }
        return redirect()->route("seller.login-view");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->hasPermissionTo('delete product')) {
            $Product = Product::findOrFail($id);
            $Product->delete();
            $Product_cats = ProductCategory::where('product_id', $id)->delete();

            return redirect('seller/products')->with('success', 'Product deleted successfully.');
        }
        return redirect()->route("seller.login-view");
    }

    public function sub_categories(Request $request){
        $category_id = $request->category_id;
        $sub_cats = Category::where('parent_category_id', $category_id)->get(['id', 'name']);
        return ['sub_cats' => $sub_cats];
    }
}
