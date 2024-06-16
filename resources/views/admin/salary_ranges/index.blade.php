<x-admin.app-layout>
    <x-admin.page-header/>

    <x-admin.index-toolbar>
        <x-slot:mainactions>
            @can('salary-create')
            <a class="btn btn-highlight waves-effect" data-modal="true" href="{{ route('salary_ranges.create') }}"style="background-color: #00AAD0">
                <i class="fa fa-plus-circle"></i>
                <span class="d-none d-md-inline">{{ _('Create New Salary Range') }}</span>
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
                        @include('admin/salary_ranges/table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! $collection->links('pagination::bootstrap-5') !!}
</x-admin.app-layout>
