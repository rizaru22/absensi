@extends('layouts.pegawai')
@section('title','Absen Pulang')

@section('konten')
<div class="container">
<div class="row">
    <div class="col-12 justify-content-center">
        <div class="peringatan text-center alert alert-success mt-2">
            <h5>Foto harus menampilkan wajah dan latar belakang sekolah</h5>
        </div>

        <form action="{{ route('kirimfotopulang') }}" method="post" name="kirim_foto" id="kirim_foto" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="foto_pulang" id="foto_pulang" class="image-tag" required>
            <div class="form-group">
            </div>
        </form>
        <div class="text-center mx-auto">
            <div class="webcam-capture-body text-center mt-2 mx-auto">
                <div id="my_camera" class="webcam-capture"></div>
            </div>
        </div>
        <!-- <div id="results" class="webcam-capture" style="width: 590px; height:460px">Foto Anda</div> -->
        <div class="text-center mx-auto">

            <button type="button" class="btn btn-success btn-lg rounded-circle shadow mb-3 p-3 rouded pt-3 pb-3 border-dark rounded-lg" onclick="ambil_foto()"><i class="fas fa-camera fa-2x"></i></button>
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
<script src="{{asset('dist/js/webcam.js')}}"></script>
<script language="JavaScript">
    var cameras = new Array(); //create empty array to later insert available devices
navigator.mediaDevices
  .enumerateDevices() // get the available devices found in the machine
  .then(function (devices) {
    devices.forEach(function (device) {
      var i = 0;
      if (device.kind === "videoinput") {
        //filter video devices only
        cameras[i] = device.deviceId; // save the camera id's in the camera array
        i++;
      }
    });
  });

        Webcam.set({
            width: 460,
            height: 590,
            image_format: 'jpeg',
            jpeg_quality: 100,
            flip_horiz: true,
            fps:30,
            sourceId:cameras[0]
        });

        Webcam.attach('.webcam-capture');

        function ambil_foto() {
            var shutter = new Audio();
            shutter.autoplay = false;
            shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';

            Webcam.snap(function(data_uri) {
                shutter.play();
                $(".image-tag").val(data_uri);
                document.kirim_foto.submit();
            });
        }

        @if($errors->any())
        $('#ModalError').modal('show');
        @endif
    </script>
@endsection