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
        $("#forgotpassword_form").on('submit', function(e) {
            e.preventDefault();

            // close alert in 5 sec
            setTimeout(function() {
                $('#jsalerterror').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            setTimeout(function() {
                $('#jsalertsuccess').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            var email = $('#email').val();

            // empty check validation
            if (email == "") {
                $("#jsalerterror").show();
                $("#jsalerterror").css("visibility", "visible");
                $("#jsalerterror").html("Enter Email!");
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

                        $("#submit").html("Verify")

                        if (data.forgotpasswordstatus == 1) {
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html('Email not found');
                        } else if (data.mailsentstatus == 0) {
                            $("#jsalertsuccess").show();
                            $("#jsalertsuccess").css("visibility", "visible");
                            $("#jsalertsuccess").html('Vertification Mail Sent');
                        } else if (data.mailsentstatus == 1) {
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html('Vertification Mail Not Sent');
                        } else if (data.error['email'] ==
                            "The email field is required." || data.error['email'] ==
                            "The email field must be a valid email address."
                        ) { // server side validation response
                            $("#jsalerterror").show();
                            $("#jsalerterror").css("visibility", "visible");
                            $("#jsalerterror").html(data.error['email']);
                        }

                    }
                });
                // ajax call end
            }
        });

    });
