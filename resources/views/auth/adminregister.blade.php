<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.112.5">
    <title>Photogram Admin Signup</title>
    <link rel="shortcut icon" href="../assets/brand/camera.png" type="image/x-icon">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">

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

        .form-signin input[type="username"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: -1px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="sign-in.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">

    <div class="container">
        <div class="row">
            <div class="col-sm-6 mt-3">
                <img src="../assets/brand/cameraone.png" alt="" height="550" width="550">
            </div>
            <div class="col-sm-6">
                <main class="form-signin w-100 m-auto">
                    <form action="/adminregistersubmit" method="post" id="admin_signup_form">
                        <img class="mx-auto d-block mb-4" src="../assets/brand/camera.png" alt="" width="72"
                            height="65">
                        <h1 class="h3 mb-3 fw-normal text-center">Admin Register</h1>

                        <div class="form-floating">
                            <input name="username" type="username" class="form-control" id="username"
                                placeholder="name@example.com" required>
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating">
                            <input name="email" type="email" class="form-control" id="email"
                                placeholder="name@example.com" required>
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating">
                            <input name="password" type="password" class="form-control" id="password"
                                placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        @csrf

                        <button class="w-100 btn btn-lg btn-dark mb-3 mt-3" type="submit" id="submit"
                            name="submit">Signup</button>

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

    {{-- js code --}}
    <script src="../assets/dist/js/adminregister.min.js"></script>
    {{-- js code end --}}

</body>

</html>
