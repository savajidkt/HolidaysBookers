<style>
    .bedchild {
        margin-top: 25px;
    }
</style>

@if ($model->passenger_type == '1')
<input type="hidden" name="type" value="all">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center mb-1 mt-1">
                <i data-feather="arrow-right-circle" class="font-medium-3"></i>
                <h4 class="mb-0 ml-75">Lead Passenger</h4>
            </div>
            <hr class="my-2" />
        </div>
    </div>
    @if (count($model->order_rooms) > 0)
        @foreach ($model->order_rooms as $room_key => $room_value)
            @if (count($model->order_rooms) > 0)
                @foreach ($room_value->order_hotel_room_passenger as $pass_key => $pass_value)
                    <div class="row">
                        <div class="col-md-3 col-3">
                            <div class="form-group">
                                <label for="basicInput">Full Name
                                    {{ $pass_value->is_adult == '0' ? '(Adult)' : '(Child)' }}</label>
                                <input type="text" class="form-control" id="basicInput" name="name[{{ $pass_value->id }}]"
                                    placeholder="Full Name" value="{{ $pass_value->name }}">
                                @error('name')
                                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 col-3">
                            <div class="form-group">
                                <label class="form-label" for="role">ID Proof</label>
                                <select name="id_proof_type[{{ $pass_value->id }}]" class="form-control"
                                    data-error="ID Proof is required">
                                    <option value="">Select Status</option>
                                    <option value="Aadhaar" {{ $pass_value->id_proof == 'Aadhaar' ? 'selected' : '' }}>
                                        Aadhaar Card </option>
                                    <option value="Passport"
                                        {{ $pass_value->id_proof == 'Passport' ? 'selected' : '' }}>
                                        Passport</option>
                                    <option value="Driving Licence"
                                        {{ $pass_value->id_proof == 'Driving Licence' ? 'selected' : '' }}>
                                        Driving Licence</option>
                                    <option value="Voters ID Card"
                                        {{ $pass_value->id_proof == 'Voters ID Card' ? 'selected' : '' }}>
                                        Voters ID Card</option>
                                    <option value="PAN card"
                                        {{ $pass_value->id_proof == 'PAN card' ? 'selected' : '' }}>
                                        PAN Card</option>
                                    <option value="Other" {{ $pass_value->id_proof == 'Other' ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-2">
                            <div class="form-group">
                                <label for="basicInput">ID No.</label>
                                <input type="text" class="form-control" id="basicInput" name="id_proof_no[{{ $pass_value->id }}]"
                                    placeholder="ID No" value="{{ $pass_value->id_proof_no }}">
                            </div>
                        </div>
                        @if ($pass_value->is_adult == '0')
                            <div class="col-md-2 col-2">
                                <div class="form-group">
                                    <label for="basicInput">Phone Code</label>
                                    <input type="text" class="form-control" id="basicInput" name="phone_code[{{ $pass_value->id }}]"
                                        placeholder="ID No" value="{{ $pass_value->phone_code }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-2">
                                <div class="form-group">
                                    <label for="basicInput">Phone</label>
                                    <input type="text" class="form-control" id="basicInput" name="phone[{{ $pass_value->id }}]"
                                        placeholder="ID No" value="{{ $pass_value->phone }}">
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        @endforeach
    @endif
@else
<input type="hidden" name="type" value="lead">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center mb-1 mt-1">
                <i data-feather="arrow-right-circle" class="font-medium-3"></i>
                <h4 class="mb-0 ml-75">Lead Passenger</h4>
            </div>
            <hr class="my-2" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-3">
            <div class="form-group">
                <label for="basicInput">Full Name</label>
                <input type="text" class="form-control" id="basicInput" name="lead_passenger_name"
                    placeholder="Full Name" value="{{ $model->lead_passenger_name }}">
                @error('lead_passenger_name')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-3 col-3">
            <div class="form-group">
                <label class="form-label" for="role">ID Proof</label>
                <select name="lead_passenger_id_proof" class="form-control" id="id_proof_type"
                    data-error="ID Proof is required">
                    <option value="">Select Status</option>
                    <option value="Aadhaar" {{ $model->lead_passenger_id_proof == 'Aadhaar' ? 'selected' : '' }}>
                        Aadhaar Card </option>
                    <option value="Passport" {{ $model->lead_passenger_id_proof == 'Passport' ? 'selected' : '' }}>
                        Passport</option>
                    <option value="Driving Licence"
                        {{ $model->lead_passenger_id_proof == 'Driving Licence' ? 'selected' : '' }}>
                        Driving Licence</option>
                    <option value="Voters ID Card"
                        {{ $model->lead_passenger_id_proof == 'Voters ID Card' ? 'selected' : '' }}>
                        Voters ID Card</option>
                    <option value="PAN card" {{ $model->lead_passenger_id_proof == 'PAN card' ? 'selected' : '' }}>
                        PAN Card</option>
                    <option value="Other" {{ $model->lead_passenger_id_proof == 'Other' ? 'selected' : '' }}>
                        Other</option>
                </select>
            </div>
        </div>
        <div class="col-md-2 col-2">
            <div class="form-group">
                <label for="basicInput">ID No.</label>
                <input type="text" class="form-control" id="basicInput" name="lead_passenger_id_proof_no"
                    placeholder="ID No" value="{{ $model->lead_passenger_id_proof_no }}">
            </div>
        </div>
        <div class="col-md-2 col-2">
            <div class="form-group">
                <label for="basicInput">Phone Code</label>
                <input type="text" class="form-control" id="basicInput" name="lead_passenger_phone_code"
                    placeholder="ID No" value="{{ $model->lead_passenger_phone_code }}">
            </div>
        </div>
        <div class="col-md-2 col-2">
            <div class="form-group">
                <label for="basicInput">Phone</label>
                <input type="text" class="form-control" id="basicInput" name="lead_passenger_phone"
                    placeholder="ID No" value="{{ $model->lead_passenger_phone }}">
            </div>
        </div>
    </div>
@endif
