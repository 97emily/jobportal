<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    <x-flash-message/>
    {{ html()->modelForm($interview, 'POST', route('interviews.update', $interview->id))->open() }}
        @csrf
        @method('PUT')
        @include('admin/interviews/fields')
    {{ html()->closeModelForm() }}
</x-admin.app-layout>
