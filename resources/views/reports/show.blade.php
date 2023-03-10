@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Report Details') }}</div>

                <div class="card-body">
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control" name="title" value="{{ $report->title }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                        <div class="col-md-6">
                            <textarea id="description" class="form-control" name="description" readonly>{{ $report->description }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="profiles" class="col-md-4 col-form-label text-md-right">{{ __('Profiles') }}</label>

                        <div class="col-md-6">
                            @if(count($report->profile) > 0)
                            <ul>
                                @foreach($report->profile as $profile)
                                <li>{{ $profile->first_name }} {{ $profile->last_name }}</li>
                                @endforeach
                            </ul>
                            @else
                            <p>{{ __('No profiles associated with this report.') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                            <a href="{{ route('reports.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection