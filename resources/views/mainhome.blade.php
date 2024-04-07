<?php
use Carbon\Carbon;
use App\Models\Signup;
use App\Models\Profile;
use App\Models\Photo;
use App\Models\Like_button_stage;
use Illuminate\Support\Facades\Crypt;

// url direct access
if (session('email') == '' and session('google_id') == '') {
    // Redirect browser
    header('Location: /');
    exit();
}

// check profile status
$profile_update_status = Signup::where('id', session('user_id'))->pluck('profile_update_status')->first();

// auto fill profile details
$profile_details = Profile::where('userid', session('user_id'))->first();

// get random post for home page
$randompost = Photo::inRandomOrder()->limit(6)->get();

$usersWithPosts = Photo::join('signups', 'signups.id', '=', 'photos.userid')
    ->join('likes', 'likes.post_id', '=', 'photos.id')
    ->where('photos.deleted', '=', 0)
    ->inRandomOrder()
    ->limit(6)
    ->get(['photos.*', 'likes.like']);

// get all user like post id value
$liked_post_data = Like_button_stage::where('user_id', '=', session('user_id'))
    ->where('like_button_stage', '=', 1)
    ->get(['post_id']);
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

    <!-- rich text editor -->
    <script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>

    {{-- laravel ajax meta link --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- bootstrap icon cdn --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


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

        #cke_1_top,
        #cke_1_bottom {
            background-color: #c3c6ca;
        }

        .show-read-more .more-text {
            display: none;
        }

        /* #myToast {
            position: absolute;
            top: 79%;
            right: 0;
            margin-right: 86%;
            width: 13%;
            padding-right: 10px;
        }

        #myToastunlike {
            position: absolute;
            top: 79%;
            right: 0;
            margin-right: 86%;
            width: 13%;
            padding-right: 10px;
        } */
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

    {{-- feedback model start --}}
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
                            <textarea class="form-control" placeholder="Leave a comment here" id="feedback" style="height: 200px; width: 400px"
                                name="feedback"></textarea>
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
    {{-- feedback model end --}}

    {{-- post share model start --}}
    <div class="modal fade" id="exampleModalPostshare" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Post Share</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="btn-group d-flex align-items-center justify-content-center" role="group"
                        aria-label="Basic example">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control shareid" placeholder="Recipient's username"
                                aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-info" id="copybutton">Copy</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- post share model end --}}

    {{-- comments model start --}}
    <div class="modal fade" id="exampleModalComment" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="/usercomment" method="post" id="usercomment" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Comment</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating pb-2">
                            <textarea class="form-control" placeholder="Leave a comment here" id="comment" style="height: 100%;"
                                name="comment" required>
                            </textarea>
                            <input type="hidden" name="postid" id="postid" value="" readonly>
                            <input type="hidden" name="commentid" id="commentid" value="" readonly>
                        </div>

                        {{-- javascript validation alert for error --}}

                        <div class="alert alert-danger text-center" role="alert" id="jsalerterrorcomment"
                            style="visibility:hidden">

                        </div>

                        {{-- success alert message --}}
                        <div class="alert alert-success text-center" role="alert" id="jsalertsuccesscomment"
                            style="visibility:hidden">

                        </div>


                        <div>
                            <div class="float-start">
                                <span class="badge text-bg-info comment_count"></span>
                            </div>
                            <div class="float-end">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submit" name="submit"
                                    class="btn btn-info commentbutton">Comment</button>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer overflow-auto" style="max-height: 300px;" id="footer">
                        {{-- <div class="d-flex text-body-secondary pt-3">
                            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title>Placeholder</title>
                                <rect width="100%" height="100%" fill="#007bff"></rect><text x="50%" y="50%"
                                    fill="#007bff" dy=".3em">32x32</text>
                            </svg>
                            <p class="pb-3 pe-3 mb-0 small lh-sm border-bottom">
                                <b class="d-block text-gray-dark">@username <small style="font-size:10px">1 month
                                        ago</small></b>
                                Some representative placeholder content.
                            </p>
                            <div class="dropdown">
                                <button class="btn" type="button" id="dropdownMenu2" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                        <path
                                            d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <li><button class="dropdown-item" type="button">Edit</button></li>
                                    <li><button class="dropdown-item" type="button">Delete</button></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                </div>
                @csrf
            </form>

        </div>
    </div>
    {{-- comments model end --}}

    {{-- comment delete confirmation model start --}}
    <div class="modal fade" id="exampleModalCommentdelete" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <form action="/commentdeletefinal" method="post" id="commentdelete" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Comment Delete</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <p>If you want to delete this Comment?</p>

                        <input type="hidden" class="form-control mt-2" id="udcid" name="udcid"
                            value="" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="commentdeletesubmit" name="commentdeletesubmit"
                            class="btn btn-danger">Delete</button>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
    {{-- comment delete confirmation model end --}}

    <main>
        <input type="hidden" name="session" id="usersession" value="{{ session('user_id') }}">
        <div class="album py-5 bg-body-tertiary">
            <div class="container">

                {{-- <div class="toast position-fixed text-bg-success end-2 p-3" id="myToast" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="toast-header text-bg-success">
                        <img src="../assets/brand/camera.png" class="rounded me-2" alt="..." height="20px"
                            width="20px">
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        Post Liked
                    </div>
                </div>

                <div class="toast position-fixed text-bg-info end-2 p-3" id="myToastunlike" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="toast-header text-bg-info">
                        <img src="../assets/brand/camera.png" class="rounded me-2" alt="..." height="20px"
                            width="20px">
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        Post Unliked
                    </div>
                </div> --}}

                <div class="col">

                    {{-- javascript validation alert for error --}}

                    <div class="alert alert-danger text-center" role="alert" id="jsalerterror"
                        style="visibility:hidden">

                    </div>

                    {{-- success alert message --}}
                    <div class="alert alert-success text-center" role="alert" id="jsalertsuccess"
                        style="visibility:hidden">

                    </div>


                    <div class="row">

                        @foreach ($usersWithPosts as $up)
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3 mt-4">
                                <div class="card shadow-sm">
                                    <img src="{{ asset($up->photo) }}" alt="image" height="350" width="100%"
                                        id="photo">

                                    <div class="card-body">
                                        <p class="card-text show-read-more">{{ $up->caption }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" value="{{ $up->id }}"
                                                    class="btn btn-sm btn-outline-secondary like"
                                                    id="like_{{ $up->id }}">

                                                    @php
                                                        $isLiked = false;
                                                        foreach ($liked_post_data as $like) {
                                                            if ($like->post_id == $up->id) {
                                                                $isLiked = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    <span id="likestatusupdate_{{ $up->id }}">

                                                    </span>
                                                    <span id="likestatusupdatemain_{{ $up->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24"
                                                            style="fill: {{ $isLiked ? '#0082f3' : '#8f959c' }};transform: ;msFilter:;">
                                                            <path
                                                                d="M4 21h1V8H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2zM20 8h-7l1.122-3.368A2 2 0 0 0 12.225 2H12L7 7.438V21h11l3.912-8.596L22 12v-2a2 2 0 0 0-2-2z">
                                                            </path>
                                                        </svg>
                                                    </span>

                                                    <span
                                                        id="likecount_{{ $up->id }}">{{ $up->like }}</span>

                                                </button>
                                                <button type="button" value="{{ Crypt::encryptString($up->id) }}"
                                                    class="btn btn-sm btn-outline-secondary share"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalPostshare"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24"
                                                        style="fill: rgb(215, 107, 241);transform: ;msFilter:;">
                                                        <path
                                                            d="M3 12c0 1.654 1.346 3 3 3 .794 0 1.512-.315 2.049-.82l5.991 3.424c-.018.13-.04.26-.04.396 0 1.654 1.346 3 3 3s3-1.346 3-3-1.346-3-3-3c-.794 0-1.512.315-2.049.82L8.96 12.397c.018-.131.04-.261.04-.397s-.022-.266-.04-.397l5.991-3.423c.537.505 1.255.82 2.049.82 1.654 0 3-1.346 3-3s-1.346-3-3-3-3 1.346-3 3c0 .136.022.266.04.397L8.049 9.82A2.982 2.982 0 0 0 6 9c-1.654 0-3 1.346-3 3z">
                                                        </path>
                                                    </svg> </button>
                                                <button type="button" value="{{ Crypt::encryptString($up->id) }}"
                                                    id="comment_{{ $up->id }}"
                                                    class="btn btn-sm btn-outline-secondary comment"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalComment"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor"
                                                        class="bi bi-chat-right-text-fill" viewBox="0 0 16 16"
                                                        style="fill: rgb(37, 193, 255);transform: ;msFilter:;">
                                                        <path
                                                            d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h9.586a1 1 0 0 1 .707.293l2.853 2.853a.5.5 0 0 0 .854-.353zM3.5 3h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1 0-1m0 2.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1 0-1m0 2.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <small
                                                class="text-body-secondary ps-2">{{ $up->created_at->diffForHumans() }}</small>
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
<script src="../assets/dist/js/mainhome.min.js"></script>
{{-- js code end --}}
