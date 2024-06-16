<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    {{ html()->form('POST', '/admin/questions')->open() }}
        @csrf
        @include('admin/questions/fields')
    {{ html()->form()->close() }}
</x-admin.app-layout>
