<?php
include "includes/config.php";
if (isset($_GET["hapusmhs"]))
    {
        $mhs_NIDN = $_GET["hapusmhs"];
        mysqli_query($conn,"DELETE FROM mahasiswa
        WHERE mhs_NPM = '$mhs_NPM'");
        echo"<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputmhs.php'</script>";
    }
?>