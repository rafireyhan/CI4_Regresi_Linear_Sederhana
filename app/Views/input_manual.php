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
            <form action="/Home/tambah_data" method="POST">
                <div class="form-group">
                    <label for="nilaiX">X</label>
                    <input class="form-control <?= ($validation->hasError('nilaiX')) ? 'is-invalid' : '';?>" id="nilaiX"
                        name="nilaiX" required>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nilaiX');?>
                    </div>
                    <small id="nilaiX" class="form-text text-muted">Keterangan : Masukan nilai rata-rata curah hujan,
                        dengan satuan
                        mm.</small>
                </div>
                <div class="form-group">
                    <label for="nilaiY">Y</label>
                    <input class="form-control <?= ($validation->hasError('nilaiY')) ? 'is-invalid' : '';?>" id="nilaiY"
                        name="nilaiY" required>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nilaiY');?>
                    </div>
                    <small id="nilaiY" class="form-text text-muted">Keterangan : Masukan nilai rata-rata produksi padi,
                        dengan satuan
                        kwintal.</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
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