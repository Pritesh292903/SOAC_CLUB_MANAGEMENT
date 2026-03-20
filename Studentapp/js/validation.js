/**
 * jQuery Form Validation
 * Comprehensive validation for all forms in the Student Club Management System
 * Using jQuery Validation Plugin v1.19.5
 */

// ========================================
// CUSTOM VALIDATION RULES (DEFINE FIRST)
// ========================================
$.validator.addMethod("pattern", function (value, element, param) {
    if (param instanceof RegExp) {
        return param.test(value);
    }
    return true;
}, "Please enter valid characters");

$.validator.addMethod("indianPhone", function (value, element) {
    let phoneRegex = /^[6-9]\d{9}$/;
    return this.optional(element) || phoneRegex.test(value);
}, "Please enter a valid Indian phone number");

$.validator.addMethod("strongPassword", function (value, element) {
    let strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return this.optional(element) || strongRegex.test(value);
}, "Password must contain uppercase, lowercase, number, and special character");

$(document).ready(function () {

    // Configure jQuery Validation defaults
    $.validator.setDefaults({
        errorClass: "is-invalid",
        validClass: "is-valid",
        onkeyup: true,
        onfocusout: true
    });

    // ==========================================
    // 1. LOGIN FORM VALIDATION
    // ==========================================
    if ($("#loginForm").length) {
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                password: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                email: {
                    required: "Email is required",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Password is required",
                    minlength: "Password must be at least 5 characters"
                }
            },
            errorPlacement: function (error, element) {
                let errorContainer = element.siblings("#" + element.attr("id") + "Error");
                if (errorContainer.length) {
                    error.addClass("text-danger d-block").appendTo(errorContainer);
                } else {
                    error.addClass("text-danger d-block").insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
                $(element).closest(".form-group").addClass("has-error");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid").addClass("is-valid");
                $(element).closest(".form-group").removeClass("has-error");
            },
            submitHandler: function (form) {
                // Form is valid, allow submission
                return true;
            }
        });
    }


    // ==========================================
    // 2. REGISTER FORM VALIDATION
    // ==========================================
    if ($("#registerForm").length) {
        $("#registerForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 50,
                    pattern: /^[a-zA-Z\s]+$/,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                email: {
                    required: true,
                    email: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength: 30
                },
                cpassword: {
                    required: true,
                    minlength: 5,
                    maxlength: 30,
                    equalTo: "#password"
                }
            },
            messages: {
                name: {
                    required: "Full name is required",
                    minlength: "Name must be at least 3 characters",
                    maxlength: "Name cannot exceed 50 characters",
                    pattern: "Name should only contain letters and spaces"
                },
                email: {
                    required: "Email is required",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Password is required",
                    minlength: "Password must be at least 5 characters",
                    maxlength: "Password cannot exceed 30 characters"
                },
                cpassword: {
                    required: "Please confirm your password",
                    minlength: "Password must be at least 5 characters",
                    maxlength: "Password cannot exceed 30 characters",
                    equalTo: "Passwords do not match"
                }
            },
            errorPlacement: function (error, element) {
                let errorSpan = element.siblings("#" + element.attr("id") + "Error");
                if (errorSpan.length) {
                    error.addClass("d-block").appendTo(errorSpan);
                } else {
                    error.addClass("d-block").insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).addClass("input-error is-invalid").removeClass("is-valid");
                $(element).siblings(".error-icon").show();
                $(element).closest(".form-group").addClass("has-error");
            },
            unhighlight: function (element) {
                $(element).removeClass("input-error is-invalid").addClass("is-valid");
                $(element).siblings(".error-icon").hide();
                $(element).closest(".form-group").removeClass("has-error");
            },
            submitHandler: function (form) {
                return true;
            }
        });
    }

    // ==========================================
    // 3. EDIT PROFILE FORM VALIDATION
    // ==========================================
    if ($("#editProfileForm").length) {
        $("#editProfileForm").validate({
            rules: {
                fullname: {
                    required: true,
                    minlength: 3,
                    maxlength: 50,
                    pattern: /^[a-zA-Z\s]+$/,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                email: {
                    required: true,
                    email: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                    normalizer: function (value) {
                        return value.replace(/\D/g, '');
                    }
                },
                department: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                designation: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                }
            },
            messages: {
                fullname: {
                    required: "Full name is required",
                    minlength: "Name must be at least 3 characters",
                    maxlength: "Name cannot exceed 50 characters",
                    pattern: "Name should only contain letters and spaces"
                },
                email: {
                    required: "Email is required",
                    email: "Please enter a valid email address"
                },
                phone: {
                    required: "Phone number is required",
                    digits: "Phone number should only contain digits",
                    minlength: "Phone number must be 10 digits",
                    maxlength: "Phone number must be 10 digits"
                },
                department: {
                    required: "Department is required",
                    minlength: "Department must be at least 3 characters",
                    maxlength: "Department cannot exceed 100 characters"
                },
                designation: {
                    required: "Designation is required",
                    minlength: "Designation must be at least 3 characters",
                    maxlength: "Designation cannot exceed 100 characters"
                }
            },
            errorPlacement: function (error, element) {
                let errorSpan = element.siblings("small#" + element.attr("id") + "Error");
                if (errorSpan.length) {
                    error.addClass("d-block").appendTo(errorSpan);
                } else {
                    error.addClass("d-block").insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
                $(element).closest(".mb-3").addClass("has-error");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid").addClass("is-valid");
                $(element).closest(".mb-3").removeClass("has-error");
            },
            submitHandler: function (form) {
                return true;
            }
        });
    }

    // ==========================================
    // 4. JOIN CLUB FORM VALIDATION
    // ==========================================
    if ($("#joinForm").length) {
        $("#joinForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 50,
                    pattern: /^[a-zA-Z\s]+$/,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                email: {
                    required: true,
                    email: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                    normalizer: function (value) {
                        return value.replace(/\D/g, '');
                    }
                }
            },
            messages: {
                name: {
                    required: "Your name is required",
                    minlength: "Name must be at least 3 characters",
                    maxlength: "Name cannot exceed 50 characters",
                    pattern: "Name should only contain letters and spaces"
                },
                email: {
                    required: "Email is required",
                    email: "Please enter a valid email address"
                },
                phone: {
                    required: "Phone number is required",
                    digits: "Phone number should only contain digits",
                    minlength: "Phone number must be 10 digits",
                    maxlength: "Phone number must be 10 digits"
                }
            },
            errorPlacement: function (error, element) {
                let errorId = element.attr("id") + "Error";
                let errorSpan = element.siblings("small#" + errorId);
                if (errorSpan.length) {
                    error.addClass("d-block").appendTo(errorSpan);
                } else {
                    error.addClass("d-block").insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
                $(element).closest(".mb-3").addClass("has-error");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid").addClass("is-valid");
                $(element).closest(".mb-3").removeClass("has-error");
            },
            submitHandler: function (form) {
                return true;
            }
        });
    }

    // ==========================================
    // 5. CONTACT FORM VALIDATION
    // ==========================================
    if ($("#contactForm").length) {
        $("#contactForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 50,
                    pattern: /^[a-zA-Z\s]+$/,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                email: {
                    required: true,
                    email: true,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                subject: {
                    required: true,
                    minlength: 5,
                    maxlength: 100,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                },
                message: {
                    required: true,
                    minlength: 10,
                    maxlength: 1000,
                    normalizer: function (value) {
                        return $.trim(value);
                    }
                }
            },
            messages: {
                name: {
                    required: "Name is required",
                    minlength: "Name must be at least 3 characters",
                    maxlength: "Name cannot exceed 50 characters",
                    pattern: "Name should only contain letters and spaces"
                },
                email: {
                    required: "Email is required",
                    email: "Please enter a valid email address"
                },
                subject: {
                    required: "Subject is required",
                    minlength: "Subject must be at least 5 characters",
                    maxlength: "Subject cannot exceed 100 characters"
                },
                message: {
                    required: "Message is required",
                    minlength: "Message must be at least 10 characters",
                    maxlength: "Message cannot exceed 1000 characters"
                }
            },
            errorClass: "is-invalid",
            validClass: "is-valid",
            errorPlacement: function (error, element) {
                error.addClass("d-block").insertAfter(element);
            },
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
                $(element).closest(".mb-3").addClass("has-error");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid").addClass("is-valid");
                $(element).closest(".mb-3").removeClass("has-error");
            },
            submitHandler: function (form) {
                return true;
            }
        });
    }

    // ==========================================
    // REAL-TIME VALIDATION ENHANCEMENTS
    // ==========================================
    
    // Email field validation on blur
    $(document).on("blur", "input[type='email']", function () {
        let $field = $(this);
        let email = $field.val().trim();
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email.length > 0 && !emailRegex.test(email)) {
            $field.addClass("is-invalid").removeClass("is-valid");
        } else if (email.length > 0) {
            $field.addClass("is-valid").removeClass("is-invalid");
        } else {
            $field.removeClass("is-valid is-invalid");
        }
    });

    // Phone field - Auto removes non-digits and validates
    $(document).on("input", "input[type='tel'], input[name='phone']", function () {
        let $field = $(this);
        let phone = $field.val().replace(/\D/g, "");
        
        if (phone.length > 0) {
            $field.val(phone);
        }
        
        if (phone.length === 10) {
            $field.addClass("is-valid").removeClass("is-invalid");
        } else if (phone.length > 0) {
            $field.addClass("is-invalid").removeClass("is-valid");
        } else {
            $field.removeClass("is-valid is-invalid");
        }
    });

    // Name field validation on blur
    $(document).on("blur", "input[id='name'], input[id='fullname']", function () {
        let $field = $(this);
        let name = $field.val().trim();
        let nameRegex = /^[a-zA-Z\s]{3,}$/;
        
        if (name.length > 0 && !nameRegex.test(name)) {
            $field.addClass("is-invalid").removeClass("is-valid");
        } else if (name.length > 0) {
            $field.addClass("is-valid").removeClass("is-invalid");
        } else {
            $field.removeClass("is-valid is-invalid");
        }
    });

    // Password strength indicator
    $(document).on("input", "input[name='password']", function () {
        let password = $(this).val();
        let strength = 0;

        if (password.length >= 5) strength++;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[@$!%*?&]/.test(password)) strength++;

        // Store strength for potential indicator use
        $(this).data("strength", strength);
    });

    // Auto-trim whitespace from text inputs on blur
    $(document).on("blur", "input[type='text'], input[type='email'], textarea", function () {
        let value = $(this).val();
        $(this).val($.trim(value));
    });

    // ==========================================
    // FORM SUBMISSION HANDLERS
    // ==========================================
    
    $(document).on("submit", "form[id*='Form']", function (e) {
        let $form = $(this);
        let isValid = $form.valid();
        
        if (!isValid) {
            e.preventDefault();
            return false;
        }
        
        // Form is valid
        return true;
    });

    // ==========================================
    // UTILITY FUNCTIONS
    // ==========================================

    // Clear all form errors
    window.clearFormErrors = function (formId) {
        let $form = $("#" + formId);
        if ($form.length) {
            let validator = $form.data("validator");
            if (validator) {
                validator.resetForm();
            }
            $form.find(".is-invalid").removeClass("is-invalid");
            $form.find(".is-valid").removeClass("is-valid");
            $form.find(".error").empty();
            $form.find(".error-icon").hide();
        }
    };

    // Validate single field
    window.validateField = function (fieldId) {
        let $field = $("#" + fieldId);
        if ($field.length) {
            let $form = $field.closest("form");
            let validator = $form.validate();
            return validator.element("#" + fieldId);
        }
        return false;
    };

    // Check if form is valid
    window.isFormValid = function (formId) {
        let $form = $("#" + formId);
        if ($form.length) {
            return $form.valid();
        }
        return false;
    };

    // Get all form errors
    window.getFormErrors = function (formId) {
        let $form = $("#" + formId);
        if ($form.length) {
            let validator = $form.data("validator");
            if (validator) {
                return validator.errorMap;
            }
        }
        return {};
    };

    // Show success message
    window.showSuccessMessage = function (message, duration = 3000) {
        let successDiv = $("<div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>" +
            "<i class='bi bi-check-circle-fill me-2'></i>" +
            message +
            "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" +
            "</div>");
        
        $("form").first().before(successDiv);
        
        if (duration > 0) {
            setTimeout(() => {
                successDiv.fadeOut(() => successDiv.remove());
            }, duration);
        }
    };

    // Show error message
    window.showErrorMessage = function (message, duration = 3000) {
        let errorDiv = $("<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>" +
            "<i class='bi bi-exclamation-circle-fill me-2'></i>" +
            message +
            "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" +
            "</div>");
        
        $("form").first().before(errorDiv);
        
        if (duration > 0) {
            setTimeout(() => {
                errorDiv.fadeOut(() => errorDiv.remove());
            }, duration);
        }
    };

    // Enable/Disable form submit button based on validation
    window.toggleSubmitButton = function (formId, buttonSelector) {
        let $form = $("#" + formId);
        let $button = $(buttonSelector || $form.find("button[type='submit']"));
        
        $form.on("change keyup", function () {
            if ($form.valid()) {
                $button.prop("disabled", false).removeClass("disabled");
            } else {
                $button.prop("disabled", true).addClass("disabled");
            }
        });
        
        // Initial check
        if ($form.valid()) {
            $button.prop("disabled", false).removeClass("disabled");
        }
    };

    // Reset form to initial state
    window.resetFormState = function (formId) {
        let $form = $("#" + formId);
        if ($form.length) {
            $form[0].reset();
            let validator = $form.data("validator");
            if (validator) {
                validator.resetForm();
            }
            $form.find(".is-invalid, .is-valid, .error, .error-icon").removeClass("is-invalid is-valid").empty().hide();
        }
    };

    // Initialize form with custom options
    window.initializeFormValidation = function (formId, customRules = {}, customMessages = {}) {
        let $form = $("#" + formId);
        if ($form.length && !$form.data("validator")) {
            let rules = $.extend({}, customRules);
            let messages = $.extend({}, customMessages);
            
            $form.validate({
                rules: rules,
                messages: messages,
                errorClass: "is-invalid",
                validClass: "is-valid"
            });
        }
    };

});


/**
 * JQUERY VALIDATION SETUP COMPLETE
 * ================================
 * 
 * Required Libraries (included in header.php):
 * - jQuery 3.7.1
 * - jQuery Validation Plugin 1.19.5
 * - jQuery Validation Additional Methods
 * 
 * Forms Validated:
 * 1. Login Form (#loginForm)
 * 2. Register Form (#registerForm)
 * 3. Edit Profile Form (#editProfileForm)
 * 4. Join Club Form (#joinForm)
 * 5. Contact Form (#contactForm)
 * 
 * Features:
 * ✓ Real-time field validation
 * ✓ Custom error messages
 * ✓ Bootstrap styling integration
 * ✓ Auto-trim whitespace
 * ✓ Auto-format phone numbers
 * ✓ Password strength calculation
 * ✓ Utility functions for developers
 * ✓ Form submit handlers
 * ✓ Error display customization
 * ✓ Field-level validation
 * 
 * Usage Examples:
 * 
 * // Check if form is valid
 * if (isFormValid('loginForm')) {
 *     console.log('Form is valid!');
 * }
 * 
 * // Clear all errors
 * clearFormErrors('registerForm');
 * 
 * // Show success message
 * showSuccessMessage('Account created successfully!', 5000);
 * 
 * // Get form errors
 * let errors = getFormErrors('editProfileForm');
 * console.log(errors);
 * 
 * // Reset form
 * resetFormState('joinForm');
 * 
 * // Validate single field
 * validateField('email');
 */
