<x-admin.app-layout>
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-lg-6">
                <h3>Show Salary Ranges</h3>
            </div>
            <div class="col-lg-6 text-right">
                <a class="btn btn-primary" href="{{ route('salary_ranges.index') }}"
                    style="background-color: #00AAD0">Back</a>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title" style="color: #00AAD0">All the jobs under the Ksh.
                    {{ number_format($salaryRange->minimum, 0) }} - Ksh. {{ number_format($salaryRange->maximum, 0) }}
                    Salary Range.</h4>
                {{-- Uncomment the following line if you want to display the category image --}}
                {{-- <img src="{{ $category->image }}" alt="{{ $category->name }}" class="img-fluid mb-3"> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5>Jobs</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($salaryRange->jobs as $job)
                                <li class="list-group-item">{{ $job->title }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
