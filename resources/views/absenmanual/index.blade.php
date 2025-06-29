@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Absensi Manual') }}</h1>
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
                                        <th>Jam Absen</th>
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
                                                @if (isset($absensiHariIni[$user->id]))
                                                {{ \Carbon\Carbon:: parse($absensiHariIni[$user->id]->waktu_absen)->translatedFormat('d F Y H:i') ?? '-' }}
                                                @else
                                                Belum Absen Hari Ini
                                                @endif
                                            </td>
                                            <td>
                                                @if (!isset($absensiHariIni[$user->id]))
                                                    <button class="btn btn-primary editUserBtn" data-id=""
                                                        data-siswa_id="{{ $user->id }}" data-kehadiran="">
                                                        Absen
                                                    </button>
                                                @else
                                                    <span class="badge badge-success">
                                                        {{ ucfirst($absensiHariIni[$user->id]->status) }}
                                                    </span>
                                                @endif
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
                            <h5 class="modal-title" id="userModalLabel">Pilih Kehadiran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="userForm">
                            <div class="modal-body">
                                <input type="hidden" id="absen_id">
                                <input type="hidden" id="siswa_id">
                                <div class="form-group">
                                    <label for="kehadiran">Kehadiran</label>
                                    <select name="kehadiran" id="kehadiran" class="form-control">
                                        <option value="">Pilih Kehadiran</option>
                                        @foreach ($statusList as $k)
                                            <option value="{{ $k }}">{{ ucwords($k) }}</option>
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

            $('#userForm').submit(function(e) {
                e.preventDefault();
                let id = $('#absen_id').val();
                let url = id ? `/absenmanual/${id}` : "{{ route('absenmanual.store') }}";
                let method = id ? "PUT" : "POST";

                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        kehadiran: $('#kehadiran').val(),
                        siswa_id: $('#siswa_id').val(),
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
                let siswa_id = $(this).data('siswa_id');
                let kehadiran = $(this).data('kehadiran');


                $('#absen_id').val(id);
                $('#siswa_id').val(siswa_id);
                $('#kehadiran').val(kehadiran);
                $('#userModalLabel').text('Absensi Manual');
                $('#userModal').modal('show');
            });
        })
    </script>
@endsection
