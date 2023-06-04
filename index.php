<?php 
	include 'koneksi.php';
	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$jadwal_latihan = mysqli_query($koneksi, "SELECT * FROM jadwal_latihan INNER JOIN latihan ON jadwal_latihan.id_latihan = latihan.id_latihan WHERE jadwal_latihan.id_user = '$id_user' ORDER BY tanggal_latihan ASC");
	$jadwal_latihan_belum = mysqli_query($koneksi, "SELECT * FROM jadwal_latihan INNER JOIN latihan ON jadwal_latihan.id_latihan = latihan.id_latihan WHERE jadwal_latihan.id_user = '$id_user' AND status = 'BELUM' ORDER BY tanggal_latihan ASC");
	$jadwal_latihan_sudah = mysqli_query($koneksi, "SELECT * FROM jadwal_latihan INNER JOIN latihan ON jadwal_latihan.id_latihan = latihan.id_latihan WHERE jadwal_latihan.id_user = '$id_user' AND status = 'SUDAH' ORDER BY tanggal_latihan ASC");

	$total_durasi_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(latihan.durasi) AS total_durasi
	FROM jadwal_latihan
	INNER JOIN latihan ON jadwal_latihan.id_latihan = latihan.id_latihan
	WHERE jadwal_latihan.id_user = '$id_user'
	  AND DATE(jadwal_latihan.tanggal_latihan) = CURDATE() AND status = 'BELUM'"));

	$total_latihan_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(latihan.id_latihan) AS total_latihan
	FROM jadwal_latihan
	INNER JOIN latihan ON jadwal_latihan.id_latihan = latihan.id_latihan
	WHERE jadwal_latihan.id_user = '$id_user'
	  AND DATE(jadwal_latihan.tanggal_latihan) = CURDATE()"));

	$total_latihan_belum_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(latihan.id_latihan) AS total_latihan
	FROM jadwal_latihan
	INNER JOIN latihan ON jadwal_latihan.id_latihan = latihan.id_latihan
	WHERE jadwal_latihan.id_user = '$id_user'
	  AND DATE(jadwal_latihan.tanggal_latihan) = CURDATE() AND status = 'BELUM'"));

	$total_latihan_sudah_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(latihan.id_latihan) AS total_latihan
	FROM jadwal_latihan
	INNER JOIN latihan ON jadwal_latihan.id_latihan = latihan.id_latihan
	WHERE jadwal_latihan.id_user = '$id_user'
	  AND DATE(jadwal_latihan.tanggal_latihan) = CURDATE() AND status = 'SUDAH'"));

	if (isset($_POST['btnCari'])) {
		$cari = $_POST['cari'];

		$jadwal_latihan = mysqli_query($koneksi, "SELECT * FROM jadwal_latihan
		INNER JOIN latihan ON jadwal_latihan.id_latihan = latihan.id_latihan
		WHERE jadwal_latihan.id_user = '$id_user'
		  AND (nama_latihan LIKE '%$cari%' OR durasi LIKE '%$cari%' OR tanggal_latihan LIKE '%$cari%' OR status LIKE '%$cari%')
		ORDER BY tanggal_latihan ASC");
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <title>Jadwal Latihan</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
    	<div class="title">
    		<h2>Jadwal Latihan</h2>
	    	<a href="tambah_jadwal_latihan.php" class="button">Tambah Jadwal Latihan</a>
    	</div>
    	
    	<!-- Perhitungan -->
		<div class="row justify-content-between">
			<div class="col">
				<div class="card">
		    		<h4>Total Durasi Hari ini:<br><?= str_replace(",", ".", number_format($total_durasi_hari_ini['total_durasi'])); ?> Detik</h4>
		    	</div>
			</div>
			<div class="col">
				<div class="card">
		    		<h4>Total Latihan Hari ini:<br><?= number_format($total_latihan_hari_ini['total_latihan']); ?></h4>
		    	</div>
	    	</div>
			<div class="col">
		    	<div class="card">
		    		<h4>Belum Hari ini:<br><?= number_format($total_latihan_belum_hari_ini['total_latihan']); ?></h4>
		    	</div>
	    	</div>
			<div class="col">
		    	<div class="card">
		    		<h4>Sudah Hari ini:<br><?= number_format($total_latihan_sudah_hari_ini['total_latihan']); ?></h4>
		    	</div>
			</div>
		</div>

    	<!-- Pencarian -->
		<form method="post" class="form-cari">
			<input type="text" id="cari" name="cari" placeholder="Cari" class="form-control">
			<button type="submit" name="btnCari">Cari</button>
		</form>
		<?php if (isset($_POST['cari'])): ?>
    		<h4>Cari: <?= $_POST['cari']; ?></h4>
    		<h4>Ditemukan: <?= mysqli_num_rows($jadwal_latihan); ?></h4>
        	<a href="index.php" class="button">Reset</a>
    	<?php endif ?>
		<h3>Status: Belum</h3>
    	<div class="row">
    		<?php if (mysqli_num_rows($jadwal_latihan_belum) > 0): ?>
    			<?php foreach ($jadwal_latihan_belum as $data): ?>
		    		<div class="col">
		    			<div class="card">
				    		<h4>Status: <?= $data['status']; ?></h4>
				    		<h4>Tanggal Latihan: <?= date("d-m-Y, H:i", strtotime($data['tanggal_latihan'])); ?></h4>
				    		<h4>Latihan: <?= $data['nama_latihan']; ?></h4>
				    		<h4>Durasi: <?= str_replace(",", ".", number_format($data['durasi'])); ?> detik</h4>
				    		<?php if ($data['status'] == 'BELUM'): ?>
					    		<a href="ubah_status.php?id_jadwal_latihan=<?= $data['id_jadwal_latihan']; ?>" class="button bg-green">Sudah?</a>
				    		<?php endif ?>
				    		<a href="ubah_jadwal_latihan.php?id_jadwal_latihan=<?= $data['id_jadwal_latihan']; ?>" class="button bg-yellow">Ubah</a>
				    		<a onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal latihan <?= $data['nama_latihan']; ?>?')" href="hapus_jadwal_latihan.php?id_jadwal_latihan=<?= $data['id_jadwal_latihan']; ?>" class="button bg-red">Hapus</a>
				    	</div>
		    		</div>
		    	<?php endforeach ?>
		    <?php else: ?>
    			<div class="card">
			    	<h4>Tidak ada Latihan</h4>
			    </div>
    		<?php endif ?>
    	</div>
    	<br>
    	<hr>
    	<br>
    	<h3>Status: Sudah</h3>
    	<div class="row">
    		<?php if (mysqli_num_rows($jadwal_latihan_sudah) > 0): ?>
	    		<?php foreach ($jadwal_latihan_sudah as $data): ?>
		    		<div class="col">
		    			<div class="card">
				    		<h4>Status: <?= $data['status']; ?></h4>
				    		<h4>Tanggal Latihan: <?= date("d-m-Y, H:i", strtotime($data['tanggal_latihan'])); ?></h4>
				    		<h4>Latihan: <?= $data['nama_latihan']; ?></h4>
				    		<h4>Durasi: <?= str_replace(",", ".", number_format($data['durasi'])); ?> detik</h4>
				    		<?php if ($data['status'] == 'BELUM'): ?>
					    		<a href="ubah_status.php?id_jadwal_latihan=<?= $data['id_jadwal_latihan']; ?>" class="button bg-green">Sudah?</a>
				    		<?php endif ?>
				    		<a href="ubah_jadwal_latihan.php?id_jadwal_latihan=<?= $data['id_jadwal_latihan']; ?>" class="button bg-yellow">Ubah</a>
				    		<a onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal latihan <?= $data['nama_latihan']; ?>?')" href="hapus_jadwal_latihan.php?id_jadwal_latihan=<?= $data['id_jadwal_latihan']; ?>" class="button bg-red">Hapus</a>
				    	</div>
		    		</div>
		    	<?php endforeach ?>
		    <?php else: ?>
		    	<div class="card">
			    	<h4>Tidak ada Latihan</h4>
			    </div>
		    <?php endif ?>
    	</div>
    </div>
</body>
</html>