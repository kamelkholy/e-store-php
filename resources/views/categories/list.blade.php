@extends('base')

@section('main')
<div class="row justify-content-md-center">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Categories</h3>
            </div>
            <div class="panel-body">
                <div class="container">

                    <div class="row py-2">
                        <div class="col pl-0">
                            <a href="{{route('categories.create')}}" class="btn btn-primary"> Add New</a>
                        </div>

                    </div>
                </div>
                @if($errors->any())
                <div class="alert alert-danger text-center">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session()->has('success'))
                <div class="alert alert-success text-center">
                    {{ session()->get('success') }}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="text-center text-white" style="background-color: #A7B2DF;">
                            <tr>
                                <th>Image</th>
                                <th>@sortablelink('name', 'Name')</th>
                                <th>@sortablelink('name_ar', 'Name (Arabic)')</th>
                                <th>@sortablelink('sortOrder', 'Sort Order')</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @if (count($data) == 0)
                            <tr>
                                <td colspan="5">No Data to display.</td>
                            </tr>
                            @endif
                            @foreach($data as $row)
                            <?php $id = $row['id'] ?>
                            <tr>
                                <td class="align-middle">
                                    @if(count($row['subCategories'])>0)
                                    <a style="cursor: pointer;" onclick="expandSub('{{$id}}')"> <i class="fa fa-plus-circle"></i></a>
                                    @endif
                                    @if(isset($row['image']))
                                    <img src="{{route('categories.show', [$row['id']])}}" class="img-thumbnail" width="75" />
                                    @else
                                    <img src="{{asset('img/placeholder.png')}}" class="img-thumbnail" width="75" />
                                    @endif
                                </td>
                                <td class="align-middle">{{$row['name']}}</td>
                                <td class="align-middle">{{ $row['name_ar'] }}</td>
                                <td class="align-middle">{{ $row['sortOrder'] }}</td>
                                <td class="align-middle">
                                    <form action="{{route('categories.destroy', [$row['id']])}}" method="POST">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <a href="{{route('categories.edit', [$row['id']])}}" class="btn-sm btn-secondary" style="padding: .5rem .5rem;"><i class="fa fa-edit"></i></a>
                                        <button type="submit" class="btn-sm btn-danger" style="cursor: pointer;"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            {!! $row['html']!!}
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>
<script>
    function expandSub(id) {
        $('.sub-' + id).toggle();
    }
</script>
@endsection