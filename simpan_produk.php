<?php
// Panggil file koneksi database
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Tangkap data teks dari form HTML
    $kode       = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $nama       = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kategori   = $_POST['kategori'];
    $stok       = intval($_POST['stok']);
    $harga_beli = intval($_POST['harga_beli']);
    $harga_jual = intval($_POST['harga_jual']);

    // Proses File Gambar
    $file_name  = $_FILES['gambar']['name'];
    $file_tmp   = $_FILES['gambar']['tmp_name'];
    $file_error = $_FILES['gambar']['error'];
    
    // Default nama gambar jika user tidak upload dengan benar
    $nama_gambar_baru = 'default.jpg';

    if ($file_error === 0) {
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensi_file  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Validasi format file
        if (in_array($ekstensi_file, $ekstensi_valid)) {
            // Beri nama acak yang unik pada gambar agar tidak bentrok di folder
            $nama_gambar_baru = uniqid() . '.' . $ekstensi_file;
            $jalur_tujuan     = 'uploads/' . $nama_gambar_baru;

            // Pindahkan file asli ke folder uploads
            move_uploaded_file($file_tmp, $jalur_tujuan);
        } else {
            echo "<script>alert('Format file salah! Gunakan JPG, JPEG, PNG, atau WEBP.'); window.history.back();</script>";
            exit;
        }
    }

    // Ambil data ke database MySQL
    $query = "INSERT INTO produk (kode, nama, kategori, stok, harga_beli, harga_jual, gambar) 
              VALUES ('$kode', '$nama', '$kategori', '$stok', '$harga_beli', '$harga_jual', '$nama_gambar_baru')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Produk berhasil disimpan!'); window.location.href='index.php';</script>";
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>