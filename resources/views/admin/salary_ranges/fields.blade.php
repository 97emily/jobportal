<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group mb-3">
            {{ html()->label('Minimum Salary <span class="text-danger">*</span>', 'minimum') }}
            {{ html()->number('minimum')->placeholder('Minimum Salary')->class('form-control')->attributes(['required' => true, 'min' => 0, 'step' => 'any']) }}
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group mb-3">
            {{ html()->label('Maximum Salary <span class="text-danger">*</span>', 'maximum') }}
            {{ html()->number('maximum')->placeholder('Maximum Salary')->class('form-control')->attributes(['required' => true, 'min' => 0, 'step' => 'any']) }}
        </div>
    </div>
</div>
