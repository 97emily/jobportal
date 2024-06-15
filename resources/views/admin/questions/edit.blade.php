<x-admin.app-layout>
    <x-admin.page-header/>
    <x-form-alert :errors="$errors"/>
    <x-flash-message/>
    {{ html()->modelForm($question, 'POST', route('questions.update', $question->id))->open() }}
        @csrf
        @method('PUT')
        @include('admin/questions/fields')
    {{ html()->closeModelForm() }}
</x-admin.app-layout>
