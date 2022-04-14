<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Pemrograman Simulasi</h1>
        <h1 class="h3 mb-0 text-gray-800">Kelas B</h1>
    </div>
    <div class="card mb-2">
        <h5 class="card-header">Regresi Linear Sederhana</h5>
        <div class="card-body">
            <h5 class="card-title font-weight-bold">Pengertian</h5>
            <p class="card-text">Regresi Linear Sederhana adalah Metode Statistik yang berfungsi untuk menguji sejauh mana hubungan sebab akibat antara Variabel Faktor Penyebab (X) terhadap Variabel Akibatnya.</p>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Studi Kasus</h5>
        <div class="card-body">
            <h5 class="card-title font-weight-bold">Penjelasan</h5>
            <p class="card-text">Studi Kasus yang akan digunakan dalam simulasi Regresi Linear Sederhana ini adalah pengaruh curah hujan terhadap produksi atau panen padi.</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>