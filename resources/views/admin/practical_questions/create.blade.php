<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    {{ html()->form('POST', '/admin/practical_questions')->open() }}
        @csrf
        @include('admin/practical_questions/fields')
    {{ html()->form()->close() }}
</x-admin.app-layout>
