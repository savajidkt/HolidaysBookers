/*=========================================================================================
    File Name: form-repeater.js
    Description: form repeater page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function() {
    'use strict';

    // form repeater jquery
    $('.room-repeater, .repeater-default').repeater({
        show: function() {
            $(this).slideDown();
            var TotalCount = $(this).closest("[data-repeater-item]").index();

<<<<<<< HEAD
            //var TotalCount = $(this).closest("[data-repeater-item]").index() + parseInt(1);
=======
            // //var TotalCount = $(this).closest("[data-repeater-item]").index() + parseInt(1);
            // $('.repeaterCLS .select2-container').remove();
            // $('.select2-room-types, .select2-room-amenities, .select2-room-freebies, .select2-room-meal-plan').select2({
            //     placeholder: "Select",
            //     allowClear: true
            // });
            // $('.repeaterCLS  .select2-container').css('width', '100%');
>>>>>>> eaf5c587bdde40833701dc134f9d3daa0a00a061
            $('.repeaterCLS .select2-container').remove();
            $('.select2-room-types, .select2-room-amenities, .select2-room-freebies, .select2-room-meal-plan').select2({
                placeholder: "Select",
                allowClear: true
            });
<<<<<<< HEAD
            $('.repeaterCLS  .select2-container').css('width', '100%');

            Dropzone.autoDiscover = false;
            var roomImageDropzone = new Dropzone("div#roomImageDropzone_" + TotalCount, {
                url: "/file/post",
                autoProcessQueue: false,
                maxFilesize: 1,
                acceptedFiles: 'image/*',
                init: function() {
                    this.on('addedfile', function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                        // Create the remove button
                        var removeButton = Dropzone.createElement(
                            "<button class='btn btn-outline-danger btn-sm' style='margin-left: 7px;margin-top: 7px;'>Remove file</button>"
                        );
                        // Capture the Dropzone instance as closure.
                        var _this = this;
                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();
                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                            this.on("maxfilesexceeded", function(file) {
                                this.removeFile(file);
                            });
                        });
                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
                }
            });

            var roomGalleryDropzone = new Dropzone("div#roomGalleryDropzone_" + TotalCount, {
                url: "/file/post",
                autoProcessQueue: false,
                acceptedFiles: 'image/*',
                init: function() {
                    this.on('addedfile', function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement(
                            "<button class='btn btn-outline-danger btn-sm' style='margin-left: 7px;margin-top: 7px;'>Remove file</button>"
                        );
                        // Capture the Dropzone instance as closure.
                        var _this = this;
                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();
                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                            this.on("maxfilesexceeded", function(file) {
                                this.removeFile(file);
                            });
                        });
                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
                }
            });

            // Feather Icons
            if (feather) {
                feather.replace({ width: 14, height: 14 });
            }
        },
        hide: function(deleteElement) {

=======

            $('.repeaterCLS .select2-container').css('width', '100%');

            // Add an event listener for the select boxes
            $('.repeaterCLS select').on('change', function() {
                // Hide the error message
                $('#error-message').hide();
            });

            Dropzone.autoDiscover = false;
            var roomImageDropzone = new Dropzone("div#roomImageDropzone_" + TotalCount, {
                url: "/file/post",
                autoProcessQueue: false,
                maxFilesize: 1,
                acceptedFiles: 'image/*',
                init: function() {
                    this.on('addedfile', function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                        // Create the remove button
                        var removeButton = Dropzone.createElement(
                            "<button class='btn btn-outline-danger btn-sm' style='margin-left: 7px;margin-top: 7px;'>Remove file</button>"
                        );
                        // Capture the Dropzone instance as closure.
                        var _this = this;
                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();
                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                            this.on("maxfilesexceeded", function(file) {
                                this.removeFile(file);
                            });
                        });
                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
                }
            });

            var roomGalleryDropzone = new Dropzone("div#roomGalleryDropzone_" + TotalCount, {
                url: "/file/post",
                autoProcessQueue: false,
                acceptedFiles: 'image/*',
                init: function() {
                    this.on('addedfile', function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement(
                            "<button class='btn btn-outline-danger btn-sm' style='margin-left: 7px;margin-top: 7px;'>Remove file</button>"
                        );
                        // Capture the Dropzone instance as closure.
                        var _this = this;
                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();
                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                            this.on("maxfilesexceeded", function(file) {
                                this.removeFile(file);
                            });
                        });
                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
                }
            });

            // Feather Icons
            if (feather) {
                feather.replace({ width: 14, height: 14 });
            }
        },
        hide: function(deleteElement) {

>>>>>>> eaf5c587bdde40833701dc134f9d3daa0a00a061
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
                console.log($(this).closest("[data-repeater-item]").index());
            }
        }
    });
});