<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    {{ html()->form('POST', '/admin/interviews')->open() }}
        @csrf
        @include('admin/interviews/fields')
    {{ html()->form()->close() }}
</x-admin.app-layout>
