<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="country">Country Name</label>
            <select name="country_id" class="form-control" id="country_id">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $model->country_id == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}</option>
                @endforeach
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('country_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group loaderDisplay">
            <label class="form-label" for="country">State Name</label>
            <select name="state_id" class="form-control" id="state_id">
                <option value="">Select State</option>
                @if ($states)
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" {{ $model->state_id == $state->id ? 'selected' : '' }}>
                            {{ $state->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="spinner-border spinner-border-sm hide" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="valid-feedback">Looks good!</div>
            @error('state_id')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">City Name</label>
            <input type="text" id="basic-addon-name" name="name" class="form-control" placeholder="City Name"
                value="{{ isset($model->name) ? $model->name : old('name') }}" aria-describedby="basic-addon-name" />
            <div class="valid-feedback">Looks good!</div>
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="role">Status</label>
            <select name="status" class="form-control" id="status">
                <option value="">Select Status</option>
                <option value="1" {{ $model->status == 1 ? 'selected' : '' }}> Active</option>
                <option value="0" {{ $model->status == 0 ? 'selected' : '' }}> Inactive</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('status')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
@section('extra-script')
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('change', '#country_id', function() {
                var country_id = $(this).val();
                if (country_id) {
                    $('#state_id').find('option:not(:first)').remove();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        beforeSend: function() {
                            $(".spinner-border").show();
                        },
                        complete: function() {
                            $(".spinner-border").hide();
                        },
                        type: 'POST',
                        url: "{{ route('get-state-list') }}",
                        dataType: 'json',
                        data: {
                            country_id: country_id
                        },
                        success: function(data) {
                            if (data.status) {
                                $.each(data.states, function(key, val) {
                                    $('#state_id').append(new Option(val.name, val.id));
                                });
                            }
                            $(".spinner-border").hide();
                        }
                    });
                }
            });
        });
    </script>
@endsection
