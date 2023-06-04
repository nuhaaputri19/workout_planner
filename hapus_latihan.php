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
		if ($data_latihan['id_user'] == $id_user) {
			$hapus_latihan = mysqli_query($koneksi, "DELETE FROM latihan WHERE id_latihan = '$id_latihan' && id_user = '$id_user'");

			if ($hapus_latihan) {
				echo "
					<script>
						alert('latihan berhasil dihapus!')
						window.location.href='latihan.php'
					</script>
				";
				exit;
			} else {
				echo "
					<script>
						alert('latihan gagal dihapus!')
						window.history.back()
					</script>
				";
				exit;
			}
		}
	} else {
		echo "
			<script>
				alert('latihan gagal dihapus!')
				window.history.back()
			</script>
		";
		exit;
	}

?>