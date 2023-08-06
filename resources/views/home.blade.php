<?php
use Carbon\Carbon;
use App\Models\Signup;
use App\Models\Profile;
// url direct access
if (session('email') == '' and session('google_id') == '') {
    // Redirect browser
    header('Location: /');
    exit();
}

// check profile status
$profile_update_status = Signup::where('id', session('user_id'))
    ->pluck('profile_update_status')
    ->first();

// auto fill profile details
$profile_details = Profile::where('userid', session('user_id'))->first();
?>
<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.112.5">
    <title>Photogram Home</title>
    <link rel="shortcut icon" href="../assets/brand/camera.png" type="image/x-icon">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/album/">

    {{-- jquery cdn link --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    {{-- ajax cdn link --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    {{-- laravel ajax meta link --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        #photo {
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        a {
            text-decoration: none;
        }
    </style>


</head>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check2" viewBox="0 0 16 16">
            <path
                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path
                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path
                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path
                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
    </svg>

    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-secondary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button"
            aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#circle-half"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"
                    aria-pressed="false" id="light">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
                    aria-pressed="false" id="dark">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#moon-stars-fill"></use>
                    </svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto"
                    aria-pressed="true" id="auto">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    System
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>


    @include('layouts.includes.usertopbar')

    {{-- profile model code start --}}

    <!-- Button trigger modal -->

    <!-- Modal -->
    @if ($profile_update_status == 0)
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form action="/profileupdate" method="post" id="profileupdate" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Profile</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 120px"
                                    name="about"></textarea>
                                <label for="floatingTextarea2">About me</label>
                            </div>
                            <div class="mt-3">
                                <select class="form-select" aria-label="Default select example" name="gender">
                                    <option selected>Gender</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Others</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload Profile Picture</label>
                                    <input class="form-control" type="file" id="formFile" name="profilephoto">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    @endif
    @if ($profile_update_status == 1)
        <div class="modal fade" id="exampleModalUpdate" class="modelupdate" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form action="/profilechange" method="post" id="profilechange" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Profile Update</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 120px"
                                    name="about">{{ $profile_details->about }}</textarea>
                                <label for="floatingTextarea2">About me</label>
                            </div>
                            <div class="mt-3">
                                <select class="form-select" aria-label="Default select example" name="gender">

                                    <option selected>Gender</option>
                                    @if ($profile_details->gender == 1)
                                        <option value="{{ $profile_details->gender }}" selected>
                                            Male
                                        </option>
                                        <option value="2">Female</option>
                                        <option value="3">Others</option>
                                    @endif
                                    @if ($profile_details->gender == 2)
                                        <option value="{{ $profile_details->gender }}" selected>
                                            Female
                                        </option>
                                        <option value="1">Male</option>
                                        <option value="3">Others</option>
                                    @endif
                                    @if ($profile_details->gender == 3)
                                        <option value="{{ $profile_details->gender }}" selected>
                                            Others
                                        </option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    @endif

                                </select>
                            </div>
                            <div class="mt-3">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload Profile Picture</label>
                                    <input class="form-control" type="file" id="formFile" name="profilephoto">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary">Update</button>
                        </div>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    @endif


    {{-- profile model code end --}}


    <main>

        <section class="py-5 text-center container">
            <form action="/photoupload" method="post" id="photoupload" enctype="multipart/form-data">
                <div class="row py-lg-5">
                    <div class="col-lg-6 col-md-8 mx-auto">
                        <h1 class="fw-light">Share Photo</h1>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload Photo</label>
                            <input class="form-control" type="file" id="formFile" name="photo">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Caption</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="caption"></textarea>
                        </div>
                        <button class="btn btn-secondary my-2" type="submit" id="submit"
                            name="submit">Share</button>
                        </p>

                        {{-- javascript validation alert for error --}}

                        <div class="alert alert-danger text-center" role="alert" id="jsalerterror">

                        </div>

                        {{-- success alert message --}}
                        <div class="alert alert-success text-center" role="alert" id="jsalertsuccess">

                        </div>

                    </div>
                </div>
                @csrf
            </form>

        </section>

        <div class="album py-5 bg-body-tertiary">
            <div class="container">

                <div class="col">
                    <div class="row">

                        @foreach ($userspost as $up)
                            <div class="col-sm-4">
                                <div class="card shadow-sm">
                                    <img src="{{ asset($up->photo) }}" alt="image" height="350" width="100%"
                                        id="photo">

                                    <div class="card-body">
                                        <p class="card-text">{{ $up->caption }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor"
                                                        class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                                                    </svg> &nbsp; Like</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-share-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z" />
                                                    </svg> &nbsp; Share</button>
                                            </div>
                                            <small
                                                class="text-body-secondary">{{ $up->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </main>

    @include('layouts.includes.userfooter')

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

{{-- js code --}}
<script>
    $(document).ready(function() {

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
            }, 5000); // <-- time in milliseconds

            setTimeout(function() {
                $('#jsalertsuccess').fadeOut('slow');
            }, 5000); // <-- time in milliseconds

            // get all input values using jquery for empty check validation
            // spinner for loading...
            $("#submit").html("<div class='spinner-border text-light' role='status'></div>")

            // ajax call start
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

                    $("#submit").html("Share")

                    if (data.status == 0) {
                        $("#jsalerterror").show();
                        $("#jsalerterror").html(data.error['photo']);
                    }
                    if (data.message == 0) {
                        $("#jsalertsuccess").show();
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
                        $("#jsalerterror").html(data.error['profilephoto']);

                        // reset the form
                        $("#profileupdate")[0].reset();
                        $('#exampleModal').modal('hide');
                    }
                    if (data.message == 0) {
                        $("#jsalertsuccess").show();
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
                        $("#jsalerterror").html(data.error['profilephoto']);

                        // reset the form
                        $("#profilechange")[0].reset();
                        $('#exampleModalUpdate').modal('hide');
                    }
                    if (data.message == 0) {
                        $("#jsalertsuccess").show();
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

    });
</script>
{{-- js code end --}}
