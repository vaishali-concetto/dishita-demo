<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Seller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
       /* $this->middleware('guest:admin');
        $this->middleware('guest:customer');
        $this->middleware('guest:seller');*/
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showAdminRegisterForm()
    {
        return view('auth.admin.register', ['title'=>'Admin']);
    }

    protected function createAdmin(Request $request)
    {
//        $this->validator($request->all())->validate();
        $this->validate($request, [
            'first_name'   => 'required|max:255',
            'last_name'   => 'required|max:255',
            'email'   => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type' => "Admin",
        ]);

        $user->assignRole('admin');

//        return redirect('admin');
        return redirect('/admin/dashboard');
    }

    public function showCustomerRegisterForm()
    {
        return view('auth.customer.register', ['title'=>'Customer']);
    }

    protected function createCustomer(Request $request)
    {
//        $this->validator($request->all())->validate();
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone' => 'required|digits:10|unique:customers',
            'email'   => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type' => "Customer",
        ]);

        $customer = Customer::create([
            'gender' => $request['gender'],
            'phone' => $request['phone'],
            'user_id' => $user->id,
        ]);

        $user->assignRole('customer');

//        return redirect()->intended('customer');
        return redirect('/customer/dashboard');
    }

    public function showSellerRegisterForm()
    {
        return view('auth.seller.register', ['title'=>'Seller']);
    }

    protected function createSeller(Request $request)
    {
//        $this->validator($request->all())->validate();
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'email'   => 'required|email|unique:users|max:255',
            'duns' => 'required|alpha_num',
            'ein' => 'required|alpha_num',
            'web_url' => 'required|url',
            'phone' => 'required|digits:10|unique:sellers',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type' => "Seller",
        ]);

        $seller = Seller::create([
            'company_name' => $request['company_name'],
            'duns' => $request['duns'],
            'ein' => $request['ein'],
            'web_url' => $request['web_url'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'state' => $request['state'],
            'city' => $request['city'],
            'zipcode' => $request['zipcode'],
            'user_id' => $user->id
        ]);
        $user->assignRole('seller');

//        return redirect()->intended('seller');
        return redirect('/seller/dashboard');
    }
}
