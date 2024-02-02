<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.112.5">
    <title>Photogram Change Password</title>
    <link rel="shortcut icon" href="../assets/brand/camera.png" type="image/x-icon">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">

    {{-- jquery cdn link --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    {{-- ajax cdn link --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

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

        /* external css */
        html,
        body {
            height: 100%;
        }

        .form-signin {
            max-width: 330px;
            padding: 1rem;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin #password {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin #passwordcrm {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .form-signin input[type="text"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        input[type=checkbox] {
            accent-color: #212529;
        }

        #submit {
            background-color: #823bb5 !important;
            color: white !important;
        }

        input[type=checkbox] {
            accent-color: #823bb5;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="sign-in.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">

    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-5">
                <main class="form-signin w-100 m-auto">
                    <form action="/changepassword" method="post" id="changepassword_form">
                        <img class="mx-auto d-block mb-4" src="../assets/brand/logo1.png" alt="" width="250"
                            height="250">
                        <h1 class="h3 mb-3 fw-normal text-center">Change Password</h1>

                        <div class="form-floating">
                            <input name="password" type="password" class="form-control" id="password"
                                placeholder="name@example.com" required>
                            <label for="floatingInput">New Password</label>
                        </div>
                        <div class="form-floating">
                            <input name="password_confirmation" type="password" class="form-control" id="passwordcrm"
                                placeholder="Password" required>
                            <label for="floatingPassword">Confirm Password</label>
                        </div>

                        <div class="checkbox mb-3 text-center">
                            <label class="checkbox-wrap checkbox-dark" for="checkbox">Show
                                Password
                                <input type="checkbox" id="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <button class="w-100 btn btn-lg mb-3" type="submit" name="submit" id="submit">Change
                            Password</button>

                        <p class="text-center"><a href="/" class="link-dark" style="text-decoration: none;">Go to
                                Signin</a></p>

                        {{-- javascript validation alert for error --}}
                        <div class="alert alert-danger text-center" role="alert" id="jsalerterror"
                            style="visibility:hidden">

                        </div>

                        {{-- success alert message --}}
                        <div class="alert alert-success text-center" role="alert" id="jsalertsuccess"
                            style="visibility:hidden">

                        </div>

                    </form>
                </main>

            </div>
        </div>
    </div>



    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

{{-- js code --}}
<script src="../assets/dist/js/changepassword.min.js"></script>
{{-- js code end --}}

</html>
