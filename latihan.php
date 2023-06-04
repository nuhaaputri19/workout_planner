<?php 
	include 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$latihan = mysqli_query($koneksi, "SELECT * FROM latihan WHERE id_user = '$id_user' ORDER BY nama_latihan ASC");
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <title>Latihan</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
    	<div class="title">
	    	<h2>Latihan</h2>
	    	<a href="tambah_latihan.php" class="button">Tambah Latihan</a>
	    </div>
	    <div class="table-responsive">
	    	<table class="table">
	    		<tr>
	    			<th>No.</th>
	    			<th>Nama Latihan</th>
	    			<th>Durasi (detik)</th>
	    			<th>Aksi</th>
	    		</tr>
	    		<?php $i = 1; ?>
	    		<?php foreach ($latihan as $data): ?>
	    			<tr>
	    				<td><?= $i++; ?>.</td>
	    				<td><?= $data['nama_latihan']; ?></td>
	    				<td><?= str_replace(",", ".", number_format($data['durasi'])); ?></td>
	    				<td>
	    					<a href="ubah_latihan.php?id_latihan=<?= $data['id_latihan']; ?>" class="button bg-yellow">Ubah</a>
	    					<a onclick="return confirm('Apakah Anda yakin ingin menghapus latihan <?= $data['nama_latihan']; ?>?')" href="hapus_latihan.php?id_latihan=<?= $data['id_latihan']; ?>" class="button bg-red">Hapus</a>
	    				</td>
	    			</tr>
	    		<?php endforeach ?>
	    	</table>
    	</div>
    </div>
</body>
</html>