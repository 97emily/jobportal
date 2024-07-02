<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    {{ html()->form('POST', '/admin/practical_tests')->open() }}
        @csrf
        @include('admin/practical_tests/fields')
    {{ html()->form()->close() }}
</x-admin.app-layout>
