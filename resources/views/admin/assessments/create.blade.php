<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    {{ html()->form('POST', '/admin/assessments')->open() }}
        @csrf
        @include('admin/assessments/fields')
    {{ html()->form()->close() }}
</x-admin.app-layout>
