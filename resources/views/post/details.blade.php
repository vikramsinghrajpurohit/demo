@extends('layouts.app')
@section('stylesheet')
<style>
    .image {
        width: 100%;
        max-height: 300px;
    }

    .post-date {
        margin-left: 20px;
    }

    .sub-title {
        margin-top: 20px;
    }

    .text-justify {
        text-align: justify;
    }

    .review-div {
        padding: 10px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{$data->title}}</h5>
                    <span class="author-name"><i class="fa fa-pencil" aria-hidden="true"></i> {{$data->name}}</span>
                    <span class="post-date"><i class="fa fa-calendar" aria-hidden="true"></i> {{$data->created_at}}</span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <img src="{{url('/posts/'.$data->image)}}" class="image" />
                            <h6 class="sub-title">{{$data->subtitle}}</h6>
                            <p class="text-justify">{{$data->details}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="review-div">
                                <h4 class="text-center">All Reviews</h4>
                                <hr>
                                @if(!empty($review))
                                @foreach($review as $rev)
                                <div class="review-div mb-3">
                                    <span class="author-name"><i class="fa fa-pencil" aria-hidden="true"></i> {{$rev['name']}}</span>
                                    <span class="post-date"><i class="fa fa-calendar" aria-hidden="true"></i>
                                        {{date("Y-m-d H:i:s", strtotime($rev['created_at']))}}
                                    </span>
                                    <hr>
                                    <p>{{$rev['comment']}}</p>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="review-div">
                                <h4 class="text-center">Write A Review</h4>
                                <hr>
                                <form method="POST" action="{{ route('review-save') }}">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{$data->id}}">
                                    <div class="row mb-3">
                                        <label for="name" class="col-md-12 col-form-label ">{{ __('Name') }} <span class="text-danger">*</span></label>

                                        <div class="col-md-12">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" @if(isset(Auth::user()->name)) readonly @endif value="{{ old('name') ?? (Auth::user()->name ?? '') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-12 col-form-label ">{{ __('Email-Id') }} <span class="text-danger">*</span></label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" @if(isset(Auth::user()->email)) readonly @endif value="{{ old('email') ?? (Auth::user()->email ?? '') }}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="comment" class="col-md-12 col-form-label ">{{ __('Comment') }} <span class="text-danger">*</span></label>

                                        <div class="col-md-12">
                                            <textarea id="comment" rows="5" class="form-control @error('comment') is-invalid @enderror" name="comment" @if(isset($data->comment)) readonly @endif required autocomplete="comment">{{ old('comment') ?? ($data->comment ?? '') }}</textarea>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-5">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Submit') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection