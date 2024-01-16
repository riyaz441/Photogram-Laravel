    $(document).ready(function() {

        // hide the js alert load the page
        $("#jsalerterror").hide();
        $("#jsalertsuccess").hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // click submit button
        $("#changepassword_form").on('submit', function(e) {
            e.preventDefault();

            // close alert in 5 sec
            setTimeout(function() {
                $('#jsalerterror').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            setTimeout(function() {
                $('#jsalertsuccess').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            var password = $('#password').val();
            var passwordcrm = $('#passwordcrm').val();

            // empty check validation
            if (password == "") {
                $("#jsalerterror").show();
                $("#jsalerterror").css("visibility", "visible");
                $("#jsalerterror").html("Enter New Password!");
            } else if (passwordcrm == "") {
                $("#jsalerterror").show();
                $("#jsalerterror").css("visibility", "visible");
                $("#jsalerterror").html("Enter Confirm Password!");
            } else {
                // spinner for loading...
                $("#submit").html("<div class='spinner-border text-light' role='status'></div>")

                // ajax call start
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {

                        $("#submit").html("Change Password")

                        if (data.changepassword_status == 0) {
                            $("#jsalertsuccess").show();
                            $("#jsalertsuccess").css("visibility", "visible");
                            $("#jsalerterror").css("visibility", "hidden");
                            $("#jsalertsuccess").html("Password Changed Successfully");
                        } else if (data.changepassword_status == 1) {
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html("Password Can't be Change!");
                        } else if (data.error['password'] ==
                            "The password field is required." || data.error['password'] ==
                            "The password field must be at least 8 characters." || data
                            .error[
                                'password'] ==
                            "The password field confirmation does not match.",
                            "The password field must be at least 8 characters."
                        ) { // server side validation response
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html(data.error['password']);
                        } else {
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html("Password Not Changed!");
                        }

                    }
                });
                // ajax call end
            }
        });

        // password show and hide
        $('#checkbox').on('change', function() {
            $('#passwordcrm').attr('type', $('#checkbox').prop('checked') == true ? "text" :
                "password");
        });
    });
