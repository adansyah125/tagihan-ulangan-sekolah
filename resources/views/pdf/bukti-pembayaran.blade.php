<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            margin-bottom: 8px;
        }

        .school-name {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
            text-decoration: underline;
        }

        hr {
            border: 1px solid #000;
            margin: 15px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        table.info td {
            border: none;
            padding: 4px 0;
        }

        table.detail th,
        table.detail td {
            border: 1px solid #000;
            padding: 8px;
        }

        table.detail th {
            background-color: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .status {
            font-weight: bold;
            text-transform: uppercase;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        .signature {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <img src="{{ public_path('dharma_agung.jpg') }}" class="logo" alt="Logo SMK">
        <div class="school-name">SMK DHARMA AGUNG</div>
        <div class="title">BUKTI PEMBAYARAN</div>
    </div>

    <hr>

    {{-- INFORMASI SISWA --}}
    <table class="info">
        <tr>
            <td width="35%">Nomor Tagihan</td>
            <td width="5%">:</td>
            <td>{{ $tagihan->kd_tagihan }}</td>
        </tr>
        <tr>
            <td>Nama Siswa</td>
            <td>:</td>
            <td>{{ $tagihan->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td>{{ $tagihan->user->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>{{ $tagihan->kelas->kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td>:</td>
            <td>{{ $tagihan->tagihan->tahun_ajaran }}</td>
        </tr>
    </table>

    {{-- DETAIL PEMBAYARAN --}}
    <table class="detail">
        <thead>
            <tr>
                <th>Jenis Pembayaran</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $tagihan->jenis_tagihan }}</td>
                <td class="text-right">
                    Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="status">Status</td>
                <td class="text-right status">{{ $tagihan->status }}</td>
            </tr>
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        <div>Dicetak pada:</div>
        <div>{{ now()->format('d M Y') }}</div>

        <div class="signature">
            Bendahara
        </div>
    </div>

</body>

</html>
