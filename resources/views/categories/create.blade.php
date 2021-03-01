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
                <h3 class="panel-title">Add Category</h3>
            </div>
            <div class="panel-body">
                <br />
                <form method="post" action="{{ route('categories.store') }}" enctype="multipart/form-data">
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

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Parent</label>
                            <div class="col-md-10">
                                <select name="parent" class="custom-select">
                                    <option onclick="listSub('',2)" value="NULL" selected>Select Parent</option>
                                    @foreach($cats as $cat)
                                    <option onclick="listSub(this.value,2)" value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Level#2 Category</label>

                            <div class="col-md-4">
                                <select id="lvl-2" name="lvl_1" class="custom-select">
                                </select>
                            </div>
                            <label class="col-md-2" align="right">Level#3 Category</label>

                            <div class="col-md-4">
                                <select id="lvl-3" name="lvl_2" class="custom-select">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Sort Order</label>
                            <div class="col-md-4">
                                <input type="text" name="sortOrder" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Upload Image</label>
                            <div class="col-md-4">
                                <input type="file" name="image" />
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
</div>
<script>
    function listSub(id, level) {
        let lvlSelect = $('#lvl-' + level);
        if (!id) {
            $('#lvl-2').html('');
            $('#lvl-3').html('');
        } else if (level < 4) {
            allSubs = @json($subs);
            subCategories = allSubs[id];
            let options = '';
            if (Object.keys(subCategories).length > 0) {
                options = `<option onclick="listSub('',${level+1})" value="NULL" selected>Select</option>`;
            }
            for (const key in subCategories) {
                if (Object.hasOwnProperty.call(subCategories, key)) {
                    const subCat = subCategories[key];
                    options += `<option onclick="listSub('${subCat.id}',${level+1})" value="${subCat.id}">${subCat.name}</option>`;
                }
            }
            lvlSelect.html(options);
        }
    }
    CKEDITOR.replace('description');
</script>
@endsection