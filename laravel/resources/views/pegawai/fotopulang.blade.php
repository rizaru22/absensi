<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fotomasuk.css') }}">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('img/icon3.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}" />
    <style>

    </style>
    <title>Absensi Pegawai</title>
</head>

<body>
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


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <script src="{{asset('dist/js/webcam.js')}}"></script>
    <script language="JavaScript">
        Webcam.set({
            width: 460,
            height: 590,
            image_format: 'jpeg',
            jpeg_quality: 100,
            flip_horiz: true
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


</body>

</html>