@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reports with Profiles') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Report Title') }}</th>
                                <th>{{ __('Report Description') }}</th>
                                <th>{{ __('Profile First Name') }}</th>
                                <th>{{ __('Profile Last Name') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                            @if(count($report->profiles) > 0)
                            @foreach($report->profiles as $profile)
                            <tr>
                                @if($loop->first)
                                <td rowspan="{{ count($report->profiles) }}">{{ $report->title }}</td>
                                <td rowspan="{{ count($report->profiles) }}">{{ $report->description }}</td>
                                @endif
                                <td>{{ $profile->first_name }}</td>
                                <td>{{ $profile->last_name }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>{{ $report->title }}</td>
                                <td>{{ $report->description }}</td>
                                <td>{{ __('No profiles associated with this report.') }}</td>
                                <td>{{ __('No profiles associated with this report.') }}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection