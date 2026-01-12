{{-- <h1>Halo, {{ $detail->user->name }}!</h1>
<p>Anda memiliki tagihan baru dengan rincian sebagai berikut:</p>
<ul>

    <li><strong>Nama Siswa:</strong> {{ $detail->user->name }}</li>
    <li><strong>Kelas:</strong> {{ $detail->kelas->kelas }}</li>
    <li><strong>Kode Tagihan:</strong> {{ $detail->kd_tagihan }}</li>
    <li><strong>Tahun Ajaran:</strong>{{ $detail->jenis_tagihan }} - {{ $detail->tagihan->tahun_ajaran }} </li>
    <li><strong>Nominal:</strong> Rp {{ number_format($detail->nominal, 0, ',', '.') }}</li>
    <li><strong>Jatuh Tempo:</strong>{{ \Carbon\Carbon::parse($detail->tgl_tagihan)->format('d M Y') }} sampai
        {{ \Carbon\Carbon::parse($detail->jatuh_tempo)->format('d F Y') }}</li>
</ul>
<p>Silakan segera lakukan pembayaran sebelum tanggal jatuh tempo. Terima kasih.</p> --}}

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body
    style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9fafb; color: #374151;">
    <div
        style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">

        <div style="background-color: #4f46e5; height: 6px;"></div>

        <div style="padding: 40px;">
            <h1 style="margin: 0 0 16px 0; font-size: 24px; font-weight: 800; color: #111827; letter-spacing: -0.025em;">
                Halo, {{ $detail->user->name }}!
            </h1>
            <p style="margin: 0 0 32px 0; font-size: 16px; line-height: 1.6; color: #6b7280;">
                Anda memiliki tagihan baru yang perlu diselesaikan. Berikut adalah rincian detail pembayarannya:
            </p>

            <div
                style="background-color: #f8fafc; border-radius: 12px; padding: 24px; margin-bottom: 32px; border: 1px solid #f1f5f9;">
                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #64748b; font-weight: 600; width: 40%;">Nama
                            Siswa</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #1e293b; font-weight: 700;">
                            {{ $detail->user->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #64748b; font-weight: 600;">Kelas</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #1e293b; font-weight: 700;">
                            {{ $detail->kelas->kelas }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #64748b; font-weight: 600;">Kode Tagihan</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #4f46e5; font-weight: 800;">
                            #{{ $detail->kd_tagihan }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #64748b; font-weight: 600;">Jenis Tagihan
                        </td>
                        <td style="padding: 8px 0; font-size: 14px; color: #1e293b; font-weight: 700;">
                            {{ $detail->jenis_tagihan }} ({{ $detail->tagihan->tahun_ajaran }})</td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 0 8px 0; font-size: 14px; color: #64748b; font-weight: 600;">Total
                            Tagihan</td>
                        <td style="padding: 20px 0 8px 0; font-size: 20px; color: #111827; font-weight: 900;">Rp
                            {{ number_format($detail->nominal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #64748b; font-weight: 600;">Jatuh Tempo</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #e11d48; font-weight: 700;">
                            {{ \Carbon\Carbon::parse($detail->jatuh_tempo)->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>

            <div style="text-align: center; margin-bottom: 32px;">
                <a href="{{ url('/dashboard') }}"
                    style="background-color: #4f46e5; color: #ffffff; padding: 14px 32px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px; display: inline-block; shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);">
                    Lihat Detail & Bayar
                </a>
            </div>

            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #6b7280; text-align: center;">
                Silakan lakukan pembayaran sebelum tanggal jatuh tempo untuk menghindari kendala administrasi. Terima
                kasih.
            </p>
        </div>

        <div style="background-color: #f9fafb; padding: 24px; text-align: center; border-top: 1px solid #e5e7eb;">
            <p
                style="margin: 0; font-size: 12px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">
                Dharma Agung Bandung &bull; Sistem Informasi Sekolah
            </p>
        </div>
    </div>
</body>

</html>
