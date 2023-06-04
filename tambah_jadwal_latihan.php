<?php 
	include 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: login.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];
    $latihan = mysqli_query($koneksi, "SELECT * FROM latihan WHERE id_user = '$id_user' ORDER BY nama_latihan ASC");

	if (isset($_POST['btnTambah'])) {
		$tanggal_latihan = $_POST['tanggal_latihan'];
		$id_latihan = $_POST['id_latihan'];

        if ($id_latihan == 0) {
            echo "
                <script>
                    alert('Pilih latihan terlebih dahulu!')
                    window.history.back()
                </script>
            ";
        }

        $status = 'BELUM';

		$insert_jadwal_latihan = mysqli_query($koneksi, "INSERT INTO jadwal_latihan (tanggal_latihan, status, id_latihan, id_user) VALUES ('$tanggal_latihan', '$status', '$id_latihan', '$id_user')");
 		
 		if ($insert_jadwal_latihan) {
            echo "
                <script>
                    alert('Jadwal latihan berhasil ditambahkan!')
                    window.location.href='index.php'
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    alert('Jadwal latihan gagal ditambahkan!')
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
    <title>Tambah Jadwal Latihan</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Tambah Jadwal Latihan</h2>
        <form method="post" class="form">
            <div class="form-group">
                <label for="tanggal_latihan">Tanggal Latihan</label>
                <input type="datetime-local" class="form-control" id="tanggal_latihan" name="tanggal_latihan" required value="<?= date('Y-m-d H:i') ?>">
            </div>
            <div class="form-group">
                <label for="id_latihan">Latihan</label>
                <select class="form-control" id="id_latihan" name="id_latihan" required>
                    <option value="0">--- Pilih Latihan ---</option>
                    <?php foreach ($latihan as $data): ?>
                        <option value="<?= $data['id_latihan'] ?>"><?= $data['nama_latihan']; ?> (<?= $data['durasi']; ?> detik)</option>
                    <?php endforeach ?>
                </select>
                <a href="tambah_latihan.php">Belum ada latihan? Tambah latihan di sini</a>
            </div>
            <button type="submit" name="btnTambah">Submit</button>
        </form>
    </div>
</body>
</html>