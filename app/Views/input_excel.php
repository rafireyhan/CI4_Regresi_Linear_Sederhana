<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Pemrograman Simulasi</h1>
        <h1 class="h3 mb-0 text-gray-800">Kelas B</h1>
    </div>

    <?php if(session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan');?>
    </div>
    <?php endif?>

    <div class="card mb-2">
        <h5 class="card-header">Input Nilai Data Panen</h5>
        <div class="card-body">
            <?= csrf_field(); ?>
            <form action="/Home/input_excel" method="POST">
                <div class="form-group">
                    <label for="exampleFormControlFile1">Masukan file excel disini...</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="data_padi" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload Excel</button>
                <button type="button" class="btn btn-primary" onclick="document.location.href='/exp/data_padi.xlsx'">Download Excel</button>
            </form>
        </div>
    </div>

    <div class="card mb-2">
        <h5 class="card-header">Output Tabel</h5>
        <div class="card-body">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Data Panen Ke-</th>
                        <th scope="col">Nilai X</th>
                        <th scope="col">Nilai Y</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1?>
                    <?php foreach($input as $i) : ?>
                    <tr>
                        <th scope="row"><?= $no++?></th>
                        <td><?= $i['nilaiX']?></td>
                        <td><?= $i['nilaiY']?></td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>
            <a class="btn btn-primary btn-icon-split" href="/Home/input_hasil">
                <span class="text">Hitung Nilai</span>
            </a>
        </div>
    </div>

</div>
<?= $this->endSection() ?>