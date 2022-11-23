<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
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
}
