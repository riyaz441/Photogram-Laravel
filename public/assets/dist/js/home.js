$(document).ready(function() {

        // hide toast
        // $('#myToast').toast('hide');
        // $('#myToastunlike').toast('hide');


        // tooltip
        $('[data-toggle="tooltip"]').tooltip();


        // Initialize CKEditor
        CKEDITOR.replace('feedback', {
            height: "200px"
        });

        CKEDITOR.addCss('.cke_editable { background-color: #e9e9e9; color: black }');

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

        // click submit button
        $("#photoupload").on('submit', function(e) {
            e.preventDefault();
            // close alert in 5 sec
            setTimeout(function() {
                $('#jsalerterror').fadeOut('slow');
                $(".progress-bar").fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            setTimeout(function() {
                $('#jsalertsuccess').fadeOut('slow');
                $(".progress-bar").fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            // get all input values using jquery for empty check validation
            // spinner for loading...
            $("#submit").html("<div class='spinner-border text-light' role='status'></div>")

            var formData = new FormData($(this)[0]);
            var progressBar = $('.progress');
            progressBar.show();

            // ajax call start
            $.ajax({

                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            progressBar.find('.progress-bar').width(percent + '%')
                                .html(
                                    percent + '%');
                        }
                    });
                    return xhr;
                },


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

                    $("#submit").html("Share")

                    if (data.status == 0) {
                        progressBar.find('.progress-bar').addClass('bg-danger');
                        $("#jsalerterror").show();
                        $("#jsalerterror").css("visibility", "visible");
                        $("#jsalerterror").html(data.error['photo']);

                        // reload page after 5 sec
                        setTimeout(function() {
                            location.reload(true);
                        }, 5000);
                    }
                    if (data.message == 0) {
                        progressBar.find('.progress-bar').addClass('bg-success');
                        $("#jsalertsuccess").show();
                        $("#jsalertsuccess").css("visibility", "visible");
                        $("#jsalertsuccess").html("Photo Shared!");

                        // reset the form
                        $("#photoupload")[0].reset();

                        // reload page after 5 sec
                        setTimeout(function() {
                            location.reload(true);
                        }, 5000);
                    }

                }
            });
            // ajax call end
            // https://www.webslesson.info/2018/09/upload-image-in-laravel-using-ajax.html
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
                        CKEDITOR.instances['feedback'].setData('');
                        $('#exampleModalFeedback').modal('hide');
                    }
                    if (data.message == 0) {
                        $("#jsalertsuccess").show();
                        $("#jsalertsuccess").css("visibility", "visible");
                        $("#jsalertsuccess").html("Feedback Sent!");

                        // reset the form
                        CKEDITOR.instances['feedback'].setData('');
                        $('#exampleModalFeedback').modal('hide');

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


        // post edit ajax call
        $(".postedit").click(function() {
            var postedit = $(this).val();

            $.ajax({
                url: "/postedit",
                method: "POST",
                data: {
                    id: postedit,
                    status: 'postedit'
                },
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {

                    $("#photoedit").attr('src', data.photo);
                    $("#floatingTextarea3").val(data.caption);
                    $("#uid").val(data.id);

                }
            });
        });


        // click submit button for profile change (update)
        $("#postupdate").on('submit', function(e) {
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
            $("#posteditsubmit").html("<div class='spinner-border text-light' role='status'></div>")

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

                    $("#posteditsubmit").html("Update");
                    window.location = '#';

                    if (data.status == 0) {
                        $("#jsalerterror").show();
                        $("#jsalerterror").css("visibility", "visible");
                        $("#jsalerterror").html(data.error['postphoto']);

                        // reset the form
                        $("#postupdate")[0].reset();
                        $('#exampleModalPostedit').modal('hide');
                    }
                    if (data.message == 0) {
                        $("#jsalertsuccess").show();
                        $("#jsalertsuccess").css("visibility", "visible");
                        $("#jsalertsuccess").html("Post Updated!");

                        // reset the form
                        $("#postupdate")[0].reset();
                        $('#exampleModalPostedit').modal('hide');

                        // reload page after 5 sec
                        setTimeout(function() {
                            location.reload(true);
                        }, 3000);
                    }

                }
            });
            // ajax call end

        });


        // post delete get id ajax call
        $(".postdelete").click(function() {
            var postdelete = $(this).val();

            $.ajax({
                url: "/postdelete",
                method: "POST",
                data: {
                    id: postdelete,
                    status: 'postdelete'
                },
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {

                    $("#udid").val(data.id);

                }
            });
        });


        // post edit ajax call
        $(".postedit").click(function() {
            var postedit = $(this).val();

            $.ajax({
                url: "/postedit",
                method: "POST",
                data: {
                    id: postedit,
                    status: 'postedit'
                },
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {

                    $("#photoedit").attr('src', data.photo);
                    $("#floatingTextarea3").val(data.caption);
                    $("#uid").val(data.id);

                }
            });
        });


        // click submit button for profile change (update)
        $("#postdelete").on('submit', function(e) {
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
            $("#postdeletesubmit").html("<div class='spinner-border text-light' role='status'></div>")

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

                    $("#postdeletesubmit").html("Delete");
                    window.location = '#';

                    if (data.message == 0) {
                        $("#jsalerterror").show();
                        $("#jsalerterror").css("visibility", "visible");
                        $("#jsalerterror").html("Post Deleted!");

                        // reset the form
                        $("#postdelete")[0].reset();
                        $('#exampleModalPostdelete').modal('hide');

                        // reload page after 5 sec
                        setTimeout(function() {
                            location.reload(true);
                        }, 3000);
                    }

                }
            });
            // ajax call end

        });


        // post share ajax call
        $(".share").click(function() {
            var share = "";
            share = $(this).val();

            $(".shareid").val("http://127.0.0.1:8000/sharepage/" + share);

        });


        // copy clipboard
        $("#copybutton").click(function() {
            var copyText = "";
            copyText = $('.shareid');
            copyText.select();
            document.execCommand('copy');
            $("#copybutton").html("Copied!");
            setTimeout("jQuery('#copybutton').html('Copy');", 3000);
        });


        // word wrap
        var maxLength = 40;
        $(".show-read-more").each(function() {
            var myStr = $(this).text();
            if ($.trim(myStr).length > maxLength) {
                var newStr = myStr.substring(0, maxLength);
                var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                $(this).empty().html(newStr);
                $(this).append(
                    ' <a href="javascript:void(0);" class="read-more link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><b>read more...</b></a>'
                );
                $(this).append('<span class="more-text">' + removedStr + '</span>');
            }
        });
        $(".read-more").click(function() {
            $(this).siblings(".more-text").contents().unwrap();
            $(this).remove();
        });


        // click like button
        let isAjaxInProgress = false;
        $(".like").click(function() {

            // Check if an AJAX call is already in progress
            if (isAjaxInProgress) {
                return; // AJAX call is still in progress, ignore the click
            }

            var like = "";
            like = $(this).val();

            // Disable the button to prevent multiple clicks
            $('#like_' + like).prop('disabled', true);

            // Set the flag to indicate an AJAX call is in progress
            isAjaxInProgress = true;


            $.ajax({
                url: "/postlike",
                method: "POST",
                data: {
                    id: like,
                    status: 'postlike'
                },
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {

                    if (data.message == 0) {
                        //$('#myToastunlike').toast('show');
                        $('#likecount_' + like).html(data.like_count);
                        $('#likestatusupdatemain_' + like).hide();

                        $('#likestatusupdate_' + like).html(
                            "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' style='fill: #8f959c;transform: ;msFilter:;'><path d='M4 21h1V8H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2zM20 8h-7l1.122-3.368A2 2 0 0 0 12.225 2H12L7 7.438V21h11l3.912-8.596L22 12v-2a2 2 0 0 0-2-2z'></path></svg>"
                        );

                        // reload page after 5 sec
                        // setTimeout(function() {
                        //     location.reload(true);
                        // }, 5000);

                    } else {
                        //$('#myToast').toast('show');
                        $('#likecount_' + like).html(data.like_count);
                        $('#likestatusupdatemain_' + like).hide();

                        $('#likestatusupdate_' + like).html(
                            "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' style='fill: #0082f3;transform: ;msFilter:;'><path d='M4 21h1V8H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2zM20 8h-7l1.122-3.368A2 2 0 0 0 12.225 2H12L7 7.438V21h11l3.912-8.596L22 12v-2a2 2 0 0 0-2-2z'></path></svg>"
                        );

                        // reload page after 5 sec
                        // setTimeout(function() {
                        //     location.reload(true);
                        // }, 5000);
                    }

                },
                complete: function() {
                    // Enable the button and reset the flag after AJAX call is completed
                    $('#like_' + like).prop('disabled', false);
                    isAjaxInProgress = false;
                }
            });


        });

    });
