<?php
    session_start();

    // 1. AMBIL DULU datanya sebelum dihancurkan (PENTING!)
    // Kita cek level dan nama lengkap user yang sedang login
    $level = isset($_SESSION['level']) ? $_SESSION['level'] : '';
    $nama  = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'User';

    // 2. Tentukan pesan berdasarkan level
    if ($level == 'admin') {
        $pesan = "Anda telah keluar dari Halaman Administrator.";
    } 
    elseif ($level == 'direktur') {
        // Kita bisa buat pesannya lebih sopan untuk Direktur
        $pesan = "Logout Berhasil. Sampai jumpa kembali, $nama!";
    } 
    else {
        // Default jika session sudah habis duluan atau user tidak dikenal
        $pesan = "Anda telah berhasil Logout.";
    }

    // 3. HAPUS SEMUA SESSION
    unset($_SESSION['id_user']);
    unset($_SESSION['username']);
    unset($_SESSION['nama_lengkap']);
    unset($_SESSION['level']);

    session_destroy();

    // 4. Tampilkan pesan alert yang sudah kita set di atas
    echo "<script>
            alert('$pesan');
            document.location='login.php';
          </script>";
?>