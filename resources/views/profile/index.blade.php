@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profile List</h2>
    <a href="{{ route('profile.create') }}" class="btn btn-primary mb-3">Create Profile</a>
    <table class="table">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($profiles as $profile)
            <tr>
                <td>{{ $profile->first_name }}</td>
                <td>{{ $profile->last_name }}</td>
                <td>{{ \DateTime::createFromFormat('Y-m-d', $profile->dob)->format('d/m/Y') }}</td>
                <td>{{ $profile->gender }}</td>
                <td>
                    <a href="{{ route('profile.show', ['profile' => $profile->id]) }}" class="btn btn-sm btn-primary">View</a>
                    <a href="{{ route('profile.edit', ['profile' => $profile->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('profile.destroy', ['profile' => $profile->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this profile?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection