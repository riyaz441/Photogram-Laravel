<?php
// url direct access
if (session('username') == '') {
    // Redirect browser
    header('Location: /adminlogin');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Photogram Admin Dashboard</title>
    <link rel="shortcut icon" href="../assets/brand/camera.png" type="image/x-icon">
    <link rel="shortcut icon" href="images/person-circle.svg" type="image/x-icon">
    <link href="dashboard_style/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    {{-- ajax cdn link --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    {{-- laravel ajax meta link --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- jquery cdn link --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <!-- data table cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
</head>

<body>

    @include('layouts.includes.topnavbar')

    <div id="layoutSidenav">

        @include('layouts.includes.sidenavbar')

        <div id="layoutSidenav_content">
            <main>
                <h3 class="text-center mt-3">Admin Dashboard</h3>
                <div class="container">
                    <div class="container">
                        <table class="table table-bordered mt-3" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Google Id</th>
                                    <th scope="col">Active Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        {{-- this loop interation is used to create serial no. --}}
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile ?? '---' }}</td>
                                        <td>{{ $user->google_id ?? '---' }}</td>
                                        @if ($user->active_status == 0)
                                            <td>Active</td>
                                        @else
                                            <td>Inactive</td>
                                        @endif
                                        <td><button type="button" class="btn btn-danger btn-sm block"
                                                value="{{ $user->id }}">Block</button>
                                            <button type="button" class="btn btn-success btn-sm unblock"
                                                value="{{ $user->id }}">Unblock</button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="dashboard_style/js/scripts.js"></script>

    {{-- datatable script start --}}
    <!-- data table js cdn -->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

    <script src="../assets/dist/js/admindashboard.js"></script>
    {{-- datatable script over --}}
</body>

</html>
