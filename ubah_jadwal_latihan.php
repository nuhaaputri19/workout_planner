<?php 
	include 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$id_jadwal_latihan = $_GET['id_jadwal_latihan'];

	$jadwal_latihan = mysqli_query($koneksi, "SELECT * FROM jadwal_latihan INNER JOIN user ON jadwal_latihan.id_user = user.id_user INNER JOIN latihan ON latihan.id_latihan = jadwal_latihan.id_latihan WHERE id_jadwal_latihan = '$id_jadwal_latihan'");
	$data_jadwal_latihan = mysqli_fetch_assoc($jadwal_latihan);

    $latihan = mysqli_query($koneksi, "SELECT * FROM latihan WHERE id_user = '$id_user' ORDER BY nama_latihan ASC");

	if (isset($_POST['btnUbah'])) {
		$tanggal_latihan = $_POST['tanggal_latihan'];
		$status = $_POST['status'];
		$id_latihan = $_POST['id_latihan'];

        if ($id_latihan == 0) {
            echo "
                <script>
                    alert('Pilih latihan terlebih dahulu!')
                    window.history.back()
                </script>
            ";
        }

		$update_jadwal_latihan = mysqli_query($koneksi, "UPDATE jadwal_latihan SET tanggal_latihan = '$tanggal_latihan', status = '$status', id_latihan = '$id_latihan' WHERE id_jadwal_latihan = '$id_jadwal_latihan' AND id_user = '$id_user'");
 		
 		if ($update_jadwal_latihan) {
            echo "
                <script>
                    alert('Jadwal latihan berhasil diubah!')
                    window.location.href='index.php'
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    alert('Jadwal latihan gagal diubah!')
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
    <title>Ubah Jadwal Latihan - <?= $data_jadwal_latihan['nama_latihan']; ?></title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Ubah Jadwal Latihan - <?= $data_jadwal_latihan['nama_latihan']; ?></h2>
        <form method="post" class="form">
            <div class="form-group">
                <label for="tanggal_latihan">Tanggal Latihan</label>
                <input type="datetime-local" class="form-control" id="tanggal_latihan" name="tanggal_latihan" required value="<?= date('Y-m-d H:i', strtotime($data_jadwal_latihan['tanggal_latihan'])); ?>">
            </div>
            <div class="form-group">
                <label for="id_latihan">Latihan</label>
                <select class="form-control" id="id_latihan" name="id_latihan" required>
                    <option value="<?= $data_jadwal_latihan['id_latihan'] ?>"><?= $data_jadwal_latihan['nama_latihan']; ?> (<?= $data_jadwal_latihan['durasi']; ?> detik)</option>
                    <?php foreach ($latihan as $data): ?>
                    	<?php if ($data_jadwal_latihan['id_latihan'] != $data['id_latihan']): ?>
	                        <option value="<?= $data['id_latihan'] ?>"><?= $data['nama_latihan']; ?> (<?= $data['durasi']; ?> detik)</option>
                    	<?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="SUDAH">SUDAH</option>
                    <option value="BELUM">BELUM</option>
                </select>
            </div>
            <button type="submit" name="btnUbah">Submit</button>
        </form>
    </div>
</body>
</html>