<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">First Name</label>
            <input type="text" id="basic-addon-name" name="first_name" class="form-control" placeholder=" First Name" value="{{(isset($model->first_name))?$model->first_name:old('first_name')}}" aria-describedby="basic-addon-name" />
            <div class="valid-feedback">Looks good!</div>
            @error('first_name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="basic-addon-name">Last Name</label>
            <input type="text" id="basic-addon-name" name="last_name" class="form-control" placeholder="Last Name" value="{{(isset($model->last_name))?$model->last_name:old('last_name')}}" aria-describedby="basic-addon-name" />
            <div class="valid-feedback">Looks good!</div>
            @error('last_name')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="basic-default-email1">Email</label>
            <input type="email" name="email" id="basic-default-email1" value="{{(isset($model->email))?$model->email:old('email')}}" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe@email.com" {{(isset($model->email))? 'readonly' : ''}} />
            <div class="valid-feedback">Looks good!</div>
            @error('email')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="company">Company</label>
            <select name="company" class="form-control" id="company">
                <option value="">Select Company</option>
                <option value="add-company"> Add New Company</option>
                @if ($companies->count())
                    @foreach ($companies as $company)
                    @php
                        if(isset($model->company_id) && $model->company_id == $company->id){
                           $selectedCom ='selected';
                        }else{
                          $selectedCom = $company->id == old('company') ? 'selected' : ''; 
                        }
                    @endphp
                        <option value="{{ $company->id }}" {{ $selectedCom }} > {{ $company->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('company')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror

        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="project">Project Name</label>
            <select name="project" class="form-control" id="project">
                <option value="">Select Project</option>
                <option value="add-project"> Add New Project</option>
                @if ($projects->count())
                    @foreach ($projects as $project)
                    @php
                        if(isset($model->project_id) && $model->project_id == $project->id){
                           $selectedPro ='selected';
                        }else{
                          $selectedPro = $project->id == old('project') ? 'selected' : '';
                        }
                    @endphp
                        <option value="{{ $project->id }}" {{ $selectedPro }} > {{ $project->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="valid-feedback">Looks good!</div>
            @error('project')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label" for="address">Address</label>
            <textarea name="address" id="address" class="form-control">{{(isset($model->address))?$model->address:old('addres')}}</textarea>
            <div class="valid-feedback">Looks good!</div>
            @error('address')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="basic-default-password1">Password</label>
            @if($model->id == '')
            <input type="text" id="password" name="password" class="form-control" placeholder="" />
            <div class="valid-feedback">Looks good!</div>
            @error('password')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
            @endif
            @if($model->id != '')
            <input type="text" id="password" name="password" class="form-control" placeholder="" />
            <div class="valid-feedback">Looks good!</div>
            @error('password')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
            @endif
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="basic-default-password"></label>
            <button type="button" class="btn btn-primary waves-effect waves-float waves-light form-control" id="generate_password">Generate Pass</button>

        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label class="form-label" for="basic-default-password1">Confirm Password</label>
            @if($model->id != '')
            <input type="text" id="confirm-password" name="confirm-password" class="form-control" placeholder="" />
            <div class="valid-feedback">Looks good!</div>
            @error('confirm-password')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
            @endif
            @if($model->id == '')
            <input type="text" id="confirm-password" require name="confirm-password" class="form-control" placeholder="" />
            <div class="valid-feedback">Looks good!</div>
            @error('confirm-password')
            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
            @endif
        </div>
    </div>
</div>
<div class="modal fade text-left" id="CompanyForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Create Company</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <label>Company: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Company" name="company_name" id="company_name" class="form-control" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="create-company" class="btn btn-primary">Create</button>
                </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="ProjectForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Project Name</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <label>Project: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Project" name="project_name" id="project_name" class="form-control" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="create-project" class="btn btn-primary">Create</button>
                </div>
        </div>
    </div>
</div>
@section('extra-script')
<script type="text/javascript">
    jQuery(function() {
        function generatePassword() {
            return Math.random() // Generate random number, eg: 0.123456
                .toString(36) // Convert  to base-36 : "0.4fzyo82mvyr"
                .slice(-8); // Cut off last 8 characters : "yo82mvyr"
        }
        jQuery('#generate_password').on('click', function() {
            var password = generatePassword();
            jQuery('#password').val(password);
            jQuery('#confirm-password').val(password);
        });

        jQuery('#company').on('change', function() {
            var currentVal = $(this).val();
            if (currentVal == 'add-company') {
                $('#CompanyForm').modal('show');
            }

        });

        jQuery('#project').on('change', function() {
            var currentVal = $(this).val();
            if (currentVal == 'add-project') {
                $('#ProjectForm').modal('show');
            }

        });

        jQuery('#create-company').on('click', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var company_name  = $('#company_name').val();
            $.ajax({
                type: 'POST',
                url: "{{route('company.store')}}",
                dataType: 'json',
                data:{
                    company_name: company_name
                },
                success: function(data)
                {
                    if( data.status === true )
                    {
                        $('#company_name').val('');
                        $('#CompanyForm').modal('hide');

                        // append company id in select options and selected
                        var $company = $('#company');
                        $company.find('option').each(function(index, elem){
                            $(elem).removeAttr('selected');
                        });
                        $company.append(`<option value="${data.data.id}" selected>${data.data.name}</option>`);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError)
                {
                    Survey.JQValidation.handleErrors(xhr);
                }
            });
        });

        jQuery('#create-project').on('click', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var project_name  = $('#project_name').val();
            $.ajax({
                type: 'POST',
                url: "{{route('project.store')}}",
                dataType: 'json',
                data:{
                    project_name: project_name
                },
                success: function(data)
                {
                    if( data.status === true )
                    {
                        $('#project_name').val('');
                        $('#ProjectForm').modal('hide');

                        // append project id in select options and selected
                        var $company = $('#project');
                        $company.find('option').each(function(index, elem){
                            $(elem).removeAttr('selected');
                        });
                        $company.append(`<option value="${data.data.id}" selected>${data.data.name}</option>`);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError)
                {
                    Survey.JQValidation.handleErrors(xhr);
                }
            });
        });
        $('#CompanyForm').on('hide.bs.modal', function(){
            // remove validation error messages
            jQuery('.error').remove();
            var $company = $('#company');
            $company.val('');
        });

        $('#ProjectForm').on('hide.bs.modal', function(){
            // remove validation error messages
            jQuery('.error').remove();
            var $project = $('#project');
            $project.val('');
        });
    })
</script>
@endsection