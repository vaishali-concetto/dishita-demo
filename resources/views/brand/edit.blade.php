@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card" style="margin-left: 200px; margin-right: 200px">
            <div class="card-header">
                Edit Brand
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('brands.update', $Brand->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $Brand->name }}" autofocus/>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-block btn-success mt-2" style="float: right">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
