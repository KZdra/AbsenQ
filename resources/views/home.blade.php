@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Dashboard') }}</h1>
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
                        <div class="card-header">
                            <div class="d-flex flex-row justfy-content-between w-100">
                                <h4 class="flex-fill"> Data Absensi Hari Ini</h4>
                                <h4 class="" id="time"></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between w-100">
                                <div class="small-box bg-success mx-2 flex-fill">
                                    <div class="inner">
                                        <h3>{{ $siswaCount }}</h3>
                                        <p>Jumlah Siswa</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                </div>
                                <div class="small-box bg-warning mx-2 flex-fill">
                                    <div class="inner">
                                        <h3>{{ $kelasCount }}</h3>
                                        <p>Jumlah Kelas</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                </div>
                                <div class="small-box bg-info mx-2 flex-fill">
                                    <div class="inner">
                                        <h3>{{ round((float) $persentaseAbsen->persentase_kehadiran) . '%' }}</h3>
                                        <p>Persentase Kehadiran</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-school"></i>
                                    </div>
                                </div>
                            </div>
                            {{--  --}}
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-text text-center">
                                        Statistik Kehadiran
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
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
        const chart = {
            data: {
                labels: ['Hadir', 'Sakit', 'Izin', 'Alpa'],
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: @json($absenData),
                    backgroundColor: [
                        'rgb(75, 192, 192)', // Hadir - hijau terang
                        'rgb(255, 99, 132)', // Sakit - merah lembut
                        'rgb(255, 205, 86)', // Izin - kuning cerah
                        'rgb(211, 211, 211)' // Alpa - abu-abu
                    ],
                    hoverOffset: 4
                }]
            },
            config: {
                chartId: 'myChart',
                type: 'doughnut',
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Agar chart menyesuaikan dengan ukuran kontainer
                }
            }
        };

        function refreshTime() {
            Jamhaha('time')
        }


        $(document).ready(function() {
            refreshTime();
            setInterval(refreshTime, 1000);
            MakeChart(chart);
        });
    </script>
@endsection
