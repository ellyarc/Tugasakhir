<?php
include "includes/config.php";
if (isset($_GET["hapusskripsi"]))
    {
        $publikasi_ID = $_GET["hapusskripsi"];
        mysqli_query($conn,"DELETE FROM skripsi
        WHERE publikasi_ID = '$publikasi_ID'");
        echo"<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputskripsi.php'</script>";
    }
?>