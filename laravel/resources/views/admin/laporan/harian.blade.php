@extends('layouts.app')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('namaHalaman','Laporan Harian')
@section('konten')
<div class="card">
    <div class="card-header">
        <h4>{{ $tanggal }}</h4>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Foto (<span style="color: green;">Masuk</span> || <span style="color: blue;">Pulang</span> || <span style="color: yellow;">Izin</span>)</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i=1;
                @endphp
                @foreach ($dataAbsenHarian as $dah)
                @foreach($dah as $subdah)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $subdah['name'] }} <br>NIP.{{$subdah['nip']}}</td>
                    <td>{{ $subdah['jam_masuk'] }}</td>
                    <td>{{$subdah['jam_pulang']}}</td>
                    <td>
                        @if($subdah['foto_masuk']=='-' or $subdah['foto_masuk']=='0' or $subdah['foto_masuk']=='')
                        @else
                        <img src="{{asset('storage/'.$subdah['foto_masuk'])}}" width="150" alt="Foto Masuk" style="border: 2px solid green; ">
                        @endif
                        @if($subdah['foto_pulang']=='-' or $subdah['foto_pulang']=='0' or $subdah['foto_pulang']=='')
                        @else
                        
                        <img src="{{asset('storage/'.$subdah['foto_pulang'])}}" width="150" alt="Foto Pulang" style="border: 2px solid blue; " > 
                        @endif
                        @if($subdah['foto_izin']=='-' or $subdah['foto_izin']=='0' or $subdah['foto_izin']=='')
                        @else
                        
                        <img src="{{asset('storage/'.$subdah['foto_izin'])}}" width="150" alt="Foto Izin" style="border: 2px solid yellow; ">
                        @endif
                    </td>

                </tr>
                @endforeach
                @php
                $i++
                @endphp
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