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

<div class="card">
    <div class="card-body">
        <table id="example2" class="table table-bordered table-striped dataTable dtr-inline collapsed table-hover">
            <thead>
                <tr>
                    <th>No</th>     
                    <th>Nama</th>     
                    <th>NIP</th>     
                    <th>Normal</th>     
                    <th>Riil</th>     
                    <th>Absen</th>     
                    <th>Trlmbt</th>     
                    <th>Plg. Cpt</th>     
                    <th>Lmbr</th>     
                    <th>Jml. Izin</th>     
                    <th>D. Luar</th>     
                    <th>N/In</th>     
                    <th>N/Out</th>     
                    <th>Scan</th>     
                    <th>Sakit</th>     
                    <th>Cuti</th>     
                    <th>Izin</th>     
                    <th>Jam Kerja</th>     
                    <th>Rata2</th>     
                </tr>
               
            </thead>
            <tbody>
                <tr>
                    <td >&nbsp;</td>     
                    <td >&nbsp;</td>     
                    <td >&nbsp;</td>     
                    <td>Hari</td>     
                    <td>Hari</td>     
                    <td>Hari</td>     
                    <td>Menit</td>     
                    <td>Menit</td>     
                    <td>Jam</td>     
                    <td>&nbsp;</td>     
                    <td>Hari</td>     
                    <td>Kali</td>     
                    <td>Kali</td>     
                    <td>Kali</td>     
                    <td>Jam</td>     
                    <td>Jam</td>     
                    <td>Jam</td>     
                    <td>Jam</td>     
                    <td>%</td>     
                    
                </tr>
               @foreach($rekap as $rek)
               <tr>
                <td >{{ $loop->iteration }}</td>     
                    <td >{{ $rek['nama'] }}</td>     
                    <td >{{ $rek['nip'] }}</td>     
                    <td>{{ $rek['normal_hari'] }}</td>     
                    <td>{{ $rek['riil_hari'] }}</td>     
                    <td>{{ $rek['absen_hari'] }}</td>     
                    <td>&nbsp;</td>     
                    <td>&nbsp;</td>     
                    <td>&nbsp;</td>     
                    <td>{{ $rek['jml_izin'] }}</td>     
                    <td>{{ $rek['dinas_luar'] }}</td>     
                    <td>1</td>     
                    <td>1</td>     
                    <td>2</td>     
                    <td>{{ $rek['sakit_jam'] }}</td>     
                    <td>&nbsp;</td>     
                    <td>{{ $rek['izin_jam'] }}</td>     
                    <td>{{ $rek['total_jam_kerja_bulan'] }}</td>     
                    <td>{{ $rek['rata2'] }}</td>     
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
                {
                    extend:'excel',
                    text:'Excel'
                }
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging":true,
            "responsive": false,
            "lengthChange": true,
            "autoWidth": false,
            "scrollX":true,
            "fixedColumns": {
                        leftColumns:2
            },
            'buttons': [
                {
                    extend:'excel',
                    text:'Excel'
                }
            ],
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection