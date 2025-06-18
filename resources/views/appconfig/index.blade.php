@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Setting Aplikasi') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body ">
                            <form id="formConfig" enctype="multipart/form-data">
                                <div class="form-row">
                                    @csrf
                                    <div class="form-group col-md-6">
                                        <label for="app_name">Nama Aplikasi</label>
                                        <input type="text" class="form-control" id="app_name" name="app_name"
                                            value="{{ old('app_name', $setting->app_name) }}" placeholder="ABSENSI SMK Xx">
                                        <div class="form-group mt-2">
                                            <label for="logo_path">Logo Aplikasi</label>
                                            <input type="file" class="form-control" name="logo_path" id="img-input"
                                                accept="image/*">
                                        </div>
                                        <div class="form-group">
                                            <label for="mode_scan">Mode Absensi</label>
                                            <select name="mode_scan" id="mode_scan" class="form-control">
                                                <option value="">Pilih Mode Absensi</option>
                                                <option value="qr"
                                                    {{ old('mode_scan', $setting->mode_scan) == 'qr' ? 'selected' : '' }}>
                                                    Menggunakan Kamera Webcam (QR)</option>
                                                <option value="scanner"
                                                    {{ old('mode_scan', $setting->mode_scan) == 'scanner' ? 'selected' : '' }}>
                                                    Menggunakan Scanner USB (QR Suport)</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Logo Aplikasi</label>
                                        <img src="" alt="image Not Found" id="preview" class="img-thumbnail">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
@section('scripts')
    <script type="module">
        $(document).ready(function() {
            // Set fallback logo
            @if ($setting->logo_path)
                let logoUrl = "{{ asset('storage/' . $setting->logo_path) }}";
                $('#preview').attr('src', logoUrl);
            @else
                $('#preview').attr('src', "{{ asset('images/imgfallback.svg') }}");
            @endif
            // Preview image
            $('#img-input').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#preview').attr('src', '{{ asset('images/imgfallback.svg') }}');
                }
            });

            // Handle form submission
            $('#formConfig').on('submit', function(e) {
                e.preventDefault(); // prevent default form submission

                // You can gather form data here (for AJAX)
                const formData = new FormData(this);

                // Simulate saving data via AJAX
                $.ajax({
                    url: '{{ route('appconfig.store') }}', // replace with your real route
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Show Swal alert when done
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Pengaturan berhasil disimpan!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(() => {

                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat menyimpan!',
                        });
                    }
                });
            });
        });
    </script>
@endsection
