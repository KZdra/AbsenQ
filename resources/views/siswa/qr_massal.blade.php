<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak QR</title>
<style>
    @page {
        size: A4 landscape;
        margin: 1cm;
    }

    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        background: white;
        color: #000;
    }

    .container {
        width: 100%;
        padding: 16px;
        box-sizing: border-box;
    }

    h3 {
        text-align: center;
        margin-bottom: 24px;
        font-size: 20px;
    }

    .grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 16px;
    }

    .card {
        width: 240px;
        height: 300px;
        border: 1px solid #000;
        border-radius: 6px;
        padding: 12px;
        box-sizing: border-box;
        text-align: center;
        page-break-inside: avoid;
    }

    .card strong {
        display: block;
        font-size: 16px;
        font-weight: bold;
        border-bottom: 1px solid #000;
        margin-bottom: 10px;
        padding-bottom: 4px;
        padding-top: 2px;
    }

    .card .qr {
        margin: 40px 0;
    }

    .card p {
        margin: 0;
        font-size: 14px;
    }

    @media print {
        .no-print {
            display: none;
        }
    }

    .no-print {
        text-align: center;
        margin-top: 20px;
    }

    .no-print button {
        padding: 10px 18px;
        font-size: 14px;
        background-color: #444;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .no-print button:hover {
        background-color: #333;
    }
</style>

</head>

<body>
    <div class="container">
        <h3>Cetak QR {{ request('kelas_id') ? 'Kelas ' . $siswa->first()?->kelas->nama_kelas : 'Semua Siswa' }}</h3>
        <div class="grid">
            @foreach ($siswa as $s)
                <div class="card">
                    <div><strong style="outline: 2px solid black">{{ $s->nama }}</strong></div>
                    <div class="qr">
                        {!! QrCode::size(100)->generate($s->nis) !!}
                    </div>
                    <div>
                        <p>{{ $s->nis }}</p>
                        <p>{{ $s->kelas->nama_kelas }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="no-print" style="text-align:center; margin-top: 20px;">
        <button onclick="window.print()">Print</button>
    </div>
</body>

</html>
