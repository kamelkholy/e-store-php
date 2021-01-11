@extends('base')

@section('main')
<div class="container">
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
    <br />

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Edit Type</h3>
        </div>
        <div class="panel-body">
            <br />
            <form method="post" action="{{ route('types.update', [$data->id]) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Name</label>
                        <div class="col-md-4">
                            <input type="text" name="name" value="{{$data->name}}" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Arabic Name</label>
                        <div class="col-md-4">
                            <input type="text" name="name_ar" value="{{$data->name_ar}}" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Sort Order</label>
                        <div class="col-md-4">
                            <input type="text" name="sortOrder" value="{{$data->sortOrder}}" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection