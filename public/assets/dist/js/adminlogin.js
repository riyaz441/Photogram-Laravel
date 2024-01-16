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
        $("#admin_login_form").on('submit', function(e) {
            e.preventDefault();

            // close alert in 5 sec
            setTimeout(function() {
                $('#jsalerterror').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            setTimeout(function() {
                $('#jsalertsuccess').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            var username = $('#username').val();
            var password = $('#password').val();

            // empty check validation
            if (username == "") {
                $("#jsalerterror").show();
                $("#jsalerterror").css("visibility", "visible");
                $("#jsalerterror").html("Enter Username!");
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

                        if (data.login_status == 0) {
                            window.location = '/admindashboardview';
                        } else if (data.login_status == 1) {
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html("Login Failed!");
                        } else if (data.error['username'] ==
                            "The username field is required."
                        ) { // server side validation response
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html(data.error['username']);
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
    });
