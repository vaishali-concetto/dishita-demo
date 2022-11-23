@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card" style="margin-left: 200px; margin-right: 200px">
            <div class="card-header">
                Edit Category
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('categories.update', $Category->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $Category->name }}"/>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Parent Category</label>
                        <select name="parent_category_id" class="form-select">
                            <option selected disabled>Select...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($Category->parent_category_id == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-block btn-success mt-2" style="float: right">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
