
var FrmPackagePreference = function () {
    var PackageFormValidation = function () {
        var FrmPackagePreferenceForm = $('#FrmPackages');
        var error4 = $('.error-message', FrmPackagePreferenceForm);
        var success4 = $('.error-message', FrmPackagePreferenceForm);

        FrmPackagePreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                package_name: { required: true },
                package_code: { required: true },
                package_validity: { required: true },
                country_ids: { required: true },
                city_ids: { required: true },
                nationality: { required: true },
                rate_per_adult: { required: true },
                rate_per_child_cwb: { required: true },
                rate_per_child_cnb: { required: true },
                rate_per_infant: { required: true },
                minimum_pax: { required: true },
                maximum_pax: { required: true },
                cancel_day: { required: true },
                origin_city: {
                    package_validation_origin_city: true,
                },
                inclusion: {
                    package_validation_inclusion: true,
                },
                exclusion: {
                    package_validation_exclusion: true,
                },
                status: { required: true },
                highlights: { required: true },
                terms_and_conditions: { required: true },
            },
            messages: {
                package_name: {
                    required: $("input[name=package_name]").attr('data-error')
                },
                package_code: {
                    required: $("input[name=package_code]").attr('data-error')
                },
                package_validity: {
                    required: $("input[name=package_validity]").attr('data-error')
                },
                country_ids: {
                    required: $("select[name=country_ids]").attr('data-error')
                },
                city_ids: {
                    required: $("select[name=city_ids]").attr('data-error')
                },
                nationality: {
                    required: $("select[name=city_ids]").attr('data-error')
                },
                rate_per_adult: {
                    required: $("input[name=rate_per_adult]").attr('data-error')
                },
                rate_per_child_cwb: {
                    required: $("input[name=rate_per_child_cwb]").attr('data-error')
                },
                rate_per_child_cnb: {
                    required: $("input[name=rate_per_child_cnb]").attr('data-error')
                },
                rate_per_infant: {
                    required: $("input[name=rate_per_infant]").attr('data-error')
                },
                minimum_pax: {
                    required: $("input[name=minimum_pax]").attr('data-error')
                },
                maximum_pax: {
                    required: $("input[name=maximum_pax]").attr('data-error')
                },
                cancel_day: {
                    required: $("input[name=cancel_day]").attr('data-error')
                },
                origin_city: {
                    required: 'Origin city is required'
                },
                inclusion: {
                    required: 'Inclusion is required'
                },
                exclusion: {
                    required: 'Exclusion is required'
                },
                highlights: {
                    required: $("textarea[name=highlights]").attr('data-error')
                },
                terms_and_conditions: {
                    required: $("textarea[name=terms_and_conditions]").attr('data-error')
                },
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "package_validity") {
                    error.insertAfter(".PackageValidity");
                } else if (element.attr("name") == "highlights") {
                    error.insertAfter(".highlightsErr");

                } else if (element.attr("name") == "terms_and_conditions") {
                    error.insertAfter(".terms_and_conditionsErr");

                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                $(".buttonLoader").removeClass('hide');
                var form_data = new FormData(form);
                var fileUpload = $('#packageGalleryDropzone').get(0).dropzone;
                var files = fileUpload.files;
                for (var i = 0; i < files.length; i++) {
                    form_data.append(files[i].name, files[i]);
                    form_data.append("package_gallery_image[]", files[i]);
                }

                jQuery.each($('#country_ids').val(), function (index, item) {
                    form_data.append("country_id[" + index + "]", item);
                });
                jQuery.each($('#city_ids').val(), function (index, item) {
                    form_data.append("city_id[" + index + "]", item);
                });

                $.ajax({
                    beforeSend: function () {
                        $(".buttonLoader").removeClass('hide');
                    },
                    complete: function (data) {
                        $(".buttonLoader").addClass('hide');
                    },
                    error: function (data) {
                    },
                    type: "post",
                    url: moduleConfig.addPackageURL,
                    data: form_data,
                    dataType: 'json',
                    'global': false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        window.location = moduleConfig.listPackageURL;
                    },
                    error: function (x, t, m) {
                    }
                });
            }
        });
    }

    var PackageCountry = function () {
        var selectCountry = $('.select2-add-country');
        var currenciesData = [];
        $.each(currencyList, function (key, val) {
            currenciesData.push({
                id: val.id,
                text: val.name
            });
        });


        selectCountry.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Countries",
            allowClear: true,
            multiple: true,
            dropdownAutoWidth: true,
            dropdownParent: selectCountry.parent(),
            width: '100%',
            data: currenciesData
        });

        $('.select2-add-country').val(currencyListIDs);
        $('.select2-add-country').trigger('change');
    }
    var PackageCity = function () {

        var selectCity = $('.select2-add-city');
        var citiesData = [];
        $.each(cityList, function (key, val) {
            citiesData.push({
                id: val.id,
                text: val.name
            });
        });
        selectCity.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Cities",
            allowClear: true,
            multiple: true,
            dropdownAutoWidth: true,
            dropdownParent: selectCity.parent(),
            width: '100%',
            data: citiesData
        });

        $('.select2-add-city').val(cityListIDs);
        $('.select2-add-city').trigger('change');
    }

    var PackageNationality = function () {
        var selectNationality = $('.select2-nationality');
        var NationalitiesData = [];
        $.each(currencyList, function (key, val) {
            NationalitiesData.push({
                id: val.id,
                text: val.name
            });
        });
        selectNationality.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Nationality",
            allowClear: true,
            multiple: false,
            dropdownAutoWidth: true,
            dropdownParent: selectNationality.parent(),
            width: '100%',
            data: NationalitiesData
        });

        $('.select2-nationality').val(nationalityIDs);
        $('.select2-nationality').trigger('change');
    }

    var PackageCitiesList = function () {
        $('#country_ids').on('change', function () {
            $('.myCity .select2-add-city').find('option').remove();
            var countryAry = $('#country_ids').val();
            var countryCode = "";
            if (countryAry) {
                countryCode = countryAry.join(",");
            }

            // var form_data = new Array();
            // form_data.push({ name: 'countryCode', value: countryCode });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                beforeSend: function () {
                    $(".myCity .spinner-border").removeClass('hide');
                },
                complete: function (data) {
                    $(".myCity .spinner-border").addClass('hide');
                },
                error: function (data) {
                },
                type: "post",
                url: moduleConfig.getCitiesByCountryURL,
                dataType: 'json',
                data: {
                    country_id: countryCode
                },
                success: function (data) {
                    //console.log(data.cities);
                    cityList = data.cities;
                    PackageCity();
                    $(".myCity .spinner-border").hide();
                },
                error: function (x, t, m) {
                }
            })
        });
    };
    return {
        //main function to initiate the module
        init: function () {
            PackageFormValidation();
            PackageCountry();
            PackageCity();
            PackageCitiesList();
            PackageNationality();
        }
    };
}();

$(document).ready(function () {
    FrmPackagePreference.init();
    $(document).on('click', '.textBoxCityAdd, .textBoxInclusionAdd, .textBoxExclusionAdd', function () {

        var this_attr = $(this).attr('data-name');
        var inputs = $("input[name=" + this_attr + "]").val();
        if (inputs == "") {
            return false;
        }

        $('.hide_' + this_attr).removeClass('hide');
        var number = parseInt($('#total_' + this_attr).val());
        number = number + 1;
        $('#total_' + this_attr).val(number);
        var inputs = $("input[name=" + this_attr + "]").val();
        if (!inputs)
            return false;
        var NewElement = "";
        NewElement += "<div class=\"alert alert-primary alert-dismissible fade show current_" + this_attr + "_" + number + "\" role=\"alert\">";
        NewElement += "<div class=\"alert-body\">" + inputs + "</div>";
        NewElement += "<button data-dismiss=\"alert\" aria-label=\"Close\" type=\"button\" class=\"close\" data-id=\"" + number + "\" data-name=\"" + this_attr + "\"><span aria-hidden=\"true\">×</span></button>";
        NewElement += "<input type='hidden' name='" + this_attr + "_arr[]' value='" + inputs + "'>";
        NewElement += "</div>";
        $('.hide_' + this_attr).append(NewElement);
        $("input[name=" + this_attr + "]").val('');

        $("#FrmPackages").validate().element(':input[name="total_' + this_attr + '"]');
    });


    $(document).on('click', '.close', function () {

        // alert($(this).attr('data-id'));
        //alert($(this).attr('data-name'));

        var this_attr = $(this).attr('data-name');
        var number = parseInt($('#total_' + this_attr).val());
        if (number != 0) {
            number = number - 1;
        } else {
            number = 0
        }
        $('#total_' + this_attr).val(number);
        //current_origin_city_1
    });

    jQuery.validator.addMethod("package_validation_origin_city",
        function (value, element) {
            console.log($('#total_origin_city').val());
            if ($('#total_origin_city').val() == '0' || $('#total_origin_city').val() == 'NuN') {
                return false;
            }
            return true;
        },
        "Origin city is required");
    jQuery.validator.addMethod("package_validation_inclusion",
        function (value, element) {
            if ($('#total_inclusion').val() == 0 || $('#total_inclusion').val() == 'NuN') {
                return false;
            }
            return true;
        },
        "Inclusion is required");
    jQuery.validator.addMethod("package_validation_exclusion",
        function (value, element) {
            if ($('#total_exclusion').val() == 0 || $('#total_exclusion').val() == 'NuN') {
                return false;
            }
            return true;
        },
        "Exclusion is required");
});
