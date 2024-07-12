<x-admin.app-layout>

    <x-admin.page-header />
    <x-admin.index-toolbar>
        <x-slot:mainactions>
            @can('job-create')
                <a class="btn btn-highlight waves-effect" href="{{ route('interviews.create') }}" style="background-color: #00AAD0">
                    <i class="fa fa-plus-circle"></i>
                    <span class="d-none d-md-inline">{{ _('Schedule New Interview') }}</span>
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
                        @include('admin/interviews/table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! $interviews->links('pagination::bootstrap-5') !!}
</x-admin.app-layout>