<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    <x-flash-message/>
    {{ html()->modelForm($product, 'POST', route('assessments.update', $product->id))->open() }}
        @csrf
        @method('PUT')
        @include('admin/assessments/fields')
    {{ html()->closeModelForm() }}
</x-admin.app-layout>
