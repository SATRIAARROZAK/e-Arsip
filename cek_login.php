

<?php
session_start();
include "config/koneksi.php";

// 1. Amankan Password dengan MD5
$pass = md5($_POST['password']);

// 2. Amankan Inputan (Gunakan mysqli_real_escape_string untuk keamanan lebih baik)
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $pass);

// 3. Cek Username dan Password di Database
$login = mysqli_query($koneksi, "SELECT * from tbl_user 
                                 WHERE username='$username' and password ='$password' ");
$data = mysqli_fetch_array($login);

// 4. Logika Pemisahan Login
if($data)
{
    // Jika password benar, SIMPAN DATA USER KE SESSION
    $_SESSION['id_user']      = $data['id_user'];
    $_SESSION['username']     = $data['username'];
    $_SESSION['nama_lengkap'] = $data['nama_lengkap']; // Penting untuk sapaan di dashboard
    $_SESSION['level']        = $data['level'];        // KUNCI UTAMA pembeda hak akses

    // 5. Arahkan User Berdasarkan Level (Pemisahan Redirect)
    if($data['level'] == "admin")
    {
        // Jika Admin, arahkan ke index.php (karena menu admin ada disana)
        header('location:admin.php');
    }
    else if($data['level'] == "direktur")
    {
        // Jika Direktur, arahkan juga ke index.php (tapi nanti index.php akan menampilkan halaman khusus)
        header('location:direktur.php');
    }
    else
    {
        // Jaga-jaga jika ada user dengan level tidak dikenal
        echo "<script>alert('Level user tidak dikenali!'); document.location='index.php';</script>";
    }
}
else
{
    // Jika Username/Password Salah
    echo "<script>
            alert('Maaf, Login Gagal. Pastikan Username dan Password Anda benar!');
            document.location='login.php';
        </script>";
}
?>