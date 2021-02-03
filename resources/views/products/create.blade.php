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
            <h3 class="panel-title">Add Product</h3>
        </div>
        <div class="panel-body">
            <br />
            <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Name</label>
                        <div class="col-md-4">
                            <input type="text" name="name" class="form-control" required />
                        </div>
                        <label class="col-md-2" align="right">Name (Arabic)</label>
                        <div class="col-md-4">
                            <input type="text" name="name_ar" class="form-control" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Description</label>
                        <div class="col-md-10">
                            <textarea id="description" class="form-control" rows="4" cols="50" name="description" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">SKU</label>
                                <div class="col-md-8">
                                    <input type="text" name="sku" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Price</label>
                                <div class="col-md-8">
                                    <input type="number" name="price" class="form-control" step="0.01" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Quantity</label>
                                <div class="col-md-8">
                                    <input type="number" name="quantity" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Weight</label>
                                <div class="col-md-5">
                                    <input type="number" name="weight" class="form-control" />
                                </div>
                                <div class="col-md">
                                    <input type="text" placeholder="Class" name="weight_class" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Dimensions</label>
                                <div class="col-md">
                                    <input type="number" placeholder="Length" name="length" class="form-control" />
                                </div>
                                <div class="col-md">
                                    <input type="number" placeholder="Width" name="width" class="form-control" />
                                </div>
                                <div class="col-md">
                                    <input type="number" placeholder="Height" name="height" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Length Class</label>
                                <div class="col-md-8">
                                    <input type="text" name="length_class" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Sort Order</label>
                                <div class="col-md-8">
                                    <input type="number" name="sortOrder" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Tags</label>
                                <div class="col-md-8">
                                    <select name="tags[]" multiple class="form-control">
                                        @foreach($tags as $tag)
                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Discount</label>
                                <div class="col-md-4">
                                    <input type="number" name="discount" class="form-control" />
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="col-md-2 form-check-input" type="checkbox" id="enable_discount" name="enable_discount">
                                    <label class=" col-md-2 form-check-label" for="enable_discount">
                                        Enabled
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Shipping Type</label>
                                <div class="col-md-8">
                                    <select class="form-control" id="shipping" name="shippingType" required>
                                        <option value="" selected>Select</option>
                                        <?php
                                        $shippingTypes = config('app.shipping_types');
                                        ?>
                                        @foreach($shippingTypes as $ship)
                                        <option value="{{$ship}}">{{ucfirst($ship)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h1>
                            </h1>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Shipping Fees</label>
                                <div class="col-md-8">
                                    <input type="number" name="shipping_fees" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Brand</label>
                                <div class="col-md-8">
                                    <select class="form-control" id="brands" name="brand">
                                        <option value="" selected>Select</option>

                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Category</label>
                                <div class="col-md-8">
                                    <select class="form-control" id="categories" name="category">
                                        <option value="" selected>Select</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">
                                            @if($category->level == 0)
                                            {{$category->name}}
                                            @else
                                            {{$categoriesNames[$category->id]}}
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Type</label>
                                <div class="col-md-8">
                                    <select onchange="getSpecifications(event)" class="form-control" id="types" name="type" required>
                                        <option value="" selected>Select</option>

                                        @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">
                                    <h5>Specifications</h5>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead class="text-center" style="white-space: nowrap;">
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Value *</th>
                                            </tr>
                                        </thead>
                                        <tbody id="specifications" class="text-center">
                                            <tr>
                                                <td colspan="2"> Select a Type</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-group border-top  pt-3">
                    <div class="row">
                        <label class="col-md-4" align="right">
                            <h5>Images</h5>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div id="images-render" class="col-md-12">

                        </div>
                    </div>
                </div>
                <div class="form-group border-bottom pb-3">
                    <div class="row">
                        <div id="files" class="col-md-4">
                            <input id="file-0" type="file" name="img[]" class="form-control img-input" onchange="readURL(this);" required />
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
    let imageId = 0;

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Create element with HTML 
                let img = $(`<img id="${imageId}" class='m-3 border border-info rounded' />`);
                let div = $(`<div id="div-${imageId}" class="d-inline-block"></div>`);
                let closeButton = $(`<a id="${imageId}" onclick="removeImage(this)"> <i class="fa fa-times" aria-hidden="true"></i></a>`);
                imageId++;
                closeButton.css({
                    "display": "block",
                    "float": "left",
                    "position": "relative",
                    "top": "10px",
                    "cursor": "pointer",
                })
                img.attr('src', e.target.result)
                    .width(75)
                    .height(75);
                div.append(img);
                div.append(closeButton);
                $('#images-render').append(div);
                $('.img-input').hide();
                let input = `
                    <input id="file-${imageId}" type="file" name="img[]" class="form-control img-input" onchange="readURL(this);" />
                `;
                $('#files').append(input)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage(element) {
        console.log(element.id);
        $(`#div-${element.id}`).remove();
        $(`#file-${element.id}`).remove();
    }

    function getSpecifications(e) {
        let id = e.target.value;
        renderSpec(id);
    }

    function renderSpec(id) {
        let specsHtml = $('#specifications')

        if (id) {
            let url = '{{ route("types.show", ":id") }}';
            url = url.replace(':id', id);
            axios.get(url)
                .then(function(response) {
                    let specs = response.data.specifications;
                    let renderHtml = renderSpecs(specs);

                    specsHtml.html(renderHtml);
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    switch (error.response.status) {
                        case 404:
                            console.log("Not Found");
                            break;

                        default:
                            console.log("Error Ocurred");

                            break;
                    }

                })
        } else {
            let def = `
            <tr>
                <td colspan="2"> Select a Type</td>
            </tr>`;
            specsHtml.html(def)
        }
    }

    function chooseInput(spec, id) {
        let inputHtml = "";
        switch (spec.type) {
            case 'number':
                inputHtml = `
                <input class="form-control" name="specifications[${id}]" type="number" required>`;
                break;
            case 'text':
                inputHtml = `
                <input class="form-control" name="specifications[${id}]" type="text" required>`;
                break;
            case 'select':
                let options = specs[i].values.split(',').map(function(element) {
                    return `<option>${element}</option>`
                });
                inputHtml = `
                <select class="form-control" name="specifications[${id}]" required>
                    ${options.join('\n')}
                </select>`
                break;

            default:
                break;
        }
        return inputHtml;
    }

    function renderSpecs(specs) {
        let html = '';
        for (let i in specs) {
            let input = chooseInput(specs[i], i);
            html += `
                        <tr>
                        <td class="align-middle" > ${specs[i].title}</td>
                        <td>
                        ${input}
                        </td>
                        </tr>
                        `;
        }
        return html;
    }
    CKEDITOR.replace('description');
</script>
@endsection