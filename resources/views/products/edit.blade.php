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
            <h3 class="panel-title">Edit Product</h3>
        </div>
        <div class="panel-body">
            <br />
            <form method="post" action="{{ route('products.update', [$data->id]) }}" enctype="multipart/form-data" autocomplete="off">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Name</label>
                        <div class="col-md-4">
                            <input type="text" name="name" class="form-control" value="{{$data->name}}" required />
                        </div>
                        <label class="col-md-2" align="right">Name (Arabic)</label>
                        <div class="col-md-4">
                            <input type="text" name="name_ar" class="form-control" value="{{$data->name_ar}}" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Description</label>
                        <div class="col-md-10">
                            <textarea id="description" class="form-control" rows="4" cols="50" name="description" required>{{$data->description}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">SKU</label>
                                <div class="col-md-8">
                                    <input type="text" name="sku" class="form-control" value="{{$data->sku}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Price</label>
                                <div class="col-md-8">
                                    <input type="number" name="price" class="form-control" value="{{$data->price}}" step="0.01" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Quantity</label>
                                <div class="col-md-8">
                                    <input type="number" name="quantity" class="form-control" value="{{$data->quantity}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Weight</label>
                                <div class="col-md-5">
                                    <input type="number" name="weight" class="form-control" value="{{$data->weight}}" />
                                </div>
                                <div class="col-md">
                                    <input type="text" placeholder="Class" name="weight_class" class="form-control" value="{{$data->weight_class}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Dimensions</label>
                                <div class="col-md">
                                    <input type="number" placeholder="Length" name="length" class="form-control" value="{{$data->length}}" />
                                </div>
                                <div class="col-md">
                                    <input type="number" placeholder="Width" name="width" class="form-control" value="{{$data->width}}" />
                                </div>
                                <div class="col-md">
                                    <input type="number" placeholder="Height" name="height" class="form-control" value="{{$data->height}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Length Class</label>
                                <div class="col-md-8">
                                    <input type="text" name="length_class" class="form-control" value="{{$data->length_class}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Sort Order</label>
                                <div class="col-md-8">
                                    <input type="number" name="sortOrder" class="form-control" value="{{$data->sortOrder}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Tags</label>
                                <div class="col-md-8">
                                    <select name="tags[]" multiple class="form-control">
                                        @foreach($tags as $tag)
                                        <option value="{{$tag->id}}" @if(array_search($tag->id, array_column($productTags->toArray(), 'tag'))!==false) selected @endif>{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4" align="right">Brand</label>
                                <div class="col-md-8">
                                    <select class="form-control" id="brands" name="brand">
                                        <option value="">Select</option>

                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}" @if($brand->id == $data->brand)selected @endif>{{$brand->name}}</option>
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
                                        <option value="">Select</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}" @if($category->id == $data->category)selected @endif>
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
                                        <option value="">Select</option>

                                        @foreach($types as $type)
                                        <option value="{{$type->id}}" @if($type->id == $data->type)selected @endif>{{$type->name}}</option>
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
                        <div class="col-md-12">
                            @foreach($productImages as $img)
                            <div id="div-{{$img->id}}" class="d-inline-block">
                                <img id="div-{{$img->id}}" class='m-3 border border-info rounded' src="data:image/png;base64,{{ chunk_split(base64_encode($img->image)) }}" height="75" width="75">
                                <a id="{{$img->id}}" onclick="deleteImage(this)"> <i class="fa fa-times" aria-hidden="true" style="display:block; float:left; position:relative; top:10px; cursor:pointer"></i></a>
                            </div>
                            @endforeach
                        </div>
                        <div id="deleted-images">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="images-render" class="col-md-12">

                    </div>
                </div>
                <div class="form-group border-bottom pb-3">
                    <div class="row">
                        <div id="files" class="col-md-4">
                            <input id="file-{{max(array_column($productImages->toArray(), 'id'))+1}}" type="file" name="img[]" class="form-control img-input" onchange="readURL(this);" />
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
    $(document).ready(function() {
        let typeId = "{{$data->type}}";
        renderSpec(typeId);
        imageId = "{{max(array_column($productImages->toArray(), 'id'))+1}}";
    });

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
        $(`#div-${element.id}`).remove();
        $(`#file-${element.id}`).remove();
    }

    function deleteImage(element) {
        $(`#div-${element.id}`).remove();

        $('#deleted-images').append(`<input type="text" name="deleted_images[]" value="${element.id}" class="form-control d-none" readonly>`);
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

    function chooseInput(spec, id, value) {
        let inputHtml = "";
        switch (spec.type) {
            case 'number':
                inputHtml = `
                <input class="form-control" value="${value?value:''}" name="specifications[${id}]" type="number" required>`;
                break;
            case 'text':
                inputHtml = `
                <input class="form-control" value="${value?value:''}" name="specifications[${id}]" type="text" required>`;
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
            let specsData = @json($data['specifications']);
            value = specsData[i];
            let input = chooseInput(specs[i], i, value);
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