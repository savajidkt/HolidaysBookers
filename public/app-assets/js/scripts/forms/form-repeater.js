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
  $('.room-repeater, .repeater-default').repeater({
    show: function () {
      $(this).slideDown();

      // $('.repeaterCLS .select2-container').remove();
      // $('.select2-room-types, .select2-room-amenities').select2({
      //   placeholder: "Select",
      //   allowClear: true
      // });
      // $('.repeaterCLS  .select2-container').css('width', '100%');

      // Feather Icons
      if (feather) {
        feather.replace({ width: 14, height: 14 });
      }
    },
    hide: function (deleteElement) {    

      if (confirm('Are you sure you want to delete this element?')) {
        $(this).slideUp(deleteElement);
      }
    }
  });
});
