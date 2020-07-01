$('document').ready(function () {
    /* form reset */
    $(".form-signin").trigger("reset");

    /* validation */
    $.validator.setDefaults({
        debug: true,
        success: "valid"
    });
    $("#register-form").validate({
        rules:
        {
            user: {
                required: true,
                minlength: 3,
                maxlength: 16
            },
            pass: {
                required: true,
                minlength: 8,
                maxlength: 15
            },
            confirmpass: {
                required: true,
                equalTo: '#pass',
                minlength: 8,
                maxlength: 15
            },
            email: {
                required: true,
                email: true
            }
        },
        messages:
        {
            user: {
                required: "Enter an account name.",
                minlength: "Account name needs to be a minimum of 3 characters!",
                maxlength: "Account name needs to be a maximum of 15 characters!",
            },
            pass: {
                required: "Enter a password.",
                minlength: "Password needs to be a minimum of 8 characters!",
                maxlength: "Password needs to be a maximum of 15 characters!",
            },
            email: "Please enter a valid email address. You can not change this in the future.",
            confirmpass: {
                equalTo: "Passwords do not match."
            }
        },
        submitHandler: submitForm
    });
    /* validation */

    /* form submit */
    function submitForm() {
        let data = $("#register-form").serialize();
        $.ajax({

            type: 'POST',
            url: '/register.php',
            data: data,
            beforeSend: function () {
                $("#alert").fadeOut();
                $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
            },
            success: function (data) {
                console.log(data);
                if (data === "exists") {
                    $("#alert").fadeIn(1000, function () {
                        $("#alert").html('<div class="alert alert-danger">Sorry, that account name already exists.</div>');
                        $("#btn-submit").html("Join Zifina!");
                    });
                }
                else if (data === "registered") {
                    $("#alert").fadeIn(1000, function () {
                        $("#alert").html('<div class="alert alert-success">Successfully created account!</div>');
                        $(".form-signin").trigger("reset");
                        window.location.replace("account/login");
                    });
                    $(".form-signin").fadeOut(1000);
                }
                else if (data === "captcha") {
                    $("#alert").fadeIn(1000, function () {
                        $("#alert").html('<div class="alert alert-danger">Please make sure you check the security CAPTCHA box.</div>');
                    });
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
        return false;
    }
    /* form submit */

});
