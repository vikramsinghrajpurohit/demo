@extends('layouts.app')
@section('stylesheet')
<style>
    .image {
        max-width: 150px !important;
        max-height: 150px !important;
    }

    .text-right {
        text-align: right;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">{{ __('My Posts') }}</div>
                        <div class="col-md-4 text-right">
                            <a href="{{route('create-post')}}" class="btn btn-sm btn-primary">Create Post</a>
                        </div>
                    </div>


                </div>

                <div class="card-body">

                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <table class="table">
                        <thead>
                            <th width="50%">Post Title</th>
                            <th width="20%">Image</th>
                            <th width="15%">Status</th>
                            <th width="15%">Action</th>
                        </thead>
                        <tbody>
                            @if($data->total() > 0)
                            @foreach($data as $post)
                            <tr>
                                <td>{{$post['title']}}</td>
                                <td><img src="{{url('/posts/'.$post['image'])}}" class="image"></td>
                                <td>{{$post['status']}}</td>
                                <td>
                                    <a href="{{route('my-post-edit',$post['id'])}}" class="btn btn-sm btn-primary edit-post">Edit</a>
                                    <a href="{{route('my-post-delete',$post['id'])}}" class="btn btn-sm btn-danger delete-post" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">
                                    <p class="text-center">No Post found.</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div>

                        {{ $data->links('pagination::bootstrap-4') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection