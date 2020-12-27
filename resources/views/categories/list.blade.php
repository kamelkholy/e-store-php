@extends('base')

@section('main')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Categories</h3>
        </div>
        <div class="panel-body">
            <a href="{{route('categories.create')}}" class="btn btn-primary"> Add New</a>
            </br>
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
            </br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Sort Order</th>
                        <th>Actions</th>
                    </tr>
                    @foreach($data as $row)
                    <tr>
                        <td>
                            <img src="{{route('categories.show', [$row->id])}}" class="img-thumbnail" width="75" />
                        </td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->sortOrder }}</td>
                        <td>
                            <form action="{{route('categories.destroy', [$row->id])}}" method="POST">
                                @csrf
                                {{ method_field('DELETE') }}
                                <a href="{{route('categories.edit', [$row->id])}}" class="btn-sm btn-secondary"><i class="fa fa-edit"></i></a>
                                <button type="submit" class="btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection