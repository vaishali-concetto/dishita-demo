<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest')->except(['logout', 'adminLogout', 'customerLogout', 'sellerLogout']);
//        $this->middleware('guest:admin')->except('adminLogout');
//        $this->middleware('guest:customer')->except('customerLogout');
//        $this->middleware('guest:seller')->except('sellerLogout');
    }

    public function showAdminLoginForm()
    {
        Auth::logout();
        return view('auth.login', ['url' => route('admin.login'), 'title'=>'Admin', 'register' => route('admin.register-view')]);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect()->intended('/admin/dashboard');
        }

//        Session::flash('error', 'Invalid credentials!!');
        notify()->error('Invalid credentials!!');

        return back()->withInput($request->only('email', 'remember'));
    }

    public function adminLogout(){
        Auth::logout();
        return redirect()->route('admin.login-view');
    }

    public function showCustomerLoginForm()
    {
        Auth::logout();
        return view('auth.login', ['url' => route('customer.login'), 'title'=>'Customer', 'register' => route('customer.register-view')]);
    }

    public function customerLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect()->intended('/customer/dashboard');
        }

//        Session::flash('error', 'Invalid credentials!!');
        notify()->error('Invalid credentials!!');
        return back()->withInput($request->only('email', 'remember'));
    }

    public function customerLogout(){
        Auth::logout();
        return redirect()->route('customer.login-view');
    }

    public function showSellerLoginForm()
    {
        Auth::logout();
        return view('auth.login', ['url' => route('seller.login'), 'title'=>'Seller', 'register' => route('seller.register-view')]);
    }

    public function sellerLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect()->intended('/seller/dashboard');
        }

//        Session::flash('error', 'Invalid credentials!!');
        notify()->error('Invalid credentials!!');

        return back()->withInput($request->only('email', 'remember'));
    }

    public function sellerLogout(){
        Auth::logout();
        return redirect()->route('seller.login-view');
    }
}
