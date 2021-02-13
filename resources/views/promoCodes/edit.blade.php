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
            <h3 class="panel-title">Edit PromoCode</h3>
        </div>
        <div class="panel-body">
            <br />
            <form method="post" action="{{ route('promoCodes.update', [$data->id]) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Code</label>
                        <div class="col-md-10">
                            <input type="text" value="{{$data->code}}" name="code" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Included Products</label>
                        <div class="col-md-10">
                            <select onchange="toggleSelection(this.value)" class="custom-select" name="applicability">
                                <option value="all" @if($data->applicability == 'all')selected @endif> All Products</option>
                                <option value="some" @if($data->applicability == 'some')selected @endif> Select Products</option>
                                <option value="categories" @if($data->applicability == 'categories')selected @endif> Select Categories</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Discount Type</label>
                        <div class="col-md-4">
                            <select class="custom-select" name="discount_type">
                                <option value="percentage" @if($data->discount_type == 'percentage') selected @endif> Percentage %</option>
                                <option value="ammount" @if($data->discount_type == 'ammount') selected @endif> Ammount</option>
                            </select>
                        </div>
                        <label class="col-md-2" align="right">Discount</label>
                        <div class="col-md-4">
                            <input type="number" value="{{$data->discount}}" name="discount" class="form-control" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Start Date</label>
                        <div class="col-md-4">
                            <input type="date" value="{{$data->start_date['date']}}" name="start_date[date]" class="form-control" required />
                        </div>
                        <label class="col-md-2" align="right">Start Time <small class="text-muted">(10:00 AM)</small></label>
                        <div class="col-md-4">
                            <input type="time" value="{{$data->start_date['time']}}" name="start_date[time]" class="form-control" required />
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">End Date</label>
                        <div class="col-md-4">
                            <input type="date" value="{{$data->end_date['date']}}" name="end_date[date]" class="form-control" required />
                        </div>
                        <label class="col-md-2" align="right">End Time <small class="text-muted">(10:00 PM)</small></label>
                        <div class="col-md-4">
                            <input type="time" value="{{$data->end_date['time']}}" name="end_date[time]" class="form-control" required />
                        </div>
                    </div>
                </div>


                <div id="select-products" class="container px-1 px-md-4 py-5 mx-auto" style="display: none;">
                    <h6>Select Products</h6>
                    <div class="card p-4">
                        <div class="row">
                            <input class="form-control" type="text" id="filterProducts" onkeyup="filterProductsInputs()" placeholder="Search for products..">
                        </div>
                        <hr>
                        <div id="all-products" class="row pt-2">
                            @foreach($products as $product)
                            <div id="product-{{$product->id}}" class="col-6 form-check">
                                <input name="products[]" class="form-check-input" type="checkbox" id="{{$product->id}}" value="{{$product->id}}" @if(array_search($product->id, $data->products) !== false) checked @endif>
                                <label id="{{$product->id}}" class="form-check-label" for="{{$product->id}}">{{$product->name}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div id="select-categories" class="container px-1 px-md-4 py-5 mx-auto" style="display: none;">
                    <h6>Select Categories</h6>
                    <div class="card p-4">
                        <div class="row">
                            @foreach($categories as $category)
                            <div class="col-6 py-1">
                                <ul>
                                    <li class="list-group-item list-group-item-info">
                                        <div class="form-check">
                                            <input name="categories[]" class="form-check-input" type="checkbox" id="cat-{{$category['id']}}" value="{{$category['id']}}" @if(array_search($category['id'], $data->categories) !== false) checked @endif>
                                            <label class="form-check-label" for="cat-{{$category['id']}}">{{$category['name']}}</label>
                                        </div>
                                    </li>

                                    {!!$category['html']!!}

                                </ul>
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
<script>
    $(document).ready(function() {
        let applicability = "{{$data->applicability}}"
        toggleSelection(applicability);
    })

    function toggleSelection(type) {
        switch (type) {
            case 'some':
                $('#select-products').show();
                $('#select-categories').hide();
                break;
            case 'categories':
                $('#select-categories').show();
                $('#select-products').hide();
                break;
            default:
                $('#select-products').hide();
                $('#select-categories').hide();
                break;
        }
    }
</script>
@endsection