<?php 
	include 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$id_latihan = $_GET['id_latihan'];

	$latihan = mysqli_query($koneksi, "SELECT * FROM latihan INNER JOIN user ON latihan.id_user = user.id_user WHERE id_latihan = '$id_latihan'");
	$data_latihan = mysqli_fetch_assoc($latihan);

	if (isset($_SESSION['id_user'])) {
		$id_user = $_SESSION['id_user'];
		// cek apakah data latihan termasuk latihan ku
		if ($data_latihan['id_user'] != $id_user) 
		{
			echo "
				<script>
					alert('latihan gagal diubah!')
					window.history.back()
				</script>
			";
			exit;
		}
	}


	if (isset($_POST['btnUbah'])) {
		$nama_latihan = $_POST['nama_latihan'];
		$durasi = $_POST['durasi'];

		$update_latihan = mysqli_query($koneksi, "UPDATE latihan SET nama_latihan = '$nama_latihan', durasi = '$durasi' WHERE id_latihan = '$id_latihan' AND id_user = '$id_user'");
 		
 		if ($update_latihan) {
            echo "
                <script>
                    alert('Latihan berhasil diubah!')
                    window.location.href='latihan.php'
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    alert('Latihan gagal diubah!')
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
    <title>Ubah Latihan - <?= $data_latihan['nama_latihan']; ?></title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
    	<h2>Ubah Latihan - <?= $data_latihan['nama_latihan']; ?></h2>
    	<form method="post" class="form">
			<div class="form-group">
				<label for="nama_latihan">Nama Latihan</label>
				<input type="text" class="form-control" id="nama_latihan" name="nama_latihan" value="<?= $data_latihan['nama_latihan']; ?>" required>
			</div>
			<div class="form-group">
				<label for="durasi">Durasi (Detik)</label>
				<input type="number" class="form-control" id="durasi" name="durasi" value="<?= $data_latihan['durasi']; ?>" required>
			</div>
			<button type="submit" name="btnUbah">Submit</button>
    	</form>
    </div>
</body>
</html>