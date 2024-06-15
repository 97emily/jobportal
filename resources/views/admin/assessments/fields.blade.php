 <form method="POST" action="{{ route('assessments.store') }}">
    @csrf
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input placeholder="Title" class="form-control" required name="title" type="text" id="title">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea placeholder="Description" class="form-control" name="description" id="description"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="job_listings_id">Job Listing<span class="text-danger">*</span></label>
                                    <select name="job_listings_id" id="job_listings_id" class="form-control select2" required>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}"
                                                {{ old('job_listings_id') == $job->id ? 'selected' : '' }}>
                                                {{ $job->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <button class="btn btn-highlight waves-effect" type="submit" style="background-color: #00AAD0">
                            <i class="fa fa-save"></i> Save
                        </button>
                        <a href="{{ route('assessments.index') }}" class="btn btn-outline-highlight waves-effect">
                            <i class="far fa-chevron-double-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.select2').select2();
    });
</script>


