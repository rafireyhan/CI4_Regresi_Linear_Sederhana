<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Pemrograman Simulasi</h1>
        <h1 class="h3 mb-0 text-gray-800">Kelas B</h1>
    </div>
    <div class="card mb-2">
        <h5 class="card-header">Scatter Plot</h5>
        <div class="card-body">
            <div class="chart-container" style="height:40vh; width:40vw">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    <form action="/Home/hasil_final" method="POST">
        <div class="card mb-2">
            <h5 class="card-header">Model Regresi</h5>
            <div class="card-body">
                <p>Berdasarkan data yang telah diinput dan rumus diatas, maka Model Regresinya adalah, </p>
                <div class="form-group">
                    <label for="nA">Nilai A</label>
                    <input class="form-control" id="nA" name="nA" value="<?=$nilaiA;?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nB">Nilai B</label>
                    <input class="form-control" id="nB" name="nB" value="<?=$nilaiB;?>" readonly>
                </div>

            </div>
        </div>

        <div class="card mb-2">
            <h5 class="card-header">Peramalan (FORECASTING)</h5>
            <div class="card-body">
                <h3 class="font-weight-bold">Y = a + bX</h3>
                <div class="form-group">
                    <label for="nX">Nilai X</label>
                    <input class="form-control" id="nX" name="nX" required>
                    <small id="nX" class="form-text text-muted">Keterangan : Masukan nilai X untuk menampilkan
                        hasilnya.</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>

<!-- MENAMPILKAN HASIL -->
<?php if($nilaiY) : ;?>
<div class="card bg-success mb-3">
    <h5 class="card-header">Hasil</h5>
    <div class="card-body">
        <p class="font-weight-bold">Maka Nilai Y = <?=$nilaiY?> </p>
        <p class="font-weight-bold">Nilai Korelasi Pearson = <?=$nilaiR?> </p>
        <small>Keterangan : Nilai korelasi tersebut adalah 
            <?php if($nilaiR < 0) : ?>negatif<?php else :?>positif<?php endif?> 
                yang mengartikan bahwa perbandingannya adalah 
            <?php if($nilaiR < 0) : ?>terbalik.<?php else :?>searah. <?php endif?> </small>
        <p class="font-weight-bold mt-3">Nilai Koefisien Determinasi = <?=$nilaiKD?> </p>
        <small>Keterangan : Besar kontribusi variabel rata-rata curah hujan terhadap rata-rata
            produksi padi adalah <?=round($nilaiKD,2)?>% dan sisanya yaitu sebesar <?=100-round($nilaiKD,2)?>% dipengaruhi oleh
        variabel selain curah hujan. </small>
    </div>
</div>
<?php endif;?>
<!-- END OF HASIL-->
</div>

<script>
  const data = {
  datasets: [{
    label: 'Dataset Panen Padi',
    data: [
    <?php foreach ($input as $i) : ?>
    {
      x: <?=$i['nilaiX'];?>,
      y: <?=$i['nilaiY'];?>
    },
    <?php endforeach ?>
    ],
    backgroundColor: 'rgb(0, 0, 255)'
  }],
};

  const config = {
  type: 'scatter',
  data: data,
  options: {
    layout: {
        padding : 20
    },
    scales: {
      x: {
        type: 'linear',
        position: 'bottom'
      }
    }
  }
};
</script>

<script>
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>

<?= $this->endSection() ?>