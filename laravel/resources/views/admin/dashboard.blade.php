@extends('layouts.app')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('namaHalaman','Dashboard : '. $tanggal)
@section('konten')
<div class="row">
          <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-info">
                        <div class="inner">
                          <h3>{{$sudahAbsenMasuk}}</h3>

                          <p>Sudah Absen Masuk</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-code-download"></i>
                        </div>
            
                      </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $belumAbsenMasuk }}</h3>

                <p>Belum Absen Masuk</p>
              </div>
              <div class="icon">
                <i class="ion ion-close-circled"></i>
              </div>
 
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $sudahAbsenPulang }}</h3>

                <p>Sudah Absen Pulang</p>
              </div>
              <div class="icon">
                <i class="ion ion-arrow-up-a"></i>
              </div>
 
            </div>
          </div>
  
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $belumAbsenPulang }}</h3>

                <p>Belum Absen Pulang</p>
              </div>
              <div class="icon">
                <i class="ion ion-load-a"></i>
              </div>
 
            </div>
          </div>
  



          <!-- /.col -->
</div>
<div class="row">
  <div class="col-lg-6">
      <div class="card">
        <div class="card-header bg-primary">
        <h1 class="card-title">Hadir</h1>
        </div>
        <div class="card-body">
        <table id="daftarHadir" class="table table-bordered table-striped dataTable dtr-inline collapsed table-hover" >
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
            </tr>
          </thead>
          <tbody>
          @foreach($daftarNamaHadir as $dnh)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td> {{ $dnh->user->name }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
      </div>
  </div>
  <div class="col-lg-6">
      <div class="card">
        <div class="card-header bg-danger">
        <h1 class="card-title">Belum Hadir</h1>
        </div>
        <div class="card-body">
        <table id="daftarBelumHadir" class="table table-bordered table-striped dataTable dtr-inline collapsed table-hover" >
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
            </tr>
          </thead>
          <tbody>
          @foreach($daftarNamaBelumHadir as $dnbh)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td> {{ $dnbh}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
      </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-4">
      <div class="card card-outline card-warning">
        <div class="card-header">
        <h1 class="card-title">Izin</h1>
        </div>
        <div class="card-body">
        <table id="daftarIzin" class="table table-bordered table-striped dataTable dtr-inline collapsed table-hover" >
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
            </tr>
          </thead>
          <tbody>
          @foreach($daftarNamaIzin as $dni)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td> {{ $dni->user->name }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      
             
           
        </div>
      </div>
  </div>
  <div class="col-lg-4">
      <div class="card card-outline card-success">
        <div class="card-header">
        <h1 class="card-title">Dinas Luar</h1>
        </div>
        <div class="card-body">
        <table id="daftarDL" class="table table-bordered table-striped dataTable dtr-inline collapsed table-hover" >
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
            </tr>
          </thead>
          <tbody>
          @foreach($daftarNamaDL as $dnd)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td> {{ $dnd->user->name }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      
             
           
        </div>
      </div>
  </div>
  <div class="col-lg-4">
      <div class="card card-outline card-primary">
        <div class="card-header">
        <h1 class="card-title">Sakit</h1>
        </div>
        <div class="card-body">
        <table id="daftarSakit" class="table table-bordered table-striped dataTable dtr-inline collapsed table-hover" >
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
            </tr>
          </thead>
          <tbody>
          @foreach($daftarNamaSakit as $dns)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td> {{ $dns->user->name }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      
             
           
        </div>
      </div>
  </div>
</div>
<div class="row">
    <div class="col-12">
    <div class="card ">
    <div class="card-header ">
        
        <h1 class="card-title">{{ $tanggal }}</h1>
    <div class="card-tools">
    <button onClick="window.location.reload();" class="btn btn-success btn-sm"><i class="fas fa-sync-alt"></i> Segarkan</button>
    </div>
        
    </div>
    <div class="card-body">
        <table id="example2" class="table table-bordered table-striped dataTable dtr-inline collapsed table-hover">
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
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        $('#daftarHadir').DataTable({
          "responsive":true,
          "lengthChange":false,
          "paging":false,
          "scrollY":200,
          "scrollCollapse":true,
          "scroller":true,
          "searching":false,
          "info":false

        });
        $('#daftarDL').DataTable({
          "responsive":true,
          "lengthChange":false,
          "paging":false,
          "scrollY":200,
          "scrollCollapse":true,
          "scroller":true,
          "searching":false,
          "info":false

        });
        $('#daftarIzin').DataTable({
          "responsive":true,
          "lengthChange":false,
          "paging":false,
          "scrollY":200,
          "scrollCollapse":true,
          "scroller":true,
          "searching":false,
          "info":false

        });
        $('#daftarSakit').DataTable({
          "responsive":true,
          "lengthChange":false,
          "paging":false,
          "scrollY":200,
          "scrollCollapse":true,
          "scroller":true,
          "searching":false,
          "info":false

        });
        $('#daftarBelumHadir').DataTable({
          "responsive":true,
          "lengthChange":false,
          "paging":false,
          "scrollY":200,
          "scrollCollapse":true,
          "scroller":true,
          "searching":false,
          "info":false

        });
    });

    
</script>
@endsection