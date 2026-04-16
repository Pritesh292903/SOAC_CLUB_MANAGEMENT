/* ===== jQuery Form Validation Configuration - Admin App ===== */

$(document).ready(function () {

    // Add custom validation methods
    $.validator.addMethod("phoneValidation", function (value, element) {
        return this.optional(element) || /^(\+\d{1,3}[- ]?)?\d{10}$/.test(value);
    }, "Please enter a valid phone number");

    $.validator.addMethod("passwordStrength", function (value, element) {
        return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
    }, "Password must contain at least 8 characters including uppercase, lowercase, number and special character");

    $.validator.addMethod("urlValidation", function (value, element) {
        return this.optional(element) || /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/.test(value);
    }, "Please enter a valid URL");

    $.validator.addMethod("fileType", function (value, element) {
        if (this.optional(element)) return true;
        var file = element.files[0];
        if (!file) return true;
        var allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        return allowedTypes.indexOf(file.type) !== -1;
    }, "Please upload a valid image file (JPG, PNG, GIF, or WebP)");

    $.validator.addMethod("fileSize", function (value, element) {
        if (this.optional(element)) return true;
        var file = element.files[0];
        if (!file) return true;
        var maxSizeInBytes = 5 * 1024 * 1024; // 5MB
        return file.size <= maxSizeInBytes;
    }, "File size must not exceed 5MB");

    // Image Preview Function
    function setupImagePreview(fileInputId, previewImgId) {
        $('#' + fileInputId).on('change', function (e) {
            var file = this.files[0];
            if (file) {
                // Check if file type is valid
                var allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (allowedTypes.indexOf(file.type) !== -1) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $('#' + previewImgId).attr('src', event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    }

    // Initialize image previews
    setupImagePreview('clubImage', 'clubImagePreview');
    setupImagePreview('eventImage', 'eventImagePreview');
    setupImagePreview('profilePhoto', 'profilePhotoPreview');

    // Change Password Form
    $(document).ready(function () {

        if ($('#changePasswordForm').length) {

            $("#changePasswordForm").validate({

                rules: {
                    currentPassword: {
                        required: true,
                        minlength: 6
                    },
                    newPassword: {
                        required: true,
                        minlength: 8
                    },
                    confirmPassword: {
                        required: true,
                        equalTo: "#newPassword"
                    }
                },

                messages: {
                    currentPassword: {
                        required: "Current password is required",
                        minlength: "Minimum 6 characters required"
                    },
                    newPassword: {
                        required: "New password is required",
                        minlength: "Minimum 8 characters required"
                    },
                    confirmPassword: {
                        required: "Confirm password is required",
                        equalTo: "Passwords do not match"
                    }
                },

                highlight: function (element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },

                unhighlight: function (element) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                },

                errorElement: 'div',
                errorClass: 'invalid-feedback',

                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }

            });

        }

    });

   // Add Club Form
if ($('#addClubForm').length) {

    $("#addClubForm").validate({

        rules: {
            clubImage: {
                fileType: true,
                fileSize: true,
                required: true
            },
            clubName: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            president: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            totalMembers: {
                required: true,
                number: true,
                min: 1,
                max: 10000
            },
            status: {
                required: true
            },
            description: {
                required: true,
                minlength: 10,
                maxlength: 500
            }
        },

        messages: {
            clubImage: {
                fileType: "Please upload a valid image file",
                fileSize: "File size must not exceed 5MB",
                required: "Please select an image"
            },
            clubName: {
                required: "Club name is required",
                minlength: "Minimum 3 characters required",
                maxlength: "Maximum 100 characters allowed"
            },
            president: {
                required: "President name is required",
                minlength: "Minimum 3 characters required",
                maxlength: "Maximum 50 characters allowed"
            },
            totalMembers: {
                required: "Total members is required",
                number: "Enter valid number",
                min: "Minimum 1 member required",
                max: "Maximum 10000 members allowed"
            },
            status: "Please select status",
            description: {
                required: "Description is required",
                minlength: "Minimum 10 characters required",
                maxlength: "Maximum 500 characters allowed"
            }
        },

        errorElement: 'div',
        errorClass: 'invalid-feedback',

        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },

        unhighlight: function (element) {
            if ($(element).attr('type') === 'file' && $(element).val() === '') {
                $(element).removeClass("is-invalid is-valid");
            } else {
                $(element).removeClass("is-invalid").addClass("is-valid");
            }
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },

        submitHandler: function (form) {

            Swal.fire({
                title: "Club Created Successfully!",
                text: "The new club has been added.",
                icon: "success",
                confirmButtonColor: "#28a745"
            }).then(() => {

                window.location.href = "all_clubes_page.php";

            });

            return false; 
        }

    });
}

    // Add Event Form
   if ($('#addEventForm').length) {

    $("#addEventForm").validate({

        rules: {
            eventImage: {
                fileType: true,
                fileSize: true,
                required: true
            },
            eventName: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            clubName: { required: true },
            eventDate: { required: true, date: true },
            eventStatus: { required: true },
            eventDescription: {
                required: true,
                minlength: 10,
                maxlength: 500
            }
        },

        messages: {
            eventImage: {
                fileType: "Please upload a valid image file",
                fileSize: "File size must not exceed 5MB",
                required: "Please select an image"
            },
            eventName: {
                required: "Enter event name",
                minlength: "Minimum 3 characters required",
                maxlength: "Maximum 100 characters allowed"
            },
            clubName: "Select club",
            eventDate: "Select date",
            eventStatus: "Select status",
            eventDescription: {
                required: "Enter description",
                minlength: "Minimum 10 characters required",
                maxlength: "Maximum 500 characters allowed"
            }
        },

        errorElement: 'div',
        errorClass: 'invalid-feedback',

        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },

        unhighlight: function (element) {
            $(element).removeClass("is-invalid").addClass("is-valid");
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },

        submitHandler: function (form) {

            Swal.fire({
                title: "Event Created Successfully!",
                text: "Your event has been added.",
                icon: "success",
                confirmButtonColor: "#28a745"
            }).then(() => {

                // Redirect
                window.location.href = "all_events_page.php";

            });

            return false; 
        }

    });
}

    // Edit Profile Form
    $(document).ready(function () {

        // ===== Live Image Preview =====
        $('#profilePhoto').change(function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#profilePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        // ===== Custom Validation Rules =====
        $.validator.addMethod("fileType", function (value, element) {
            if (element.files.length === 0) return true;
            let allowedTypes = ["image/jpeg", "image/png", "image/gif"];
            return allowedTypes.includes(element.files[0].type);
        }, "Please upload JPG, PNG or GIF file");

        $.validator.addMethod("fileSize", function (value, element) {
            if (element.files.length === 0) return true;
            return element.files[0].size <= 5 * 1024 * 1024;
        }, "File size must be less than 5MB");

        $.validator.addMethod("phoneValidation", function (value, element) {
            return /^[0-9+\-\s]{10,15}$/.test(value);
        }, "Enter valid phone number");

        // ===== Form Validation =====
        $("#editProfileForm").validate({
            rules: {
                profilePhoto: {
                    fileType: true, fileSize: true, required: true,
                },
                fullName: { required: true, minlength: 3, maxlength: 50 },
                email: { required: true, email: true },
                phone: { required: true, phoneValidation: true }
            },
            messages: {
                profilePhoto: {
                    fileType: "Upload JPG, PNG, GIF only", fileSize: "File must be <5MB", required: "Please select image",
                },
                fullName: { required: "Full name is required", minlength: "Minimum 3 characters", maxlength: "Maximum 50 characters" },
                email: { required: "Email is required", email: "Enter valid email" },
                phone: { required: "Phone is required", phoneValidation: "Enter valid phone number" }
            },
            highlight: function (element) { $(element).addClass("is-invalid").removeClass("is-valid"); },
            unhighlight: function (element) { $(element).removeClass("is-invalid").addClass("is-valid"); },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            errorPlacement: function (error, element) { error.insertAfter(element); },

            // ===== On Submit: Show Popup & Redirect =====
            submitHandler: function (form) {
                Swal.fire({
                    icon: 'success',
                    title: 'Profile Updated!',
                    text: 'Your profile has been saved successfully.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = "admin_profile.php";
                });
                return false; // prevent actual form submission
            }
        });

    });

    // Edit Club Form
 if ($('#editClubForm').length) {

    $("#editClubForm").validate({

        rules: {
            clubImage: {
                fileType: true,
                fileSize: true,
                required: true
            },
            clubName: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            president: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            totalMembers: {
                required: true,
                number: true,
                min: 1,
                max: 10000
            },
            status: {
                required: true
            },
            description: {
                required: true,
                minlength: 10,
                maxlength: 500
            }
        },

        messages: {
            clubImage: {
                fileType: "Please upload a valid image file",
                fileSize: "File size must not exceed 5MB",
                required: "Please select an image"
            },
            clubName: {
                required: "Club name is required",
                minlength: "Minimum 3 characters required",
                maxlength: "Maximum 100 characters allowed"
            },
            president: {
                required: "President name is required",
                minlength: "Minimum 3 characters required",
                maxlength: "Maximum 50 characters allowed"
            },
            totalMembers: {
                required: "Total members is required",
                number: "Enter valid number",
                min: "Minimum 1 member required",
                max: "Maximum 10000 members allowed"
            },
            status: "Please select status",
            description: {
                required: "Description is required",
                minlength: "Minimum 10 characters required",
                maxlength: "Maximum 500 characters allowed"
            }
        },

        errorElement: 'div',
        errorClass: 'invalid-feedback',

        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },

        unhighlight: function (element) {
            if ($(element).attr('type') === 'file' && $(element).val() === '') {
                $(element).removeClass("is-invalid is-valid");
            } else {
                $(element).removeClass("is-invalid").addClass("is-valid");
            }
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },

        submitHandler: function (form) {

            Swal.fire({
                title: "Club Updated Successfully!",
                text: "Changes have been saved.",
                icon: "success",
                confirmButtonColor: "#28a745"
            }).then(() => {

                window.location.href = "all_clubes_page.php";

            });

            return false;
        }

    });
}

    // Edit Events Form
if ($('#editEventsForm').length) {

    $("#editEventsForm").validate({

        rules: {
            eventImage: {
                fileType: true,
                fileSize: true,
                required: true,
            },
            eventName: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            eventClub: {
                required: true
            },
            eventDate: {
                required: true,
                date: true
            },
            eventStatus: {
                required: true
            },
            eventDescription: {
                required: true,
                minlength: 10,
                maxlength: 500
            }
        },

        messages: {
            eventImage: {
                fileType: "Please upload a valid image file",
                fileSize: "File size must not exceed 5MB",
                required: "Please select an image"
            },
            eventName: {
                required: "Event name is required",
                minlength: "Event name must be at least 3 characters",
                maxlength: "Event name cannot exceed 100 characters"
            },
            eventClub: "Please select a club",
            eventDate: {
                required: "Event date is required",
                date: "Please enter a valid date"
            },
            eventStatus: "Please select event status",
            eventDescription: {
                required: "Description is required",
                minlength: "Description must be at least 10 characters",
                maxlength: "Description cannot exceed 500 characters"
            }
        },

        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },

        unhighlight: function (element) {
            $(element).removeClass("is-invalid").addClass("is-valid");
        },

        errorElement: 'div',
        errorClass: 'invalid-feedback',

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },

        submitHandler: function (form) {

            Swal.fire({
                title: 'Event Updated!',
                text: 'Your event has been saved successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location.href = "all_events_page.php";
                }

            });

        }

    });

}


});

