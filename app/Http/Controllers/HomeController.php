<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all();
        return view('web.home', compact('products'));
    }

    public function AdminDashboard(){
        if (Auth::user()->hasPermissionTo('dashboard')) {
            $logout = route('admin.logout');
            return view('auth.admin.dashborad', compact('logout'));
        }
        return redirect()->route("admin.login-view");
    }

    public function CustomerDashboard(){
        if (Auth::user()->hasPermissionTo('customer_dashboard')) {
            $logout = route('customer.logout');
            return view('auth.customer.dashborad', compact('logout'));
        }
        return redirect()->route("customer.login-view");
    }

    public function SellerDashboard(){
        if (Auth::user()->hasPermissionTo('seller_dashboard')) {
            $logout = route('seller.logout');
            return view('auth.seller.dashborad', compact('logout'));
        }
        return redirect()->route("seller.login-view");
    }

    public function product_detail($id){
        $data['product'] = Product::with('brand')->where('id', $id)->first();
        $data['product_cat'] = ProductCategory::with('category')->where('product_id', $id)->where('is_sub', 0)->first();
        $data['product_sub_cat'] = ProductCategory::with('category')->where('product_id', $id)->where('is_sub', 1)->first();
//        dd($product_cat->toArray());
        return view('web.product_detail', $data);
    }
}
