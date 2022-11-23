@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Welcome, {{ \Illuminate\Support\Facades\Auth::user()->first_name }} {{ \Illuminate\Support\Facades\Auth::user()->last_name }}

                        <br><br>
                        <a href="{{ url('seller/categories') }}" style="color: darkblue; text-decoration: underline" class="m-1">Category</a>
                        <a href="{{ url('seller/brands') }}" style="color: darkblue; text-decoration: underline" class="m-1">Brand</a>
                        <a href="{{ url('seller/products') }}" style="color: darkblue; text-decoration: underline" class="m-1">Product</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
