@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Kelas') }}</h1>
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
                                <button class="btn btn-success mb-2" id="inputUserBtn">Tambah Kelas</button>
                            </div>
                            <table class="table table-striped  table-hover" id="userTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->nama_kelas }}</td>
                                            <td>
                                                <button class="btn btn-primary editUserBtn" data-id="{{ $user->id }}"
                                                    data-nama="{{ $user->nama_kelas }}">
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
                            <h5 class="modal-title" id="userModalLabel">Tambah Kelas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="userForm">
                            <div class="modal-body">
                                <input type="hidden" id="kelas_id">
                                <div class="form-group">
                                    <label for="nama_kelas">Nama</label>
                                    <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required>
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
                $('#kelas_id').val('');
                $('#nama_kelas').val('');
                $('#userModalLabel').text('Tambah Kelas');
                $('#userModal').modal('show');
            });
            $('#userForm').submit(function(e) {
                e.preventDefault();
                let id = $('#kelas_id').val();
                let url = id ? `/kelas/${id}` : "{{ route('kelas.store') }}";
                let method = id ? "PUT" : "POST";

                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        nama_kelas: $('#nama_kelas').val(),
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

                $('#kelas_id').val(id);
                $('#nama_kelas').val(nama);
                $('#userModalLabel').text('Edit Kelas');
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
                            url: `/kelas/${id}`,
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
