@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Report Absen') }}</h1>
                    <button class="btn btn-success  my-2" id="exportBtn" style="display: none;"><i
                            class="fas fa-file-excel"></i>&nbsp;Export Excel</button>
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
                    <div class="card" id="pickClassCard">
                        <h5 class="card-header bg-info">Pilih Kelas</h5>
                        <div class="card-body">
                            <form id="kelasForm">
                                <label for="class_id">Kelas :</label>
                                <select name="class_id" id="class_id" class="form-control">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($classList as $id => $k)
                                        <option value="{{ $id }}">{{ $k }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-success mt-2">Konfirmasi</button>
                            </form>
                        </div>
                    </div>
                    <div class="card" id="pickReportCard" style="display: none;">
                        <h5 class="card-header bg-info">Pilih Rekap Absensi</h5>
                        <div class="card-body">
                            <form id="reportForm">
                                <label for="tipe">Tipe Rekap :</label>
                                <select name="tipe" id="tipe" class="form-control">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($tipeList as $tp)
                                        <option value="{{ $tp }}">{{ ucwords(str_replace('_', ' ', $tp)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-success mt-2">Konfirmasi</button>
                            </form>
                        </div>
                    </div>
                    <div class="card" id="pickDateCard" style="display: none;">
                        <h5 class="card-header bg-info">Atur Rentang Tanggal:</h5>
                        <div class="card-body">
                            <form id="dateForm">
                                <label for="start_date"> Dari Tanggal:</label>
                                <input type="date" name="start_date" class="form-control" id="start_date"
                                    max="{{ \Carbon\Carbon::today()->toDateString() }}">
                                <label for="end_date"> Sampai Tanggal:</label>
                                <input type="date" name="end_date" class="form-control" id="end_date"
                                    max="{{ \Carbon\Carbon::today()->toDateString() }}">
                                <button type="submit" class="btn btn-success mt-2">Konfirmasi</button>
                            </form>
                        </div>
                    </div>
                    {{-- Result --}}
                    <div class="card" id="resultCard" style="display: none;">
                        <h5 class="card-header bg-info">Hasil Report</h5>
                        <div class="card-body">
                            <div class="card-text">
                                <h5>Kelas: <span id="ClassSel"></span></h5>
                                <h5>Tipe Rekap: <span id="RekapSel"></span></h5>
                                <h5 id="DateCond" style="display: none">Rentang Tanggal: <span id="DateSel"></span></h5>
                            </div>
                            <div class="">
                                <table class="table table-striped table-bordered table-sm" id="ResultTable">
                                    <thead class="text-center thead-dark">
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Siswa</th>
                                            <th rowspan="2">Kelas</th>
                                            <th colspan="4">Jumlah Absensi</th>
                                        </tr>
                                        <tr>
                                            <th>H</th>
                                            <th>S</th>
                                            <th>I</th>
                                            <th>A</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
                                            <td>1</td>
                                            <td>PLS</td>
                                            <td>XII RPL</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>0</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
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
        function fetchData(params) {
            $.ajax({
                url: '{{ route('reportabsen.getData') }}', // Ganti dengan endpoint kamu
                method: 'GET',
                data: params,
                success: function(data) {
                    let rows = '';
                    data.data.forEach((item, i) => {
                        rows += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${item.nama}</td>
                        <td>${item.kelas}</td>
                        <td>${item.hadir}</td>
                        <td>${item.sakit}</td>
                        <td>${item.izin}</td>
                        <td>${item.alpa}</td>
                    </tr>
                `;
                    });
                    $('#ResultTable tbody').html(rows);
                },
                error: function(xhr, status, error) {
                    console.error('Gagal ambil data:', error);
                }
            });
            //
            $("#resultCard").show(300);
            $("#exportBtn").show(300);
        }
        @if (session('error'))
            SwalHelper.showError("{{ session('error') }}")
        @endif
        $(function() {
            let class_id = '';
            let class_name = '';
            let report_type = '';
            let start_date = '';
            let end_date = '';
            $('#kelasForm').submit(function(e) {
                e.preventDefault();
                class_id = $('#class_id').val();
                class_name = $('#class_id option:selected').text();
                if (!class_id) {
                    SwalHelper.showError('Silahkan Pilih Kelas Terlebih Dahulu');
                    return;
                }
                $("#pickClassCard").hide(300);
                $("#pickReportCard").show(300);
            })
            $('#dateForm').submit(function(e) {
                e.preventDefault();
                start_date = $('#start_date').val();
                end_date = $('#end_date').val();
                if (!start_date || !end_date) {
                    SwalHelper.showError('Silahkan Atur Rentang Tanggal Terlebih Dahulu');
                    return;
                }
                $("#DateCond").show(300);
                $("#DateSel").text(`${start_date} - ${end_date}`);
                fetchData({
                    tipe: report_type,
                    start_date: start_date,
                    end_date: end_date
                });

            })
            $("#exportBtn").on('click', function() {
                let exportBaseUrl = "{{ route('reportabsen.export') }}"
                let excelUrl =
                    `${exportBaseUrl}?tipe=${encodeURIComponent(report_type)}&start_date=${encodeURIComponent(start_date)}&end_date=${encodeURIComponent(end_date)}`;
                $.ajax({
                    url: excelUrl,
                    method: 'GET',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data, _, xhr) {
                        var contentDisposition = xhr.getResponseHeader('Content-Disposition');
                        var fileName = `Rekap_Absen_${class_name}.xlsx`; // Default name

                        if (contentDisposition) {
                            var matches = /filename="([^"]*)"/.exec(contentDisposition);
                            if (matches != null && matches[1]) {
                                fileName = matches[1]; // Extract filename from the header
                            }
                        }

                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(data);
                        a.href = url;
                        a.download = fileName;
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                        SwalHelper.showSuccess('Berhasil DiExport!')
                    }
                });
            })
            $('#reportForm').submit(function(e) {
                e.preventDefault();
                report_type = $('#tipe').val();
                if (!report_type) {
                    SwalHelper.showError('Silahkan Pilih Tipe Rekap Terlebih Dahulu');
                    return;
                }
                $("#pickReportCard").hide(300);
                $("#ClassSel").text(class_name);
                $("#RekapSel").text(report_type.replace('_', ' ').toUpperCase());
                //
                if (report_type === 'per_semester') {
                    fetchData({
                        tipe: report_type
                    });
                } else {
                    $("#pickDateCard").show(300);

                }
            })
        })
    </script>
@endsection
