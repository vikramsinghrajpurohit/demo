@extends('layouts.app')
@section('stylesheet')
<style>
    .image {
        max-height: 300px;
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
                        <div class="col-md-8">
                            @if(isset($data['id']))
                            {{ __('Edit Post') }}
                            @else
                            {{ __('Create Post') }}
                            @endif
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{route('my-post')}}" class="btn btn-sm btn-primary">Back</a>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('save-post') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($data['id']))
                        <input type="hidden" value="{{$data['id']}}" name="id" />
                        @endif
                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-form-label text-md-end">{{ __('Title') }} <span class="text-danger">*</span></label>

                            <div class="col-md-8">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? ($data['title'] ?? '') }}" required autocomplete="title" autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="subtitle" class="col-md-2 col-form-label text-md-end">{{ __('Sub-Title') }}</label>

                            <div class="col-md-8">
                                <input id="subtitle" type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" value="{{ old('subtitle') ?? ($data['subtitle'] ?? '') }}" autocomplete="subtitle">

                                @error('subtitle')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="details" class="col-md-2 col-form-label text-md-end">{{ __('Details') }} <span class="text-danger">*</span></label>

                            <div class="col-md-8">
                                <textarea id="details" rows="5" type="text" class="form-control @error('details') is-invalid @enderror" name="details" autocomplete="details" required>{{ old('details') ?? ($data['details'] ?? '') }}</textarea>

                                @error('details')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image" class="col-md-2 col-form-label text-md-end">{{ __('Image') }} <span class="text-danger">*</span></label>

                            <div class="col-md-8">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" @if(!isset($data['id'])) required @endif autocomplete="avatar">

                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                @if(isset($data['image']) && !empty($data['image']))
                                <div class="mt-3">
                                    <img src="{{url('/posts/'.$data['image'])}}" class="image mt-10" width="100%" />
                                </div>
                                @endif
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
@endsection