@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card" style="margin-left: 200px; margin-right: 200px">
            <div class="card-header">
                Add Product
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('products.store') }}" id="product_form" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" autofocus/>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="desc"/>
                        @if ($errors->has('desc'))
                            <span class="text-danger">{{ $errors->first('desc') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image" id="image"/>
                        <div class="holder mt-2">
                            <img id="imgPreview" src="" alt="pic" height="100" width="100" style="display: none"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" name="price"/>
                        @if ($errors->has('price'))
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Brand</label>
                        <select name="brand_id" class="form-select">
                            <option selected disabled>Select...</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('brand_id'))
                            <span class="text-danger">{{ $errors->first('brand_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-select" id="category_id">
                            <option selected disabled>Select...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category_id'))
                            <span class="text-danger">{{ $errors->first('category_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group" id="sub_cat_div">
                    </div>

                    <button type="submit" class="btn btn-block btn-success mt-2" style="float: right" id="btn_save">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
$(document).on('change', '#category_id', function (){
    var category_id = $(this).val();
    $.ajax({
        method: "POST",
        url: "{{ url('seller/sub_categories') }}",
        data: {
            "_token": "{{ csrf_token() }}",
            'category_id': category_id,
        },
        success: function(res) {
            if(res.sub_cats.length != 0){
                var options = "";
                $(res.sub_cats).each(function (index, val){
                    var sub_cat_id = val.id;
                    var sub_cat_name = val.name;
                    options += `<option value="${sub_cat_id}">${sub_cat_name}</option>`;
                })
                var html = `<label>Sub Category</label>
                        <select name="sub_category_id" class="form-select" id="sub_category_id">
                            <option selected disabled>Select...</option>
                            ${options}
                        </select>`;
                $("#sub_cat_div").html(html);
            }
            else{
                $("#sub_cat_div").html("");
            }
        },
        error: function() {

        }
    });
})

$(document).on('click', "#btn_save", function (e){
    e.preventDefault();
    $("#product_form").validate({
        rules: {
            name : {
                required: true,
            },
            desc : {
                required: true,
            },
            brand_id : {
                required: true,
            },
            category_id: {
                required: true,
            },
            sub_category_id: {
                required: true,
            },
            price: {
                required: true,
            },
            image: {
                required: true,
                accept: "image/*"
            }
        },
        messages: {
            name: {
                required: "Please enter product name."
            },
            image: {
                accept: "Please enter only image."
            },
            desc: {
                required: "Please enter product description."
            },
            brand_id: {
                required: "Please select brand name."
            },
            category_id: {
                required: "Please select product category."
            },
            sub_category_id: {
                required: "Please select product sub category."
            },
        }
    });

    if($("#product_form").valid()){
        $("#product_form").submit();
    }
})

$('#image').change(function(){
    $('#imgPreview').hide();

    const file = this.files[0];
    if (file){
        let reader = new FileReader();
        reader.onload = function(event){
            $('#imgPreview').attr('src', event.target.result).show();
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
