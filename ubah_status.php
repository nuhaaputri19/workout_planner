<?php 
    include 'koneksi.php';

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $id_user = $_SESSION['id_user'];

    $id_jadwal_latihan = $_GET['id_jadwal_latihan'];

    $jadwal_latihan = mysqli_query($koneksi, "SELECT * FROM jadwal_latihan INNER JOIN user ON jadwal_latihan.id_user = user.id_user WHERE id_jadwal_latihan = '$id_jadwal_latihan'");
    $data_jadwal_latihan = mysqli_fetch_assoc($jadwal_latihan);

    if (isset($_SESSION['id_user'])) {
        $id_user = $_SESSION['id_user'];
        // cek apakah data latihan termasuk latihan ku
        if ($data_jadwal_latihan['id_user'] == $id_user) {
            $ubah_status = mysqli_query($koneksi, "UPDATE jadwal_latihan SET status = 'SUDAH' WHERE id_jadwal_latihan = '$id_jadwal_latihan' && id_user = '$id_user'");

            if ($ubah_status) {
                echo "
                    <script>
                        alert('Jadwal latihan selesai!')
                        window.location.href='index.php'
                    </script>
                ";
                exit;
            } else {
                echo "
                    <script>
                        alert('Jadwal latihan gagal diubah statusnya!')
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