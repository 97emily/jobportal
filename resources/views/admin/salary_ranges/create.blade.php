<x-admin.modal-layout modalSize="modal-md">
    <x-slot name="header">
        Create New Category
    </x-slot>
    <x-form-errors />

    {{ html()->form('POST', route('salary_ranges.store'))->attributes(['data-remote' => 'true'])->open() }}
        @csrf
        @include('admin/salary_ranges/fields')
        @include('admin/share/form_actions')
    {{ html()->form()->close() }}

</x-admin.modal-layout>
