<?php 
// mengaktifkan session php
session_start();
 
// menghubungkan dengan koneksi
error_reporting(0);
ini_set('display_errors', 0);

require 'db.php'; 
// menangkap data yang dikirim dari form
if(isset($_POST["submit"]))
{


	$NIK = $_POST['NIK'];
	$nama = $_POST['nama'];
	$no_loket = $_POST['no_loket'];

	$NIK = stripslashes($NIK);
	$nama = stripslashes($nama);
	$NIK = mysqli_real_escape_string($con,$NIK);
	$nama = mysqli_real_escape_string($con,$nama);


	// menyeleksi data admin dengan username dan password yang sesuai
	$query = mysqli_query($con, "SELECT *from petugas where NIK='$NIK' AND nama='$nama'");
	 
	// menghitung jumlah data yang ditemukan
	$cek = mysqli_num_rows($query);
	 
	if($cek > 0)
	{
		$query =  "select NIK,nama,password from petugas where NIK='$NIK'";
		$sql = mysqli_query ($con, $query);
		while ($hasil = mysqli_fetch_array ($sql)) 
		{
		$NIK = $hasil['NIK'];
		$nama = stripslashes ($hasil['nama']);
		$password = stripslashes ($hasil['password']);
		}
		$_SESSION['NIK'] = $NIK;
		$_SESSION['nama'] = $nama;
		$_SESSION['password'] = $password;
		/*$_SESSION['agama'] = $agama;
		$_SESSION['alamat'] = $alamat;
		$_SESSION['jenis_kelamin'] = $jenis_kelamin;
		$_SESSION['status'] = $status;
		$_SESSION['golongan_darah'] = $golongan_darah;
		$_SESSION['tinggi_badan'] = $tinggi_badan;*/
		$_SESSION['status_account'] = "login";
		$query_cs = mysqli_query($con, "update pelayanan_loket set status_loket = 1, NIK='$NIK' where no_loket='$no_loket'");
		header("location:dashboard.php");
	}
	
	else
	{
    echo "Gagal login. ID petugas untuk akses dashboard salah !";
	header("refresh:1.5;index.php");
	}
}
?>