<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    {{ html()->form('POST', '/admin/jobs')->open() }}
        @csrf
        @include('admin/jobs/fields')
    {{ html()->form()->close() }}
</x-admin.app-layout>
