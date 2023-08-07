<?php
// url direct access
use App\Models\Signup;
use App\Models\user_feedback;
if (session('username') == '') {
    // Redirect browser
    header('Location: /adminlogin');
    exit();
}

$usersfeedback = Signup::join('user_feedbacks', 'signups.id', '=', 'user_feedbacks.userid')->get(['signups.*', 'user_feedbacks.feedback']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Photogram Admin Feedback</title>
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
                <h3 class="text-center mt-3">Admin Feedback</h3>
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
                                    <th scope="col">Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usersfeedback as $uf)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        {{-- this loop interation is used to create serial no. --}}
                                        <td>{{ $uf->username }}</td>
                                        <td>{{ $uf->email }}</td>
                                        <td>{{ $uf->mobile ?? '---' }}</td>
                                        <td>{{ $uf->google_id ?? '---' }}</td>
                                        <td>{{ $uf->feedback }}</td>
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

        });
    </script>
    {{-- datatable script over --}}
</body>

</html>
