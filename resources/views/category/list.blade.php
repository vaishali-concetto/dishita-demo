@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif

        <a class="btn btn-success mb-2" style="float: right" href="{{ route('categories.create') }}">Add Category</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $i=1; ?>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $category->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('categories.edit', $category->id)}}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id)}}" method="post" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit" id="btn_delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php $i++; ?>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
{{--
<script type="text/javascript">
$(document).on('click', '#btn_delete', function (e){
    e.preventDefault();
    $(this).parents('form:first').submit();
})
</script>
--}}
@endsection
