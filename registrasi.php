<?php 
    include 'koneksi.php';
    
    if (isset($_SESSION['id_user'])) {
        header("Location: index.php");
        exit;
    }

    if (isset($_POST['btnRegister'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $re_password = $_POST['re_password'];

        // username
        $cek_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");

        if (mysqli_num_rows($cek_username) > 0) {
            echo "
                <script>
                    alert('Username sudah digunakan!')
                    window.history.back()
                </script>
            ";
            exit;
        }

        // email
        $cek_email = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'");

        if (mysqli_num_rows($cek_email) > 0) {
            echo "
                <script>
                    alert('Email sudah digunakan!')
                    window.history.back()
                </script>
            ";
            exit;
        }

        // cek password sama atau tidak
        if ($password != $re_password) {
            echo "
                <script>
                    alert('Password harus sama dengan Ketik Re Password!')
                    window.history.back()
                </script>
            ";
            exit;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $insert_user = mysqli_query($koneksi, "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')");

        if ($insert_user) {
            echo "
                <script>
                    alert('Registrasi berhasil!')
                    window.location.href='login.php'
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    alert('Registrasi gagal!')
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
    <title>Register</title>
</head>
<body class="body">
   
    <div class="center">
        <img src="gambar/SittingDoodle.png" alt="gambar">
        <h1>Create An Account</h1>
        <form method="post">
            <div class="txt_field">
                <input type="text" name="username" required>
                <span></span>
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input type="email" name="email" required>
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <div class="txt_field">
                <input type="password" name="re_password" required>
                <span></span>
                <label>Repeat Password</label>
            </div>
            <button type="submit" name="btnRegister">Sign up</button>
            <div class="login_link"></a>
                Already have an account? <a href="login.php">Login</a>
        </form>
    </div>
    
</body>
</html>