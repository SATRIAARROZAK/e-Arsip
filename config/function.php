<?php

function upload()
{
    // Ambil properti file
    $namaFile   = $_FILES['file']['name'];
    $ukuranFile = $_FILES['file']['size'];
    $error      = $_FILES['file']['error'];
    $tmpName    = $_FILES['file']['tmp_name'];

    // Cek apakah tidak ada file yang diupload
    if ($error === 4) {
        return false; 
    }

    // Cek ekstensi file (Hanya boleh PDF, JPG, PNG)
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'pdf'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Yang anda upload bukan file Gambar/PDF!');</script>";
        return false;
    }

    // Cek ukuran file (Max 2 MB)
    if ($ukuranFile > 2000000) {
        echo "<script>alert('Ukuran file terlalu besar! (Max 2MB)');</script>";
        return false;
    }

    // Lolos pengecekan, generate nama baru agar tidak duplikat
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    // Pindahkan file ke folder 'file' (Pastikan folder ini ada di root project!)
    // CATATAN: Folder tujuan harus bernama 'file' sesuai data.php Anda
    move_uploaded_file($tmpName, 'file/' . $namaFileBaru);

    return $namaFileBaru;
}
?>