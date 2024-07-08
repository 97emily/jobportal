
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('interviews.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input placeholder="Title" class="form-control" required name="title" type="text" id="title" value="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requirements">Requirements <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="requirements" name="requirements" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4>Interview Details</h4>
                                    <div class="row border-bottom mb-3">
                                        <div class="form-group mb-3">
                                            <label for="interview_date">Interview Date</label>
                                            <input type="date" class="form-control" id="interview_date" name="interview_date" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="interview_time">Interview Time</label>
                                            <input type="time" class="form-control" id="interview_time" name="interview_time" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="job_listings_id">Job Title</label>
                                            <select class="form-control" id="job_listings_id" name="job_listings_id" required>
                                                <option value="">Select Job Title</option>
                                                @foreach ($jobs as $job)
                                                    <option value="{{ $job->id }}">{{ $job->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="location_id">Location Name</label>
                                            <select class="form-control" id="location_id" name="location_id" required>
                                                <option value="">Select Location</option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body d-flex justify-content-between">
                                    <button class="btn btn-highlight waves-effect" type="submit" style="background-color: #00AAD0">
                                        <i class="fa fa-save"></i>
                                        Save
                                    </button>
                                    <a href="{{ route('interviews.index') }}" class="btn btn-outline-highlight waves-effect">
                                        <i class="far fa-chevron-double-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

