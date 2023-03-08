@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile Details') }}</div>

                <div class="card-body">
                    <div class="form-group row">
                        <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                        <div class="col-md-6">
                            <label id="first_name" class="form-control">{{$profile->first_name}}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                        <div class="col-md-6">
                            <label id="last_name" class="form-control">{{$profile->last_name}}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

                        <div class="col-md-6">
                            <label id="dob" class="form-control">{{$profile->dob}}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                        <div class="col-md-6">
                            <label id="gender" class="form-control">{{$profile->gender}}</label>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{route('profile.edit', $profile->id)}}" class="btn btn-primary">{{ __('Edit') }}</a>
                            <a href="{{route('profile.index')}}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection