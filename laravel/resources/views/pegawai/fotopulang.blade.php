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
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header">
                        Kirimkan swafoto anda (foto selfie)
                    </div>
                    <div class="card-body">
                        <img id="foto" src="{{ asset('img/blank-user.png') }}" style="width:82vw;" class="mb-3">

                        <form action="{{ route('kirimfotopulang') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="file" id="foto_pulang" name="foto_pulang" accept="image/*" capture="user" required />

                            <div class="card-footer text-right mt-4">

                                <button type="submit" class="btn btn-success"><i class="fas fa-envelope"></i>
                                    Kirim</button>
                        </form>
                    </div>
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


    <script>
        @if ($errors->any())
            $('#ModalError').modal('show');
        @endif

        foto_pulang.onchange = evt => {
            const [file] = foto_pulang.files
            if (file) {
                foto.src = URL.createObjectURL(file)
            }
        }
    </script>
</body>

</html>
