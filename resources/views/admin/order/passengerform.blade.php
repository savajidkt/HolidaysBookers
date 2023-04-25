<style>
    .bedchild {
        margin-top: 25px;
    }
</style>
@if ($model->adult->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center mb-1 mt-1">
                <i data-feather="arrow-right-circle" class="font-medium-3"></i>
                <h4 class="mb-0 ml-75">Passenger Adult Details</h4>
            </div>
            <hr class="my-2" />
        </div>
    </div>
    <div class="row">
        @php
            $i = 0;
        @endphp
        @foreach ($model->adult as $adult)
            <input type="hidden" class="form-control" name="adult[{{ $i }}][id]" value="{{ $adult->id }}">
            <input type="hidden" class="form-control" name="adult[{{ $i }}][order_id]"
                value="{{ $adult->order_id }}">
            <div class="col-md-3 col-3">
                <div class="form-group">
                    <label for="basicInput">First Name</label>
                    <input type="text" class="form-control" id="basicInput"
                        name="adult[{{ $i }}][adult_first_name]" placeholder="First Name"
                        value="{{ $adult->first_name }}">
                    @error('adult_first_name')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3 col-3">
                <div class="form-group">
                    <label for="basicInput">Last Name</label>
                    <input type="text" class="form-control" id="basicInput"
                        name="adult[{{ $i }}][adult_last_name]" placeholder="Last Name"
                        value="{{ $adult->last_name }}">
                    @error('adult_last_name')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3 col-3">
                <div class="form-group">
                    <label class="form-label" for="role">ID Proof</label>
                    <select name="adult[{{ $i }}][adult_id_proof_type]" class="form-control"
                        id="id_proof_type" data-error="ID Proof is required">
                        <option value="">Select Status</option>
                        <option value="1" {{ isset($adult->id) && $adult->id_proof_type == 1 ? 'selected' : '' }}>
                            Aadhaar Card </option>
                        <option value="2" {{ isset($adult->id) && $adult->id_proof_type == 2 ? 'selected' : '' }}>
                            Passport</option>
                        <option value="3" {{ isset($adult->id) && $adult->id_proof_type == 3 ? 'selected' : '' }}>
                            Driving Licence</option>
                        <option value="4" {{ isset($adult->id) && $adult->id_proof_type == 4 ? 'selected' : '' }}>
                            Voters ID Card</option>
                        <option value="5" {{ isset($adult->id) && $adult->id_proof_type == 5 ? 'selected' : '' }}>
                            PAN Card</option>
                        <option value="6" {{ isset($adult->id) && $adult->id_proof_type == 6 ? 'selected' : '' }}>
                            Other</option>
                    </select>
                    @error('adult_id_proof_type')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3 col-3">
                <div class="form-group">
                    <label for="basicInput">ID No.</label>
                    <input type="text" class="form-control" id="basicInput"
                        name="adult[{{ $i }}][adult_id_proof_no]" placeholder="ID No"
                        value="{{ $adult->id_proof_no }}">
                    @error('adult_id_proof_no')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @php
                $i++;
            @endphp
        @endforeach
    </div>
@endif

@if ($model->child->count() > 0)

    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center mb-1 mt-1">
                <i data-feather="arrow-right-circle" class="font-medium-3"></i>
                <h4 class="mb-0 ml-75">Passenger Child Details</h4>
            </div>
            <hr class="my-2" />
        </div>
    </div>
    @php
        $i = 0;
    @endphp
    @foreach ($model->child as $child)
        <input type="hidden" class="form-control" name="child[{{ $i }}][id]" value="{{ $child->id }}">
        <input type="hidden" class="form-control" name="child[{{ $i }}][order_id]"
            value="{{ $child->order_id }}">

        <div class="row">
            <div class="col-md-2 col-2">
                <div class="form-group">
                    <label for="basicInput">First Name</label>
                    <input type="text" class="form-control" id="basicInput"
                        name="child[{{ $i }}][child_first_name]" placeholder="First Name"
                        value="{{ $child->child_first_name }}">
                    @error('child_first_name')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-2 col-2">
                <div class="form-group">
                    <label for="basicInput">Last Name</label>
                    <input type="text" class="form-control" id="basicInput"
                        name="child[{{ $i }}][child_last_name]" placeholder="Last Name"
                        value="{{ $child->child_last_name }}">
                    @error('child_last_name')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-2 col-2">
                <div class="form-group">
                    <label class="form-label" for="role">ID Proof</label>
                    <select name="child[{{ $i }}][child_id_proof_type]" class="form-control"
                        id="id_proof_type" data-error="ID Proof is required">
                        <option value="">Select Status</option>
                        <option value="1"
                            {{ isset($child->id) && $child->child_id_proof_type == 1 ? 'selected' : '' }}>
                            Aadhaar Card </option>
                        <option value="2"
                            {{ isset($child->id) && $child->child_id_proof_type == 2 ? 'selected' : '' }}>
                            Passport</option>
                        <option value="3"
                            {{ isset($child->id) && $child->child_id_proof_type == 3 ? 'selected' : '' }}>
                            Driving Licence</option>
                        <option value="4"
                            {{ isset($child->id) && $child->child_id_proof_type == 4 ? 'selected' : '' }}>
                            Voters ID Card</option>
                        <option value="5"
                            {{ isset($child->id) && $child->child_id_proof_type == 5 ? 'selected' : '' }}>
                            PAN Card</option>
                        <option value="6"
                            {{ isset($child->id) && $child->child_id_proof_type == 6 ? 'selected' : '' }}>
                            Other</option>
                    </select>
                    @error('child_id_proof_type')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-2 col-2">
                <div class="form-group">
                    <label for="basicInput">ID No.</label>
                    <input type="text" class="form-control" id="basicInput"
                        name="child[{{ $i }}][child_id_proof_no]" placeholder="ID No"
                        value="{{ $child->child_id_proof_no }}">
                    @error('child_id_proof_no')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-2 col-2">
                <div class="form-group">
                    <label for="basicInput">Age</label>
                    <input type="text" class="form-control" id="basicInput"
                        name="child[{{ $i }}][child_age]" placeholder="ID No"
                        value="{{ $child->child_age }}">
                    @error('child_age')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @if ($child->childBed->count() > 0)
                <input type="hidden" class="form-control" name="child[{{ $i }}][order_child_id]"
                    value="{{ $child->childBed[0]->order_child_id }}">
                <div class="col-md-2 col-2">
                    <div class="form-group">
                        <label for="basicInput" class="bedchild"><i class="fa fa-bed fa-2x"></i></label>
                    </div>
                </div>
            @endif
        </div>
        @php
            $i++;
        @endphp
    @endforeach
@endif
