<?php
include "includes/config.php";
if (isset($_GET["hapuskategori"]))
    {
        $kategoriID = $_GET["hapuskategori"];
        mysqli_query($conn,"DELETE FROM kategori
        WHERE kategori_ID = '$kategoriID'");
        echo"<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputkategori.php'</script>";
    }
?>