@extends('layouts.admin')
@section('stylesheet')
<style>
    .image {
        max-width: 150px !important;
        max-height: 150px !important;
    }
   
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>
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
                <div class="card-body">
                <table class="table">
                        <thead>
                            <th width="30%">Name</th>
                            <th width="20%">User Name</th>
                            <th width="20%">Email</th>
                            <th width="15%">Image</th>
                            <th width="15%">Action</th>
                        </thead>
                        <tbody>
                            @if($data->total() > 0)
                            @foreach($data as $user)
                            <tr>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['username']}}</td>
                                <td>{{$user['email']}}</td>
                                <td><img src="{{url('/avatars/'.$user['avatar'])}}" class="image"></td>
                                <td>
                                    <a href="{{route('admin-user-edit',$user['id'])}}" class="btn btn-sm btn-primary edit-user">Edit</a>
                                    <a href="{{route('admin-user-delete',$user['id'])}}" class="btn btn-sm btn-danger delete-user" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">
                                    <p class="text-center">No User found.</p>
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