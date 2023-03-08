<x-mail::message>
    @component('mail::message')
    # New Report Created

    A new report was successfully created:

    **Title:** {{ $report->title }}

    **Description:** {{ $report->description }}

    The PDF of the report is attached to this email.

    Thanks,<br>
    {{ config('app.name') }}
    @endcomponent
</x-mail::message>