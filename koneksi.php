<?php 
	session_start();
	date_default_timezone_set("Asia/Jakarta");

	$host = "localhost";
	$username = "root";
	$password = "";
	$database = "workout_planner";

	$koneksi = mysqli_connect($host, $username, $password, $database);

	if ($koneksi) {
		// echo "koneksi berhasil";
	}

?>