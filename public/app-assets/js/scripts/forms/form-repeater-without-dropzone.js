/*=========================================================================================
    File Name: form-repeater.js
    Description: form repeater page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

  // form repeater jquery
  $('.room-repeater, .repeater-default, .package-repeater, .room-cancelation-policies-repeater').repeater({
    show: function () {
      $(this).slideDown();
      //console.log($(this).attr('data-cls'));
      var TotalCount = $(this).closest("[data-repeater-item]").index();
      //var TotalCount = $(this).closest("[data-repeater-item]").index() + parseInt(1);
      $('.repeaterCLS .select2-container').remove();
      $('.select2-room-types, .select2-room-amenities').select2({
        placeholder: "Select",
        allowClear: true
      });
      $('.repeaterCLS  .select2-container').css('width', '100%');

      if (is_package) {
        var options = {
          filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
          filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
          filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
          filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };

        CKEDITOR.replace('my-description-' + $(this).closest("[data-repeater-item]").index(), options);
      }
      // Feather Icons
      if (feather) {
        feather.replace({ width: 14, height: 14 });
      }

      if($(this).attr('data-cls') != 'repeaterChilds'){
        $('.testd').filter(":last").find('.rage-date-basic').flatpickr({ enableTime: true });
      }      

    },
    hide: function (deleteElement) {
      if (confirm('Are you sure you want to delete this element?')) {
        var deleteID = $(this).find('[data-repeater-delete]').attr('data-delete');
        if (deleteID) {
          $.ajax({
            beforeSend: function () {
              // $("#FrmroomType .buttonLoader").removeClass('hide');
            },
            complete: function () {
              // $("#FrmroomType .buttonLoader").addClass('hide');
            },
            type: 'POST',
            url: moduleConfig.deleteRepeterURL,
            dataType: 'json',
            data: {
              id: $(this).find('[data-repeater-delete]').attr('data-delete'),
            },
            success: function (data) {
              if (data.status) {
              }
            }
          });
        }
        $(this).slideUp(deleteElement);
        //console.log($(this).closest("[data-repeater-item]").index());
      }
    }
  });
});
