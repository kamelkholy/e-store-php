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
            <h3 class="panel-title">Edit Store Settings</h3>
        </div>
        <div class="panel-body">
            <br />
            <form method="post" action="{{ route('storeSettings.update', [$data->id]) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Flat Shipping</label>
                        <div class="col-md-4">
                            <input type="text" name="flat_shipping" value="{{$data->flat_shipping}}" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Address</label>
                        <div class="col-md-4">
                            <input type="text" name="address" value="{{$data->address}}" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Email</label>
                        <div class="col-md-4">
                            <input type="email" name="email" value="{{$data->email}}" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Phone</label>
                        <div class="col-md-4">
                            <input type="text" name="phone" value="{{$data->phone}}" class="form-control" required />
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