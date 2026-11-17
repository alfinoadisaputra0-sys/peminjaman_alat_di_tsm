
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Alat Bengkel TSM</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #222;
            margin: 25px;
            font-size: 12px;
        }

        h2, p {
            text-align: center;
            margin: 5px 0;
        }

        .garis {
            border-top: 3px solid #222;
            margin: 15px 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 7px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #eee;
            text-align: center;
        }

        .tanggal-cetak {
            text-align: right;
            margin-top: 20px;
        }

        .tanda-tangan {
            width: 220px;
            margin-left: auto;
            margin-top: 45px;
            text-align: center;
        }

        @media print {
            body {
                margin: 10mm;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()">Cetak Laporan</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <h2>LAPORAN PEMINJAMAN ALAT</h2>
    <h2>BENGKEL TEKNIK SEPEDA MOTOR</h2>
    <p>Laporan Data Peminjaman dan Pengembalian Alat</p>

    <div class="garis"></div>

    <p style="text-align:left;">
        Periode:
        {{ request('tanggal_mulai')
            ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d-m-Y')
            : 'Semua tanggal' }}
        s/d
        {{ request('tanggal_akhir')
            ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d-m-Y')
            : 'Semua tanggal' }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Peminjam</th>
                <th>Alat</th>
                <th>Tanggal Pinjam</th>
                <th>Batas Kembali</th>
                <th>Tanggal Dikembalikan</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>

        <tbody>
            @forelse($laporans as $index => $peminjaman)
                @php
                    $pengembalian = $peminjaman->pengembalians->first();
                @endphp

                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        {{ $peminjaman->user->name ?? '-' }}
                        <br>
                        {{ $peminjaman->user->email ?? '-' }}
                    </td>

                    <td>
                        @forelse($peminjaman->detailPeminjamans as $detail)
                            {{ $detail->alat->nama_alat ?? 'Alat dihapus' }}
                            ({{ $detail->jumlah }})
                            @if(!$loop->last)
                                <br>
                            @endif
                        @empty
                            -
                        @endforelse
                    </td>

                    <td>
                        {{ $peminjaman->tanggal_pinjam
                            ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y')
                            : '-' }}
                    </td>

                    <td>
                        {{ $peminjaman->tanggal_kembali
                            ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y')
                            : '-' }}
                    </td>

                    <td>
                        {{ $pengembalian && $pengembalian->tanggal_kembali
                            ? \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d-m-Y')
                            : '-' }}
                    </td>

                    <td>{{ ucwords(str_replace('_', ' ', $peminjaman->status)) }}</td>

                    <td>
                        Rp{{ number_format((float) $peminjaman->denda, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">
                        Tidak ada data laporan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="tanggal-cetak">
        Dicetak pada: {{ now()->format('d-m-Y H:i') }}
    </p>

    <div class="tanda-tangan">
        <p>Petugas,</p>
        <br><br><br>
        <p><strong>{{ auth()->user()->name }}</strong></p>
    </div>

    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>

</body>
</html>
