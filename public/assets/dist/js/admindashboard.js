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

                        var tbody = $('#example tbody');
                        tbody.empty();
                        var sno = 1;
                        data.forEach(function(user) {
                            if (user.active_status == 0) {
                                var status = "Active";
                            } else {
                                status = "Inactive";
                            }
                            var row = `<tr>
                            <td>${sno}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td>${user.mobile ?? '---'}</td>
                            <td>${user.google_id ?? '---'}</td>
                            <td>${status}</td>
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
                            if (user.active_status == 0) {
                                var status = "Active";
                            } else {
                                status = "Inactive";
                            }
                            var row = `<tr>
                            <td>${sno}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td>${user.mobile ?? '---'}</td>
                            <td>${user.google_id ?? '---'}</td>
                            <td>${status}</td>
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
