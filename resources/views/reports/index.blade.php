@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Reports') }}</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Profiles') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr>
                                <td>{{$report->id}}</td>
                                <td>{{$report->title}}</td>
                                <td>{{$report->description}}</td>
                                <td>
                                    @foreach($report->profiles as $profile)
                                    {{$profile->first_name}} {{$profile->last_name}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{route('reports.show', $report->id)}}" class="btn btn-primary">{{ __('View') }}</a>
                                    <a href="{{route('reports.edit', $report->id)}}" class="btn btn-secondary">{{ __('Edit') }}</a>
                                    <form action="{{route('reports.destroy', $report->id)}}" method="post" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{route('reports.create')}}" class="btn btn-primary">{{ __('Create New Report') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection