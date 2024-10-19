@extends('layouts.app')

@section('style')
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('namaHalaman','Laporan Harian')
@section('konten')
<div class="row">
    <div class="col-md-6">
    <div class="card">
    <div class="card-body">
      <form action="{{route('laporanharian')}}" method="post">
        @csrf
        <div class="form-group">
                  <label>Tanggal:</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" id="tanggal" name="tanggal">
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success float-right"><i class="fas fa-eye"></i> Lihat</button>
      </form>
    </div>
    
</div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script>
    $(function(){
        $('#reservationdate').datetimepicker({
        format: 'L'
    });

    });
</script>
@endsection