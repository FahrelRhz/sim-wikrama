<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Peminjaman Alat atau Barang</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lexend Deca', sans-serif;
            margin: 20px;
        }

        h1,
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Laporan Peminjaman Alat atau Barang</h1>
    <h2>Tanggal: {{ \Carbon\Carbon::now()->format('M Y') }}</h2>
    <p>Total Data: {{ $peminjamans->count() }}</p>

    @if ($peminjamans->isEmpty())
        <p style="color: red; text-align: center;">Data tidak ditemukan!</p>
    @endif


    <table class="table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
            <tr>
                <th>Nama Peminjam</th>
                <th>Alat atau Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Ruangan Peminjam</th>
                <th>Keperluan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $peminjaman->nama_peminjam }}</td>
                    <td>
                        {{ $peminjaman->alat_barang_id ? $peminjaman->alat_barang->jenis . ' - ' . $peminjaman->alat_barang->barang_merk : '-' }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('Y M d') }}</td>
                    <td>{{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('Y M d') : '-' }}
                    <td>{{ $peminjaman->ruangan_peminjam }}</td>
                    <td>{{ $peminjaman->keperluan }}</td>
                    </td>
                    <td>
                        @if ($peminjaman->status_pinjam === 'dipinjam')
                            <span style="color: red;">Dipinjam</span>
                        @else
                            <span style="color: green;">Kembali</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
