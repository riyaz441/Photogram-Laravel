$(document).ready(function() {

        // Initialize CKEditor
        CKEDITOR.replace('viewprofilefeedback', {
            height: "200px"
        });

        CKEDITOR.addCss('.cke_editable { background-color: #e9e9e9; color: black }');

        $('#myToast').toast('show');

        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: Dark)').matches;

        if (prefersDark == true) {
            $("html").attr("data-bs-theme", "dark");
        }

        $("#auto").click(function() {
            if (prefersDark == true) {
                $("html").attr("data-bs-theme", "dark");
            } else {
                $("html").attr("data-bs-theme", "light");
            }
        });

        $("#light").click(function() {
            $("html").attr("data-bs-theme", "light");
        });

        $("#dark").click(function() {
            $("html").attr("data-bs-theme", "dark");
        });


        // hide the js alert load the page
        $("#jsalerterror").hide();
        $("#jsalertsuccess").hide();

        // laravel ajax code
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // click submit button for profile upload
        $("#profileupdate").on('submit', function(e) {
            e.preventDefault();

            // close alert in 5 sec
            setTimeout(function() {
                $('#jsalerterror').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            setTimeout(function() {
                $('#jsalertsuccess').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            // get all input values using jquery for empty check validation
            // spinner for loading...
            $("#submit").html("<div class='spinner-border text-light' role='status'></div>")

            //ajax call start
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                contentType: 'multipart/form-data',
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {

                    $("#submit").html("Save")

                    if (data.status == 0) {
                        $("#jsalerterror").show();
                        $("#jsalerterror").css("visibility", "visible");
                        $("#jsalerterror").html(data.error['profilephoto']);

                        // reset the form
                        $("#profileupdate")[0].reset();
                        $('#exampleModal').modal('hide');
                    }
                    if (data.message == 0) {
                        $("#jsalertsuccess").show();
                        $("#jsalertsuccess").css("visibility", "visible");
                        $("#jsalertsuccess").html("Profile Saved!");

                        // reset the form
                        $("#profileupdate")[0].reset();
                        $('#exampleModal').modal('hide');

                        // reload page after 5 sec
                        setTimeout(function() {
                            location.reload(true);
                        }, 3000);
                    }

                }
            });
            // ajax call end

        });


        // click submit button for profile change (update)
        $("#profilechange").on('submit', function(e) {
            e.preventDefault();

            // close alert in 5 sec
            setTimeout(function() {
                $('#jsalerterror').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            setTimeout(function() {
                $('#jsalertsuccess').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            // get all input values using jquery for empty check validation
            // spinner for loading...
            $("#submit").html("<div class='spinner-border text-light' role='status'></div>")

            //ajax call start
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                contentType: 'multipart/form-data',
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {

                    $("#submit").html("Update")

                    if (data.status == 0) {
                        $("#jsalerterror").show();
                        $("#jsalerterror").css("visibility", "visible");
                        $("#jsalerterror").html(data.error['profilephoto']);

                        // reset the form
                        $("#profilechange")[0].reset();
                        $('#exampleModalUpdate').modal('hide');
                    }
                    if (data.message == 0) {
                        $("#jsalertsuccess").show();
                        $("#jsalertsuccess").css("visibility", "visible");
                        $("#jsalertsuccess").html("Profile Updated!");

                        // reset the form
                        $("#profilechange")[0].reset();
                        $('#exampleModalUpdate').modal('hide');

                        // reload page after 5 sec
                        setTimeout(function() {
                            location.reload(true);
                        }, 3000);
                    }

                }
            });
            // ajax call end

        });


        // click submit button for user feedback
        $("#userfeedback").on('submit', function(e) {
            e.preventDefault();

            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            // close alert in 5 sec
            setTimeout(function() {
                $('#jsalerterror').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            setTimeout(function() {
                $('#jsalertsuccess').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            // get all input values using jquery for empty check validation
            // spinner for loading...
            $("#submit").html("<div class='spinner-border text-light' role='status'></div>")

            //ajax call start
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                contentType: 'multipart/form-data',
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {

                    $("#submit").html("Send")

                    if (data.status == 0) {
                        $("#jsalerterror").show();
                        $("#jsalerterror").css("visibility", "visible");
                        $("#jsalerterror").html(data.error['feedback']);

                        // reset the form
                        $("#profilechange")[0].reset();
                        $('#exampleModalFeedback').modal('hide');

                        CKEDITOR.instances['viewprofilefeedback'].setData('');
                    }
                    if (data.message == 0) {
                        $("#jsalertsuccess").show();
                        $("#jsalertsuccess").css("visibility", "visible");
                        $("#jsalertsuccess").html("Feedback Sent!");

                        // reset the form
                        $("#profilechange")[0].reset();
                        $('#exampleModalFeedback').modal('hide');

                        CKEDITOR.instances['viewprofilefeedback'].setData('');
                    }

                }
            });
            // ajax call end

        });


        // search js code start
        $("#searchResults").hide();
        $('#searchbox').on('keyup', function(e) {
            //ajax call start
            var search = $('#searchbox').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: '/search',
                method: 'post',
                data: {
                    searchdata: search,
                    _token: _token
                },
                dataType: 'json',
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {

                    var resultsContainer = $('#searchResults');
                    resultsContainer.empty();

                    if (data.message == 0) {
                        $("#searchResults").hide();
                    } else {
                        $("#searchResults").show();
                        $.each(data, function(index, item) {
                            resultsContainer.append(
                                '<li class="srkey"><a href= /viewprofilee/' +
                                item.id + '>' +
                                item.username +
                                '</li>');
                        });
                    }

                }
            });
            // ajax call end
        });

        // account delete js code start
        $("#accountdelete").on('submit', function(e) {
            e.preventDefault();


            var user_name_input = $("#deleteaccount").val();
            var user_name = "<?php echo $username; ?>";
            var _token = $('input[name="_token"]').val();

            if (user_name_input == user_name) {
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    contentType: 'multipart/form-data',
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {

                        if (data.message == 0) {
                            window.location.href = '/logout';
                        }

                    }
                });
            } else {
                $("#jsalerterror").show();
                $("#jsalerterror").css("visibility", "visible");
                $("#jsalerterror").html("Username not match");
                $("#deleteaccount").val("");
                $('#exampleModalaccount').modal('hide');

                // close alert in 5 sec
                setTimeout(function() {
                    $('#jsalerterror').fadeOut('slow');
                }, 5000); // <-- time in milliseconds
            }

        });

    });
