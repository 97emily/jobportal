<x-admin.app-layout>
    <x-admin.page-header/>
    <x-admin.index-toolbar>
        <x-slot:mainactions>
            @can('questions_create')
            <a class="btn btn-highlight waves-effect" href="{{ route('assessments.questions.create') }}">
                <i class="fa fa-plus-circle"></i>
                <span class="d-none d-md-inline">{{ _('Create New Product') }}</span>
            </a>
            @endcan
         </x-slot>
    </x-admin.index-toolbar>

    <x-flash-message/>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('admin/questions/table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! $questions->links('pagination::bootstrap-5') !!}
</x-admin.app-layout>


