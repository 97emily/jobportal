<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    {{ html()->form('POST', '/admin/answers')->open() }}
        @csrf
        @include('admin/answers/fields')
    {{ html()->form()->close() }}
</x-admin.app-layout>
