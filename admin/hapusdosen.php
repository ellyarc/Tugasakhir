<?php
include "includes/config.php";
if (isset($_GET["hapusdosen"]))
    {
        $dosen_NIDN = $_GET["hapusdosen"];
        mysqli_query($conn,"DELETE FROM dosen
        WHERE dosen_NIDN = '$dosen_NIDN'");
        echo"<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputdosen.php'</script>";
    }
?>