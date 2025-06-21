@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Siswa') }}</h1>
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

                    {{-- <div class="alert alert-info">
                        Sample table page
                    </div> --}}

                    <div class="card">
                        <div class="card-body ">
                            <div class="card-text">
                                <button class="btn btn-success mb-2" id="inputUserBtn"><i
                                        class="fas fa-user-plus"></i>&nbsp;Tambah Siswa</button>
                                <button class="btn btn-info mb-2" id="UploadUserBtn"><i
                                        class="fas fa-file-import"></i>&nbsp;Import Siswa</button>
                                <a class="btn btn-info mb-2" id="PrintAllQrBtn" target="_blank" href="{{ route('siswa.qr.massal', ['kelas_id' => request('kelas_id')]) }}"><i class="fas fa-print"></i>&nbsp;Cetak
                                    QR Massal</a>
                                <form action="{{ route('siswa.index') }}" method="GET" class="form-inline mb-2">
                                    <label for="filterKelas" class="mr-2">Filter Kelas:</label>
                                    <select name="kelas_id" id="filterKelas" class="form-control mr-2">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelasList as $k)
                                            <option value="{{ $k->id }}"
                                                {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary ml-2">Reset</a>
                                </form>

                            </div>
                            <table class="table table-striped  table-hover" id="userTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nis</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswa as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->nis }}</td>
                                            <td>{{ $user->nama }}</td>
                                            <td>{{ $user->kelas->nama_kelas }}</td>
                                            <td>
                                                {{-- <button class="btn btn-info cetakUserBtn" data-id="{{ $user->id }}">
                                                    Cetak QR</button> --}}
                                                <button class="btn btn-primary editUserBtn" data-id="{{ $user->id }}"
                                                    data-nama="{{ $user->nama }}" data-nis="{{ $user->nis }}"
                                                    data-kelas="{{ $user->kelas->id }}">
                                                    Edit</button>
                                                <button class="btn btn-danger delUserBtn"
                                                    data-id="{{ $user->id }}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        {{-- <div class="card-footer clearfix">
                            {{ $users->links() }}
                        </div> --}}
                    </div>

                </div>
            </div>

            <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="userModalLabel">Tambah Siswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="userForm">
                            <div class="modal-body">
                                <input type="hidden" id="siswa_id">
                                <div class="form-group">
                                    <label for="nis">Nis</label>
                                    <input type="text" class="form-control" id="nis" name="nis"
                                        inputmode="numeric" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>

                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control">
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($kelasList as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Tambah Siswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="uploadForm">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <p>Untuk Download Template Silahkan Klik Dibawah Ini.</p>
                                    <a href="{{ route('siswa.template') }}" class="btn btn-success ">Download
                                        Template</a>

                                </div>
                                <div class="form-group">
                                    <label for="file_upload">Upload File Excel Data Siswa</label>
                                    <input id="file_upload" type="file" name="file_upload"
                                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
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
            let table = $('#userTable').dataTable({
                responsive: true
            });
            $('#inputUserBtn').click(function() {
                $('#siswa_id').val('');
                $('#nama').val('');
                $('#nis').val('');
                $('#kelas_id').val('');
                $('#userModalLabel').text('Tambah Siswa');
                $('#userModal').modal('show');
            });
            $('#UploadUserBtn').click(function() {
                $('#file').val('');
                $('#uploadModal').modal('show');
            });
            //
            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                // Tampilkan loading swal
                Swal.fire({
                    title: 'Mengunggah...',
                    text: 'Mohon tunggu sementara file diunggah.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('siswa.import') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '✅ Berhasil mengimpor siswa.'
                        });
                        $('#uploadModal').modal('hide');
                        setTimeout(() => {
                            location.reload()
                        }, 1500);
                    },
                    error: function(xhr) {
                        let message = '❌ Gagal mengimpor.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message += `\n${xhr.responseJSON.message}`;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: message
                        });
                    }
                });
            });

            $('#userForm').submit(function(e) {
                e.preventDefault();
                let id = $('#siswa_id').val();
                let url = id ? `/siswa/${id}` : "{{ route('siswa.store') }}";
                let method = id ? "PUT" : "POST";

                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        nis: $('#nis').val(),
                        nama: $('#nama').val(),
                        kelas_id: $('#kelas_id').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function() {
                            $('#userModal').modal('hide');
                            location.reload(); // Refresh halaman setelah berhasil
                        }, 2000);

                    },
                    error: function(res) {
                        Swal.fire('Error', 'Terjadi kesalahan, coba lagi!', 'error');
                    }
                });
            });
            // Tampilkan Modal Edit Kelas
            $(document).on('click', '.editUserBtn', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let kelas_id = $(this).data('kelas');
                let nis = $(this).data('nis');

                $('#siswa_id').val(id);
                $('#nama').val(nama);
                $('#nis').val(nis);
                $('#kelas_id').val(kelas_id);
                $('#userModalLabel').text('Edit Siswa');
                $('#userModal').modal('show');
            });

            //
            // Delete Action
            $(document).on('click', '.delUserBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/siswa/${id}`,
                            method: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                setTimeout(function() {
                                    location
                                        .reload(); // Refresh halaman setelah berhasil
                                }, 2000);
                            },
                            error: function(r) {
                                console.log(r)
                                Swal.fire("Gagal!", "Terjadi kesalahan, coba lagi!",
                                    "error");
                            }
                        });
                    }
                });
            })
        })
    </script>
@endsection
