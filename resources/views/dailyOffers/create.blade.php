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
            <h3 class="panel-title">Add DailyOffer</h3>
        </div>
        <div class="panel-body">
            <br />
            <form method="post" action="{{ route('dailyOffers.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Name</label>
                        <div class="col-md-4">
                            <input type="text" name="name" class="form-control" required />
                        </div>
                        <label class="col-md-2" align="right">Day Of The Offer</label>
                        <div class="col-md-4">
                            <input type="date" name="date" class="form-control" required />
                        </div>
                    </div>
                </div>


                <div id="select-products" class="container px-1 px-md-4 py-5 mx-auto">
                    <h6>Select Products</h6>
                    <div class="card p-4">
                        <div class="row">
                            <input class="form-control" type="text" id="filterProducts" onkeyup="filterProductsInputs()" placeholder="Search for products..">
                        </div>
                        <hr>
                        <div id="all-products" class="row pt-2">
                            @foreach($products as $product)
                            <div id="product-{{$product->id}}" class="col-6 form-check">
                                <input name="products[]" class="form-check-input" type="checkbox" id="{{$product->id}}" value="{{$product->id}}">
                                <label id="{{$product->id}}" class="form-check-label" for="{{$product->id}}">{{$product->name}}</label>
                            </div>
                            @endforeach
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