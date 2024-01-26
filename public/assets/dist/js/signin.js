    $(document).ready(function() {


        // hide display size info alert
        $("#screensize").hide();

        // find user screen size
        var width = screen.width;
        var height = screen.height;

        if (width < 500 && height < 800) {
            $("#screensize").show();
        }

        // hide the js alert load the page
        $("#jsalerterror").hide();
        $("#jsalertsuccess").hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // click submit button
        $("#login_form").on('submit', function(e) {
            e.preventDefault();

            // close alert in 5 sec
            setTimeout(function() {
                $('#jsalerterror').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            setTimeout(function() {
                $('#jsalertsuccess').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            var email = $('#email').val();
            var password = $('#password').val();

            // empty check validation
            if (email == "") {
                $("#jsalerterror").show();
                $("#jsalerterror").css("visibility", "visible");
                $("#jsalerterror").html("Enter Email!");
            } else if (password == "") {
                $("#jsalerterror").show();
                $("#jsalerterror").css("visibility", "visible");
                $("#jsalerterror").html("Enter Password!");
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

                        $("#submit").html("Login")

                        if (data.status == 1) {
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html("Your account is deleted!");
                        } else if (data.block_status == 1) {
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html("Your account is blocked!");
                        } else if (data.login_status == 0) {
                            window.location = '/homeview';
                        } else if (data.login_status == 1) {
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html("Login Failed!");
                        } else if (data.error['email'] ==
                            "The email field is required." || data.error['email'] ==
                            "The email field must be a valid email address."
                        ) { // server side validation response
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html(data.error['email']);
                        } else if (data.error['password'] ==
                            "The password field is required." || data.error['password'] ==
                            "The password field must be at least 8 characters."
                        ) { // server side validation response
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html(data.error['password']);
                        }

                    }
                });
                // ajax call end
            }
        });

        // password show and hide
        // $('#checkbox').on('change', function() {
        //     $('#password').attr('type', $('#checkbox').prop('checked') == true ? "text" : "password");
        // });
    });
