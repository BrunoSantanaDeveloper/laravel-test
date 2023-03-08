<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $report->title }}</title>
</head>

<body>
    <h1>{{ $report->title }}</h1>
    <p>{{ $report->description }}</p>
    <h2>Profiles associados</h2>
    <ul>
        @foreach($report->profiles as $profile)
        <li>{{ $profile->first_name }} {{ $profile->last_name }} - {{ $profile->gender }} - {{ $profile->dob->format('d/m/Y') }}</li>
        @endforeach
    </ul>
</body>

</html>