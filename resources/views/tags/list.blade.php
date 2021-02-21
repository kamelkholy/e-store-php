@extends('base')

@section('main')
<div class="row justify-content-md-center">
    <div class="container">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Tags</h3>
            </div>
            <div class="panel-body">
                <div class="container">

                    <div class="row py-2">
                        <div class="col pl-0">
                            <a href="{{route('tags.create')}}" class="btn btn-primary"> Add New</a>
                        </div>
                        <form action="{{route('tags.index')}}" class="form-inline my-2 my-lg-0">
                            <input name="search_key" class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
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
                                <th>@sortablelink('name', 'Name')</th>
                                <th>@sortablelink('name_ar', 'Name (Arabic)')</th>
                                <th>@sortablelink('sortOrder', 'Sort Order')</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @if ($data->count() == 0)
                            <tr>
                                <td colspan="4">No Data to display.</td>
                            </tr>
                            @endif
                            @foreach($data as $row)
                            <tr>
                                <td class="align-middle">{{ $row->name }}</td>
                                <td class="align-middle">{{ $row->name_ar }}</td>
                                <td class="align-middle">{{ $row->sortOrder }}</td>
                                <td class="align-middle">
                                    <form action="{{route('tags.destroy', [$row->id])}}" method="POST">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <a href="{{route('tags.edit', [$row->id])}}" class="btn-sm btn-secondary" style="padding: .5rem .5rem;"><i class="fa fa-edit"></i></a>
                                        <button type="submit" class="btn-sm btn-danger" style="cursor: pointer;"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-md-center">

                    <nav aria-label="table-pagination">
                        <ul class="pagination">
                            <li class="page-item text-center {{$data->currentPage() == 1? 'disabled' :''}}" style="width: 100px;">
                                <a class="page-link" href="{{$data->previousPageUrl()}}" tabindex="-1">Previous</a>
                            </li>
                            @foreach($data->links()->elements[0] as $key=>$element)
                            <li class="page-item @if($key == $data->currentPage()) active @endif"><a class="page-link" href="{{$element}}">{{$key}}</a></li>
                            @endforeach
                            <li class="page-item text-center {{$data->currentPage() == $data->lastPage()? 'disabled' :''}}" style="width: 100px;">
                                <a class="page-link" href="{{$data->nextPageUrl()}}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection