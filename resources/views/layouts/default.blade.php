<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="dashboard_style/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>

    {{-- download student details --}}
    <script src="dashboard_style/printThis.js"></script>
    <script src="dashboard_style/custom.js"></script>

    <style>
        body {
            overflow-x: hidden !important;
        }
    </style>
</head>

<body oncontextmenu="return false;">
    {{-- top nav bar start --}}
    @include('layout.includes.topnavbar')
    {{-- top nav bar end --}}
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            {{-- side nav bar start --}}
            @include('layout.includes.sidenavbar')
            {{-- side nav bar start --}}
        </div>
        <div id="layoutSidenav_content">
            @section('main-content')
                <main>

                </main>
            @show
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="dashboard_style/js/scripts.js"></script>

    <!-- block the inspect element -->
    <script>
        document.onkeydown = function(e) {

            if (event.keyCode == 123) {
                return false;
            }

            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                return false;
            }

            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                return false;
            }

            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                return false;
            }

        }
    </script>

</body>

</html>
