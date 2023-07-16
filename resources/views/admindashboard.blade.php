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
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="/admindashboardview"> <i class="fa-solid fa-camera me-2"></i>
            Photogram</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/adminlogout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Admin</div>
                        <a class="nav-link active" href="/admin_dashboard">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-gauge"></i></div>
                            Admin Dashboard
                        </a>
                        <a class="nav-link" href="/admin_feedback">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-comments"></i></div>
                            Feedback Management
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    ADMIN
                </div>
            </nav>
        </div>
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
                                        <td>{{ $user->mobile }}</td>
                                        <td>{{ $user->active_status }}</td>
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

    <script>
        $(document).ready(function() {
            // datatable code start
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                                .length + 1).join('*').split('');
                            doc.defaultStyle.alignment = 'left';
                            doc.styles.tableHeader.alignment = 'left';
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    'colvis'
                ]
            });
            // datatable code end

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // click block button action
            $(".block").click(function() {
                var blockvalues = $(this).val();

                $.ajax({
                    url: "/accountstatus",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: blockvalues,
                        status: 'block'
                    },
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {

                        //window.location = '/admindashboardview';
                        var tbody = $('#example tbody');
                        tbody.empty();
                        var sno = 1;
                        data.forEach(function(user) {
                            var row = `<tr>
                            <td>${sno}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td>${user.mobile}</td>
                            <td>${user.active_status}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm block"
                                                value="(${user.id})">Block</button>
                                <button type="button" class="btn btn-success btn-sm unblock"
                                                value="(${user.id})">Unblock</button>
                            </td>
                        </tr>`;
                            tbody.append(row);
                            sno++;
                        });

                    }
                });
                // ajax call end
            });


            // click unblock button action
            $(".unblock").click(function() {
                var unblockvalues = $(this).val();

                $.ajax({
                    url: "/accountstatus",
                    method: "POST",
                    data: {
                        id: unblockvalues,
                        status: 'unblock'
                    },
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {

                        var tbody = $('#example tbody');
                        tbody.empty();
                        var sno = 1;
                        data.forEach(function(user) {
                            var row = `<tr>
                            <td>${sno}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td>${user.mobile}</td>
                            <td>${user.active_status}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm block"
                                                value="(${user.id})">Block</button>
                                <button type="button" class="btn btn-success btn-sm unblock"
                                                value="(${user.id})">Unblock</button>
                            </td>
                        </tr>`;
                            tbody.append(row);
                            sno++;
                        });

                    }
                });
                // ajax call end
            });


        });
    </script>
    {{-- datatable script over --}}
</body>

</html>
