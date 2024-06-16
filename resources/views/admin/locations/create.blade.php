<x-admin.modal-layout modalSize="modal-md">
    <x-slot name="header">
        Create New Location
    </x-slot>
    <x-form-errors />
    {{ html()->form('POST', route('locations.store'))->attributes(['data-remote' => 'true'])->open() }}
        @csrf
        @include('admin/locations/fields')
        @include('admin/share/form_actions')
    {{ html()->form()->close() }}
</x-admin.modal-layout>
