<?php 
	include 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	if (isset($_POST['btnTambah'])) {
		$nama_latihan = $_POST['nama_latihan'];
		$durasi = $_POST['durasi'];

		$insert_latihan = mysqli_query($koneksi, "INSERT INTO latihan (nama_latihan, durasi, id_user) VALUES ('$nama_latihan', '$durasi', '$id_user')");
 		
 		if ($insert_latihan) {
            echo "
                <script>
                    alert('Latihan berhasil ditambahkan!')
                    window.location.href='latihan.php'
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    alert('Latihan gagal ditambahkan!')
                    window.history.back()
                </script>
            ";
        }
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <title>Tambah Latihan</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
    	<h2>Tambah Latihan</h2>
    	<form method="post" class="form">
			<div class="form-group">
				<label for="nama_latihan">Nama Latihan</label>
				<input type="text" class="form-control" id="nama_latihan" name="nama_latihan" required>
			</div>
			<div class="form-group">
				<label for="durasi">Durasi (Detik)</label>
				<input type="number" class="form-control" id="durasi" name="durasi" required>
			</div>
			<button type="submit" name="btnTambah">Submit</button>
    	</form>
    </div>
</body>
</html>