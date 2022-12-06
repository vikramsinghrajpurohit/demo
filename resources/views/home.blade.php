@extends('layouts.app')
@section('stylesheet')
<style>
    .main-div {
        /* border: 1px solid #ccc; */
        padding: 10px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    .image {
        max-width: 100%;
        max-height: 200px;
    }

    .title {
        text-align: center;
        margin: 10px auto;
    }

    .details {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 0px;
    }

    .read-more {
        font-size: 11px;
        text-align: right;
        padding: 0px;
    }

    .author-name,
    .post-date {
        font-size: 11px;
    }

    .post-like {
        float: right;
        margin-top: 5px;
        font-size: 13px;
    }
    .like-btn{
        color: #212529;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">{{ __('Dashboard') }}</div> -->

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="row">

                        @if($data->total() > 0)
                        @foreach($data as $post)
                        <div class="col-md-4">
                            <div class="main-div">
                                <img src="{{url('/posts/'.$post['image'])}}" class="image" />
                                <h5 class="title">{{$post->title}}</h5>
                                <h6 class="subtitle">{{$post->subtitle}}</h6>
                                <p class="details">{{$post->details}}</p>
                                <p class="read-more"><a href="{{route('post-details',$post->id)}}">Read More</a></p>
                                <p>
                                    <span class="author-name"><i class="fa fa-pencil" aria-hidden="true"></i> {{$post->name}}</span>
                                    <span class="post-date"><i class="fa fa-calendar" aria-hidden="true"></i> {{$post->created_at}}</span>
                                    @if(Auth::id())
                                    <span class="post-like">
                                        @if(array_key_exists($post->id,$myLike))
                                        <a href="{{route('post-unlike',$post->id)}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
                                        @else
                                        <a href="{{route('post-like',$post->id)}}"><i class="fa fa-thumbs-up like-btn" aria-hidden="true"></i></a>
                                        @endif

                                        {{$post->likes}}
                                    </span>
                                    @else
                                    <span class="post-like"><i class="fa fa-thumbs-up" aria-hidden="true"></i> {{$post->likes}}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endforeach
                        @else
                        @endif
                        <div class="col-md-12">
                            {{ $data->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection