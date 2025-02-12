@extends('layouts.pegawai')
@section('title','Izin/Cuti')

@section('konten')
<div class="container spasi-bawah">

  <div class="row">
    <div class="col-12">
      <div class="card mt-4">
        <div class="card-header text-bg-success">
          Pilih Jenis Izin dan Kirim Bukti Dukung
        </div>
        <div class="card-body">
          <img id="foto" src="{{ asset('img/doc.jpg') }}" style="width:82vw;" class="mb-3">

          <form action="{{ route('kirimizin') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <label for="jam_masuk">Jenis Izin</label>
              <select name="jam_masuk" id="jam_masuk" class="form-control" required>
                <option value="">Pilih Jenis Izin</option>
                <option value="DL">Dinas Luar</option>
                <option value="I">Izin</option>
                <option value="S">Sakit</option>
              </select>
            </div>
            <div class="form-group">
              <label for="foto_izin">Bukti Dukung</label>
              <input type="file" id="foto_izin" class="form-control-file" name="foto_izin" accept="image/*"  />
            </div>



        </div>
        <div class="card-footer text-end mt-4">

          <button type="submit" class="btn btn-green btn-success"><i class="fas fa-envelope"></i> Kirim</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade " id="ModalError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content bg-danger">
      <div class="modal-header">
        <h5 class="modal-title text-light">Terdapat kesalahan dari foto yang dikirimkan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-light">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

      </div>
    </div>
  </div>
</div>
@endsection

@section('script')

<script>
  @if($errors->any())
  $('#ModalError').modal('show');
  @endif

  foto_izin.onchange=evt=> {
    const [file] = foto_izin.files
    if (file) {
      foto.src = URL.createObjectURL(file)
    }
  }
</script>
@endsection