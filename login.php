<?php 
    include 'koneksi.php';

    if (isset($_SESSION['id_user'])) {
        header("Location: index.php");
        exit;
    }

    if (isset($_POST['btnLogin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // cek username
        $cek_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");

        if ($data_user = mysqli_fetch_assoc($cek_username)) {
            // cek password
            if (password_verify($password, $data_user['password'])) {
                $_SESSION['id_user'] = $data_user['id_user'];
                header("Location: index.php");
                exit;
            } else {
                echo "
                    <script>
                        alert('Gagal Username atau Password salah!')
                        window.history.back()
                    </script>
                ";
                exit;
            }
        } else {
            echo "
                <script>
                    alert('Gagal Username atau Password salah!')
                    window.history.back()
                </script>
            ";
            exit;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <title>Login</title>
</head>

<body class="body">
    <div class="center">
        <img src="gambar/SittingDoodle.png" alt="gambar">
        <h1>Login</h1>
        <form method="post">
            <div class="txt_field">
                <input type="text" name="username" required>
                <span></span>
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <button type="submit" name="btnLogin">Sign In</button>
            <div class="signup_link">
            Create as Account? <a href="registrasi.php">Register</a>
        </div>
        </form>
    </div>
</body>
</html>