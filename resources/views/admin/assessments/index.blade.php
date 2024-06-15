<x-admin.app-layout>

    <x-admin.page-header />
    <x-admin.index-toolbar>
        <x-slot:mainactions>
            @can('assessment-create')
                <a class="btn btn-highlight waves-effect" href="{{ route('assessments.create') }}" style="background-color: #00AAD0">
                    <i class="fa fa-plus-circle"></i>
                    <span class="d-none d-md-inline">{{ _('Create New Assessment') }}</span>
                </a>
            @endcan
        </x-slot>
    </x-admin.index-toolbar>

    <x-flash-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('admin/assessments/table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! $assessments->links('pagination::bootstrap-5') !!}
</x-admin.app-layout>
