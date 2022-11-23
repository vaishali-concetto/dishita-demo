<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveBrand;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasPermissionTo('view brand')) {
            $brands = Brand::all();
            $logout = route('seller.logout');

            return view('brand.list', compact('brands', 'logout'));
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
        if (Auth::user()->hasPermissionTo('add brand')) {
            $logout = route('seller.logout');

            return view('brand.create', compact('logout'));
        }
        return redirect()->route("seller.login-view");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveBrand $request)
    {
        if (Auth::user()->hasPermissionTo('add brand')) {
            $Brand = Brand::create($request->all());
            return redirect('seller/brands')->with('success', 'Brand added successfully.');
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
        if (Auth::user()->hasPermissionTo('edit brand')) {
            $Brand = Brand::findOrFail($id);
            $logout = route('seller.logout');

            return view('brand.edit', compact('Brand', 'logout'));
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
    public function update(SaveBrand $request, $id)
    {
        if (Auth::user()->hasPermissionTo('edit brand')) {
            $updateData = [
                'name' => $request->name,
            ];
            Brand::whereId($id)->update($updateData);
            return redirect('seller/brands')->with('success', 'Brand updated successfully.');
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
        if (Auth::user()->hasPermissionTo('delete brand')) {
            $Brand = Brand::findOrFail($id);
            $Brand->delete();
            return redirect('seller/brands')->with('success', 'Brand deleted successfully.');
        }
        return redirect()->route("seller.login-view");
    }
}
