@extends('components.app')

<style>
    @media (min-width: 751px) {
        .table-container {
            position: relative;
            left: 150px;
            width: 90%;
        }
    }

    @media (max-width: 750px) {
        .table-container {
            left: 0;
            width: 100%;
        }

        /* Bungkus tabel untuk memungkinkan scroll ke samping di mobile */
        .table-responsive {
            width: 100%;
            overflow-x: auto; /* Tabel bisa di-scroll ke samping */
        }

        .table {
            width: 100%;
            min-width: 600px; /* Pastikan tabel tetap terlihat penuh dan bisa di-scroll */
        }
    }
</style>

<div class="container">
    <div class="d-flex mb-4 mt-5">
        <div class="table-container">
            <h4 class="fw-bold mb-4">DAFTAR BARANG</h4>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="search" aria-label="search"
                    aria-describedby="basic-addon1">
                <button type="search" class="btn btn-info">Search</button>
            </div>

            <button class="btn btn-primary">+ Tambah Barang</button>

            <!-- Tambahkan div .table-responsive di sekitar tabel -->
            <div class="table-responsive">
                <table class="table mt-4">
                    <thead class="table-primary">
                        <tr>
                            <th class="col">No</th>
                            <th class="col">Jurusan</th>
                            <th class="col">Nama Barang</th>
                            <th class="col">Merk</th>
                            <th class="col">Kategori</th>
                            <th class="col">Stok</th>
                            <th class="col">Spesifikasi</th>
                            <th class="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>PPLG</td>
                            <td>Laptop</td>
                            <td>Lenovo</td>
                            <td>Elektronik</td>
                            <td>8</td>
                            <td>Lenovo i7, Ram 8GB</td>
                            <td><i class="bi bi-three-dots-vertical"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </div>
    </div>
</div>
