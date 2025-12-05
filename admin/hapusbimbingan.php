<?php
include "includes/config.php";
if (isset($_GET["hapusbimbingan"]))
    {
        $NPM = $_GET["hapusbimbingan"];
        mysqli_query($conn,"DELETE FROM bimbinganskripsi
        WHERE mhs_NPM = '$NPM'");
        echo"<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputbimbingan.php'</script>";
    }
?>