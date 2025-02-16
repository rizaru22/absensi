@extends('layouts.app')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.css')}}">

<style>
    @media print {
        td {
            white-space: pre-wrap;
            /* Memastikan line breaks berfungsi */
        }

        @page {
            size: landscape;
        }
    }

    .table {
        font-size: 1em;
    }
</style>
@endsection
@section('namaHalaman','Laporan Bulanan')
@section('konten')
<div class="card">

    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed table-hover">
            <thead>

                <tr>
                    <th>No</th>

                    @foreach($header as $hd)
                    <th>{{ $hd }}</th>
                    @endforeach
                </tr>

            </thead>
            <tbody>
                @foreach($data as $dt)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dt['nama'] }} <br> NIP.{{$dt['nip']}}</td>
                    @foreach($dt['absen'] as $subdt)
                    <td>{{ $subdt['jam_masuk'] }}<br> s.d <br>{{ $subdt['jam_pulang'] }}</td>
                    @endforeach
                </tr>
                @endforeach


     

            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.js')}}"></script>
<script src="{{asset('plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.js')}}"></script>

<script>
    $(function() {
        $("#example1").DataTable({
            "paging":true,
            "responsive": false,
            "lengthChange": true,
            "autoWidth": false,
            "scrollX":true,
            "fixedColumns": {
                        leftColumns:2
            },
            'buttons': [
                // {
                //     extend: 'print',
                //     text: 'Print',

                //     exportOptions: {
                //         stripHtml: false,

                //     },
                //     customize: function(win) {

                //         var last = null;
                //         var current = null;
                //         var bod = [];

                //         var css = '@page { size: landscape; }',
                //             head = win.document.head || win.document.getElementsByTagName('head')[0],
                //             style = win.document.createElement('style');

                //         style.type = 'text/css';
                //         style.media = 'print';

                //         if (style.styleSheet) {
                //             style.styleSheet.cssText = css;
                //         } else {
                //             style.appendChild(win.document.createTextNode(css));
                //         }

                //         head.appendChild(style);
                //         $(win.document.body)
                //             .css('font-size', '8pt');
                            
                //     }
                // },
                // {
                //     extend: 'pdfHtml5',
                //     orientation: 'landscape',
                //     pageSize: 'LEGAL'
                // },
                {
                    extend:'excel',
                    text:'Excel'
                }
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection