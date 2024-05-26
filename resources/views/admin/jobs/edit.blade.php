<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    <x-flash-message/>
    {{ html()->modelForm($job, 'POST', route('jobs.update', $job->id))->open() }}
        @csrf
        @method('PUT')
        @include('admin/jobs/fields')
    {{ html()->closeModelForm() }}
</x-admin.app-layout>
