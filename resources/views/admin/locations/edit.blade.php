<x-admin.modal-layout modalSize="modal-md">
    <x-slot name="header">
        Update Location
    </x-slot>
    <x-form-errors />
    {{ html()->modelForm($resource, 'PUT', route('locations.update', $resource->id))->attributes(['data-remote' => 'true'])->open() }}
        @csrf
        @method('PUT')
        @include('admin/locations/fields')
        @include('admin/share/form_actions')
    {{ html()->closeModelForm() }}

</x-admin.modal-layout>
