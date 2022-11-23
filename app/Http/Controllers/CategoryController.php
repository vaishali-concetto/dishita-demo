<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasPermissionTo('view category')) {
            $categories = Category::all();
            $logout = route('seller.logout');

            return view('category.list', compact('categories', 'logout'));
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
        if (Auth::user()->hasPermissionTo('add category')) {
            $categories = Category::get();
            $logout = route('seller.logout');

            return view('category.create', compact('logout', 'categories'));
        }
        return redirect()->route("seller.login-view");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveCategory $request)
    {
        if (Auth::user()->hasPermissionTo('add category')) {
            $Category = Category::create($request->all());
            return redirect('seller/categories')->with('success', 'Category added successfully.');
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
        if (Auth::user()->hasPermissionTo('edit category')) {
            $Category = Category::findOrFail($id);
            $categories = Category::get();
            $logout = route('seller.logout');

            return view('category.edit', compact('Category', 'categories', 'logout'));
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
    public function update(SaveCategory $request, $id)
    {
        if (Auth::user()->hasPermissionTo('edit category')) {
            $updateData = [
                'name' => $request->name,
                'parent_category_id' => isset($request->parent_category_id) ? $request->parent_category_id : 0,
            ];
            Category::whereId($id)->update($updateData);
            return redirect('seller/categories')->with('success', 'Category updated successfully.');
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
        if (Auth::user()->hasPermissionTo('delete category')) {
            $Category = Category::findOrFail($id);
            $Category->delete();
            return redirect('seller/categories')->with('success', 'Category deleted successfully.');
        }
        return redirect()->route("seller.login-view");
    }
}
