<?php
include "includes/config.php";
if (isset($_GET["hapusjurnal"]))
    {
        $jurnalID = $_GET["hapusjurnal"];
        mysqli_query($conn,"DELETE FROM jurnal
        WHERE jurnal_ID = '$jurnalID'");
        echo"<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputjurnal.php'</script>";
    }
?>