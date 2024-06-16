<x-admin.modal-layout modalSize="modal-md">
    <x-slot name="header">
        Update Salary Range
    </x-slot>
    <x-form-errors />
    {{ html()->modelForm($resource, 'POST', route('salary_ranges.update', $resource->id))->attributes(['data-remote' => 'true'])->open() }}
        @csrf
        @method('PUT')

        @include('admin/salary_ranges/fields')
        @include('admin/share/form_actions')
    {{ html()->closeModelForm() }}

</x-admin.modal-layout>
