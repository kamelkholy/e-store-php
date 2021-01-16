@extends('base')

@section('main')
<div class="">

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
                <h3 class="panel-title">Add Type</h3>
            </div>
            <div class="panel-body">
                <br />
                <form id="type-form" method="post" action="{{ route('types.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Name</label>
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Name (Arabic)</label>
                            <div class="col-md-4">
                                <input type="text" name="name_ar" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Sort Order</label>
                            <div class="col-md-4">
                                <input onkeyup="" type="text" name="sortOrder" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Specifications</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <thead style="white-space: nowrap;">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title *</th>
                                            <th scope="col">Input Type *</th>
                                            <th scope="col">Possible Values</th>
                                        </tr>
                                    </thead>
                                    <tbody id="specifications" class="text-center">
                                    </tbody>
                                    <tr class="text-center">
                                        <td class="align-middle" colspan="4">
                                            <button onclick="addSpecification(event)" class="btn btn-primary-outline">Add Specification</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button onclick="submitData(event)" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
<script>
    let specifications = {};
    let appliedSpecs = {};
    let possibleValues = {};

    function renderSpecifications() {
        let renderHtml = ``;
        renderHtml = renderApplied(renderHtml);
        for (let i in specifications) {
            const s = specifications[i];
            delete possibleValues[i];
            if (!s.applied)
                renderHtml = s.html + renderHtml;
        }
        $('#specifications').html(renderHtml);
    }

    function renderApplied(html) {
        for (let i in appliedSpecs) {
            let applied = `
            <tr id="spec-${i}">
                <td class="d-flex flex-row">
                    <button onclick="removeSpecification(event, ${i})" class="btn-sm btn-danger"><i class="fa fa-minus" aria-hidden="true"></i></button>
                </td>
                <td><input type="text" name="specifications[${i}][title]" class="form-control" value="${appliedSpecs[i].title}" readonly ></td>
                <td><input type="text" name="specifications[${i}][type]" class="form-control"  value="${appliedSpecs[i].type}" readonly ></td>
                <td><input type="text" name="specifications[${i}][values]" class="form-control"  value='${(appliedSpecs[i].values)}' readonly ></td>
            </tr>`;
            html = applied + html;
        }
        return html;
    }

    function addSpecification(e) {
        let key = Object.keys(specifications).length > 0 ? Math.max.apply(Math, Object.keys(specifications)) + 1 : 0;
        var newSpecificaion = `
        <tr id="spec-${key}">
            <td class="d-flex flex-row">
                <button onclick="apply(event, ${key})" class="btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
                <button onclick="removeSpecification(event, ${key})" class="btn-sm btn-danger"><i class="fa fa-minus" aria-hidden="true"></i></button>
            </td>
            <td><input type="text" name="title" class="form-control" required></td>
            <td>
            <select class="form-control" name="type">
                <option>number</option>
                <option>text</option>
                <option>select</option>
            </select>
            </td>
            <td>
            <div class="d-flex flex-row">
                <input id="pv-${key}"  type="text" name="values" class="form-control" >
                <button onclick="addValue(event, ${key})" class="btn-sm btn-primary-outline"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>
            <div class="pt-1" id="sv-${key}"></div>
            </td>
        </tr>`;
        specifications[key] = {
            html: (newSpecificaion),
            applied: false
        };
        renderSpecifications();
        e.preventDefault();
    }

    function addValue(e, id) {
        e.preventDefault();
        input = $(`#pv-${id}`)[0];
        if (input.value) {
            if (possibleValues[id]) {
                possibleValues[id].push(input.value);
            } else {
                possibleValues[id] = [input.value]
            }
        }
        $(`#sv-${id}`).html(possibleValues[id].join(' , '))

    }

    function apply(e, id) {
        let selector = `#spec-${id} :input:not(:button)`;
        let inputs = $(selector);
        let values = {}
        for (let input of inputs) {

            if (input.name == 'values') {
                if (!possibleValues[id]) {
                    return e.preventDefault();
                }
                values[input.name] = possibleValues[id];
            } else {
                if (!input.value) {
                    return e.preventDefault();
                }
                values[input.name] = input.value;
            }
        }
        appliedSpecs[id] = values;
        specifications[id].applied = true;
        console.log(appliedSpecs);
        renderSpecifications();
        e.preventDefault();
    }

    function removeSpecification(e, id) {
        delete specifications[id];
        delete appliedSpecs[id];
        delete possibleValues[id];
        renderSpecifications();
        console.log(appliedSpecs);

        e.preventDefault();
    }

    function submitData(e) {
        specifications = [];
        renderSpecifications();
    }
</script>