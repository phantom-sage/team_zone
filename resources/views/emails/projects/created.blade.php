@component('mail::message')
# Welcome {{ $project->owner->username }}


@component('mail::panel')
    Here your Username: <strong>{{ $project->owner->username }}</strong>,
    Email-Address: <strong>{{ $project->owner->email }}</strong>,
    Project code: <strong>{{ $project->code }}</strong>
@endcomponent

@component('mail::button', ['url' => route('projects.index')])
See Project
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
