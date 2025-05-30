<?php
use Carbon\Carbon;
use App\Models\Signup;
use App\Models\Profile;
use App\Models\Photo;
use App\Models\user_feedback;
use App\Models\follow_user_table;
use App\Models\Follower_count;

// url direct access
if (session('email') == '' and session('google_id') == '') {
    // Redirect browser
    header('Location: /');
    exit();
}

// get following count
$following = follow_user_table::where('user_id', session('user_id'))->pluck('follow_count')->first();

// get followers count
$followers = Follower_count::where('follower_user_id', session('user_id'))->pluck('follower_count')->first();

// check profile status
$profile_update_status = Signup::where('id', session('user_id'))->pluck('profile_update_status')->first();

// auto fill profile details
$profile_details = Profile::where('userid', session('user_id'))->first();

// get user details for show profile
$userid = $userid ?? '';
if ($userid != '') {
    $usersfeedback = Signup::join('profiles', 'signups.id', '=', 'profiles.userid')
        ->join('photos', 'signups.id', '=', 'photos.userid')
        ->where('signups.id', '=', $userid)
        ->get(['signups.*', 'profiles.*', 'photos.photo']);
} else {
    $usersfeedback = Signup::join('profiles', 'signups.id', '=', 'profiles.userid')
        ->join('photos', 'signups.id', '=', 'photos.userid')
        ->where('signups.id', '=', session('user_id'))
        ->get(['signups.*', 'profiles.*', 'photos.photo']);
}

foreach ($usersfeedback as $uf) {
    $username = $uf['username'];
    $useremail = $uf['email'];
    $usermobile = $uf['mobile'];
    $usergender = $uf['gender'];
    if ($usergender == 1) {
        $usergender = 'Male';
    } elseif ($usergender == 2) {
        $usergender = 'Female';
    } else {
        $usergender = 'Others';
    }
    $userabout = $uf['about'];
    $userimage = $uf['profile_photo'];
}

// get post count
$getpostcount = Photo::where('userid', session('user_id'))->count();

// get user feedback count
$getfeedbackcount = user_feedback::where('userid', session('user_id'))->count();

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
    <title>Photogram User Profile</title>
    <link rel="shortcut icon" href="../assets/brand/camera.png" type="image/x-icon">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/album/">

    {{-- jquery cdn link --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    {{-- ajax cdn link --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    {{-- laravel ajax meta link --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- rich text editor -->
    <script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>



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

        #myToast {
            position: absolute;
            top: 75px;
            right: 0;
            margin-right: 10px;
        }

        /* Style for the search results container */

        #searchResults {
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #212529;
            background-color: #3c3f42;
            z-index: 1;
            margin-top: 55px;
            border-radius: 10px;
        }

        /* Style for each search result item */
        #searchResults li {
            padding: 10px;
            cursor: pointer;
        }

        /* Style for selected search result item */
        #searchResults li:hover {
            background-color: #212529;
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

    <div class="modal fade" id="exampleModalFeedback" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="/userfeedback" method="post" id="userfeedback" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Feedback</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="viewprofilefeedback"
                                style="height: 200px; width: 400px" name="feedback"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>


    {{-- profile model code end --}}

    {{-- delete account model code start --}}
    <div class="modal fade" id="exampleModalaccount" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="/accountdelete" method="post" id="accountdelete" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Account
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            I want delete this photogram account
                        </div>
                        <div class="mt-5" onselectstart="return false" oncut="return false" oncopy="return false"
                            onpaste="return false" ondrag="return false" ondrop="return false">
                            <label for="deleteaccount" class="form-label">To confirm, type <span
                                    class="badge text-bg-info">{{ $username }}</span> in the
                                box below</label>
                            <input type="text" class="form-control" id="deleteaccount" name="deleteaccount"
                                placeholder="Username" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" id="delete">Delete</button>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>

    {{-- delete accent model code end --}}

    <main>

        <div class="album py-5 bg-body-tertiary">
            @if ($profile_update_status == 0)
                <div class="toast position-fixed end-2 p-3" id="myToast" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="toast-header">
                        <img src="../assets/brand/camera.png" class="rounded me-2" alt="..." height="20px"
                            width="20px">
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        Fill the profile
                    </div>
                </div>
            @endif
            <div class="container">

                <div class="col">
                    <div class="row">

                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-sm-6">
                                    <img src="{{ asset($userimage ?? '../assets/brand/person.svg') }}"
                                        class="rounded mx-auto d-block" alt="image" height="250" width="250"
                                        id="photo">
                                </div>

                                <div class="col-sm-3">
                                    <h3 class="text-info">Following : <b>{{ $following ?? '0' }}</b></h3>

                                    <div class="pt-5">
                                        Username : <b>{{ $username ?? '---' }}</b>
                                    </div>

                                    <div class="pt-5">
                                        Mobile : <b>{{ $usermobile ?? '---' }}</b>
                                    </div>

                                    <div class="pt-5">
                                        About : <b>{{ $userabout ?? '---' }}</b>
                                    </div>

                                    <div class="pt-5">
                                        Feedback : <b>{{ $getfeedbackcount ?? '---' }}</b>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <h3 class="text-info">Followers : <b>{{ $followers ?? '0' }}</b></h3>

                                    <div class="pt-4">
                                        Email : <b>{{ $useremail ?? '---' }}</b>
                                    </div>

                                    <div class="pt-5">
                                        Gender : <b>{{ $usergender ?? '---' }}</b>
                                    </div>

                                    <div class="pt-5">
                                        Post : <b>{{ $getpostcount ?? '---' }}</b>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-sm-6 text-info">

                                </div>


                            </div>
                        </div>

                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-sm-6">

                                </div>
                                <div class="col-sm-6">

                                </div>
                            </div>
                        </div>
                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-sm-6">

                                </div>
                                <div class="col-sm-6">

                                </div>
                            </div>
                        </div>
                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-sm-6">

                                </div>
                                <div class="col-sm-6">

                                </div>
                            </div>
                        </div>
                        <div class="container mt-2">
                            <div class="row">
                                <div class="col-sm-12">

                                </div>
                            </div>
                        </div>

                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-danger mx-auto d-block"
                                        data-bs-toggle="modal" data-bs-target="#exampleModalaccount">
                                        Delete Account
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- javascript validation alert for error --}}

                        <div class="alert alert-danger text-center mt-3" role="alert" id="jsalerterror"
                            style="visibility:hidden">

                        </div>

                        {{-- success alert message --}}
                        <div class="alert alert-success text-center mt-3" role="alert" id="jsalertsuccess"
                            style="visibility:hidden">

                        </div>

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
<script src="../assets/dist/js/viewprofile.min.js"></script>
{{-- js code end --}}
