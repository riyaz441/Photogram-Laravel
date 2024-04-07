$(document).ready(function () {

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

    $("#auto").click(function () {
        if (prefersDark == true) {
            $("html").attr("data-bs-theme", "dark");
        } else {
            $("html").attr("data-bs-theme", "light");
        }
    });

    $("#light").click(function () {
        $("html").attr("data-bs-theme", "light");
    });

    $("#dark").click(function () {
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
    $("#photoupload").on('submit', function (e) {
        e.preventDefault();
        // close alert in 5 sec
        setTimeout(function () {
            $('#jsalerterror').fadeOut('slow');
            $(".progress-bar").fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        setTimeout(function () {
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

            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
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
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

                $("#submit").html("Share")

                if (data.status == 0) {
                    progressBar.find('.progress-bar').addClass('bg-danger');
                    $("#jsalerterror").show();
                    $("#jsalerterror").css("visibility", "visible");
                    $("#jsalerterror").html(data.error['photo']);

                    // reload page after 5 sec
                    setTimeout(function () {
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
                    setTimeout(function () {
                        location.reload(true);
                    }, 5000);
                }

            }
        });
        // ajax call end
        // https://www.webslesson.info/2018/09/upload-image-in-laravel-using-ajax.html
    });


    // click submit button for profile upload
    $("#profileupdate").on('submit', function (e) {
        e.preventDefault();

        // close alert in 5 sec
        setTimeout(function () {
            $('#jsalerterror').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        setTimeout(function () {
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
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

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
                    setTimeout(function () {
                        location.reload(true);
                    }, 3000);
                }

            }
        });
        // ajax call end

    });


    // click submit button for profile change (update)
    $("#profilechange").on('submit', function (e) {
        e.preventDefault();

        // close alert in 5 sec
        setTimeout(function () {
            $('#jsalerterror').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        setTimeout(function () {
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
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

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
                    setTimeout(function () {
                        location.reload(true);
                    }, 3000);
                }

            }
        });
        // ajax call end

    });


    // click submit button for user feedback
    $("#userfeedback").on('submit', function (e) {
        e.preventDefault();

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        // close alert in 5 sec
        setTimeout(function () {
            $('#jsalerterror').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        setTimeout(function () {
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
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

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
    $('#searchbox').on('keyup', function (e) {
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
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

                var resultsContainer = $('#searchResults');
                resultsContainer.empty();

                if (data.message == 0) {
                    $("#searchResults").hide();
                } else {
                    $("#searchResults").show();
                    $.each(data, function (index, item) {
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
    $(".postedit").click(function () {
        var postedit = $(this).val();

        $.ajax({
            url: "/postedit",
            method: "POST",
            data: {
                id: postedit,
                status: 'postedit'
            },
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

                $("#photoedit").attr('src', data.photo);
                $("#floatingTextarea3").val(data.caption);
                $("#uid").val(data.id);

            }
        });
    });


    // click submit button for profile change (update)
    $("#postupdate").on('submit', function (e) {
        e.preventDefault();

        // close alert in 5 sec
        setTimeout(function () {
            $('#jsalerterror').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        setTimeout(function () {
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
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

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
                    setTimeout(function () {
                        location.reload(true);
                    }, 3000);
                }

            }
        });
        // ajax call end

    });


    // post delete get id ajax call
    $(".postdelete").click(function () {
        var postdelete = $(this).val();

        $.ajax({
            url: "/postdelete",
            method: "POST",
            data: {
                id: postdelete,
                status: 'postdelete'
            },
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

                $("#udid").val(data.id);

            }
        });
    });


    // post edit ajax call
    $(".postedit").click(function () {
        var postedit = $(this).val();

        $.ajax({
            url: "/postedit",
            method: "POST",
            data: {
                id: postedit,
                status: 'postedit'
            },
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

                $("#photoedit").attr('src', data.photo);
                $("#floatingTextarea3").val(data.caption);
                $("#uid").val(data.id);

            }
        });
    });


    // click submit button for profile change (update)
    $("#postdelete").on('submit', function (e) {
        e.preventDefault();

        // close alert in 5 sec
        setTimeout(function () {
            $('#jsalerterror').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        setTimeout(function () {
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
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

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
                    setTimeout(function () {
                        location.reload(true);
                    }, 3000);
                }

            }
        });
        // ajax call end

    });


    // post share ajax call
    $(".share").click(function () {
        var share = "";
        share = $(this).val();

        $(".shareid").val("http://127.0.0.1:8000/sharepage/" + share);

    });


    // copy clipboard
    $("#copybutton").click(function () {
        var copyText = "";
        copyText = $('.shareid');
        copyText.select();
        document.execCommand('copy');
        $("#copybutton").html("Copied!");
        setTimeout("jQuery('#copybutton').html('Copy');", 3000);
    });


    // word wrap
    var maxLength = 40;
    $(".show-read-more").each(function () {
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
    $(".read-more").click(function () {
        $(this).siblings(".more-text").contents().unwrap();
        $(this).remove();
    });


    // click like button
    let isAjaxInProgress = false;
    $(".like").click(function () {

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
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

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
            complete: function () {
                // Enable the button and reset the flag after AJAX call is completed
                $('#like_' + like).prop('disabled', false);
                isAjaxInProgress = false;
            }
        });


    });
    // like js code end


    // comments js code start
    // this ajax take all comment for selected post start
    $(".comment").click(function () {

        // get user session value
        var userSession = $("#usersession").val();

        // clear the comment textarea field
        $("#comment").val("");

        var comment = "";
        comment = $(this).val();
        $("#postid").val(comment);

        // get comments ajax call start
        $.ajax({
            url: "/getcomments",
            method: "POST",
            data: {
                postid: comment,
            },
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

                // clear the html content
                $("#footer").html("");

                // show total comments count
                $(".comment_count").html("");
                $(".comment_count").html('<i class="bi bi-chat-right-text-fill"></i>&nbsp;&nbsp;' + data.length);

                // check comment present or not
                if (data.length > 0) {

                    var profilephoto = "";
                    // append the html content
                    for (var a = 0; a < data.length; a++) {

                        // check profile picture present or not
                        if (data[a].profile_photo == "" || data[a].profile_photo == null) {
                            profilephoto = "../assets/brand/person.svg";
                        } else {
                            profilephoto = data[a].profile_photo;
                        }


                        // check what type of user then show comment data
                        if (userSession == data[a].userid) {
                            $("#footer").append(`
                        <div class="d-flex text-body-secondary pt-3" style="min-width: 100%;">
                            <img src="${profilephoto}" alt="pi" width="40" height="40" class="rounded-circle">
                            <p class="pb-3 pe-3 mb-0 small lh-sm border-bottom px-3 text-light" style="min-width: 90%;">
                                <b class="d-block text-light-emphasis">@${data[a].username} <small style="font-size:10px" class="text-secondary-emphasis">${data[a].created_at_human}</small></b>
                                ${data[a].comment}
                            </p>
                            <div class="dropdown">
                                <button class="btn" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <li><button class="dropdown-item commentedit" type="button"  value="${data[a].id}"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24"
                                                                    style="fill: rgba(56, 216, 131, 1);transform: ;msFilter:;">
                                                                    <path
                                                                    d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z">
                                                                    </path>
                                                                    <path
                                                                    d="M19 19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z">
                                                                    </path>
                                                                    </svg>&nbsp;Edit</button></li>
                                    <li><button class="dropdown-item commentdelete" type="button" value="${data[a].id}" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModalCommentdelete"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24"
                                                                    style="fill: rgba(214, 77, 80, 1);transform: ;msFilter:;">
                                                                    <path
                                                                        d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm10.618-3L15 2H9L7.382 4H3v2h18V4z">
                                                                    </path>
                                                                </svg>&nbsp;Delete</button></li>
                                </ul>
                            </div>
                        </div>
                        <br>
                    `);
                        } else {
                            $("#footer").append(`
                        <div class="d-flex text-body-secondary pt-3" style="min-width: 100%;">
                            <img src="${profilephoto}" alt="pi" width="40" height="40" class="rounded-circle">
                            <p class="pb-3 pe-3 mb-0 small lh-sm border-bottom px-3 text-light" style="min-width: 90%;">
                                <b class="d-block text-light-emphasis">@${data[a].username} <small style="font-size:10px" class="text-secondary-emphasis">${data[a].created_at_human}</small></b>
                                ${data[a].comment}
                            </p>
                        </div>
                        <br>
                    `);
                        }

                    }
                } else {
                    $("#footer").html("<p class='text-center'>No Comments Fount!</p>")
                }



            }
        });

    });
    // this ajax take all comment for selected post end
    $("#usercomment").on('submit', function (e) {
        e.preventDefault();

        // check what type of ajax call is trigger
        var hidden_id = $("#commentid").val();

        // close alert in 5 sec
        setTimeout(function () {
            $('#jsalerterror').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        setTimeout(function () {
            $('#jsalertsuccess').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        if (hidden_id == "") {  // new comment ajax
            //ajax call start
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                contentType: 'multipart/form-data',
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function () {
                    $(document).find('span.error-text').text('');
                },
                success: function (data) {

                    if (data.status == 0) {
                        $("#jsalerterrorcomment").show();
                        $("#jsalerterrorcomment").css("visibility", "visible");
                        $("#jsalerterrorcomment").html(data.error['comment']);

                        // reset the form with time limit
                        setTimeout(function () {
                            $("#comment").val("");
                            $("#jsalerterrorcomment").hide();
                            $("#jsalerterrorcomment").css("visibility", "hidden");
                            $('#exampleModalComment').modal('hide');
                        }, 5000);

                    }
                    if (data.message == 0) {
                        $("#jsalertsuccesscomment").show();
                        $("#jsalertsuccesscomment").css("visibility", "visible");
                        $("#jsalertsuccesscomment").html("Comment Added!");

                        // reset the form with time limit
                        setTimeout(function () {
                            $("#comment").val("");
                            $("#jsalertsuccesscomment").hide();
                            $("#jsalertsuccesscomment").css("visibility", "hidden");
                            $('#exampleModalComment').modal('hide');
                        }, 5000);


                    }

                }
            });
        } else {    // comment update ajax
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                contentType: 'multipart/form-data',
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function () {
                    $(document).find('span.error-text').text('');
                },
                success: function (data) {

                    if (data.status == 0) {
                        $("#jsalerterrorcomment").show();
                        $("#jsalerterrorcomment").css("visibility", "visible");
                        $("#jsalerterrorcomment").html(data.error['comment']);

                        // reset the form with time limit
                        setTimeout(function () {
                            $("#comment").val("");
                            $("#jsalerterrorcomment").hide();
                            $("#jsalerterrorcomment").css("visibility", "hidden");
                            $('#exampleModalComment').modal('hide');
                        }, 5000);

                    }
                    if (data.message == 0) {
                        $("#jsalertsuccesscomment").show();
                        $("#jsalertsuccesscomment").css("visibility", "visible");
                        $("#jsalertsuccesscomment").html("Comment Updated!");

                        // reset the form with time limit
                        setTimeout(function () {
                            $("#comment").val("");
                            $("#jsalertsuccesscomment").hide();
                            $("#jsalertsuccesscomment").css("visibility", "hidden");
                            $('#exampleModalComment').modal('hide');
                        }, 5000);
                    }

                }
            });
        }


    });
    // comments js code end

    // comment edit ajax call
    $("#footer").on("click", ".commentedit", function () {
        var commentedit = $(this).val();

        // comment ajax code start
        $.ajax({
            url: "/commentedit",
            method: "POST",
            data: {
                id: commentedit,
                status: 'commentedit'
            },
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

                $("#comment").val("");
                $("#commentid").val("");
                $("#comment").val(data.comment);
                $("#commentid").val(data.id);
                $(".commentbutton").html("Update");

            }
        });
    });
    // comment ajax code end

    // comment delete ajax code start
    $("#footer").on("click", ".commentdelete", function () {
        var commentdelete = $(this).val();

        $.ajax({
            url: "/commentdelete",
            method: "POST",
            data: {
                id: commentdelete,
                status: 'commentdelete'
            },
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

                $("#udcid").val(data.id);

            }
        });
    });
    // comment delete ajax code end

    // final comment delete ajax start
    $("#commentdelete").on('submit', function (e) {
        e.preventDefault();

        // close alert in 5 sec
        setTimeout(function () {
            $('#jsalerterror').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        setTimeout(function () {
            $('#jsalertsuccess').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

        //ajax call start
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            contentType: 'multipart/form-data',
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (data) {

                // scroll to top of the window
                window.location = '#';

                if (data.message == 0) {
                    $("#jsalerterror").show();
                    $("#jsalerterror").css("visibility", "visible");
                    $("#jsalerterror").html("Comment Deleted!");

                    // reset the form
                    $("#commentdelete")[0].reset();
                    $('#exampleModalCommentdelete').modal('hide');
                }

            }
        });
    });
    // final comment delete ajax end
});

// report option is hold code is there

//     < div class="dropdown" >
//                                 <button class="btn" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
//                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
//                                         <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
//                                     </svg>
//                                 </button>
//                                 <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
//                                     <li><button class="dropdown-item commentreport" type="button" value="${data[a].id}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
//                                                     fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16"
//                                                     style="fill: rgb(255, 146, 146);transform: ;msFilter:;">
//                                                     <path
//                                                         d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
//                                                 </svg>&nbsp;Report</button></li>
//                                 </ul>
//                             </div >
