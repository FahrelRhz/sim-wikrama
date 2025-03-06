<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Peminjaman Barang</title>
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
    <h1>Laporan Peminjaman Barang</h1>
    <h2>Tanggal: {{ \Carbon\Carbon::now()->format('Y M') }}</h2>
    <p>Total Data: {{ $peminjamans->count() }}</p>

    @if ($peminjamans->isEmpty())
        <p style="color: red; text-align: center;">Data tidak ditemukan!</p>
    @endif


    <table class="table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
            <tr>
                <th>Siswa</th>
                <th>Barang</th>
                <th>Ruangan Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $peminjaman->siswa }}</td>
                    <td>
                        {{ $peminjaman->barang ? $peminjaman->barang->nama_barang . ' - ' . $peminjaman->barang->kode_barang : '-' }}
                    </td>
                    <td>{{ $peminjaman->ruangan_peminjam }}</td>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('Y M d') }}</td>
                    <td>{{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('Y M d') : '-' }}
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
