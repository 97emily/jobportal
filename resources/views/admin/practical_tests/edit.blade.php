<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    <x-flash-message/>
    {{ html()->modelForm($practicalTest, 'POST', route('practical_tests.update', $practicalTest->id))->open() }}
        @csrf
        @method('PUT')
        @include('admin/practical_tests/fields')
    {{ html()->closeModelForm() }}
</x-admin.app-layout>
