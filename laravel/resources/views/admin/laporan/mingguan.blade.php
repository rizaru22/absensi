@extends('layouts.app')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<style>
    @media print {
        td {
            white-space: pre-wrap;
            /* Memastikan line breaks berfungsi */
        }
    }
</style>
@endsection
@section('namaHalaman','Laporan Mingguan')
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
                    <td>{{ $dt['nama'] }} <br>NIP. {{ $dt['nip'] }}</td>
                    @foreach($dt['absen'] as $subdt)
                    <td>{{ $subdt['jam_masuk'] }}<br>s.d<br>{{ $subdt['jam_pulang'] }}</td>
                    @endforeach
                    <td>{{ $dt['total_jam_kerja_per_minggu'] }}</td>
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
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            'buttons': [{
                extend: 'print',
                text: 'Print',
                exportOptions: {
                    stripHtml: false
                }
            }],
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