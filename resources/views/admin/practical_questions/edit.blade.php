<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    <x-flash-message/>
    {{ html()->modelForm($practicalQuestion, 'POST', route('practical_questions.update', $practicalQuestion->id))->open() }}
        @csrf
        @method('PUT')
        @include('admin/practical_questions/fields')
    {{ html()->closeModelForm() }}
</x-admin.app-layout>
