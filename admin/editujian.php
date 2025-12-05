<?php ob_start();
session_start();
if (!isset($_SESSION["useremail"]))
    header("location:login.php");
?>
<?php include("bagiankode/head.php"); ?>
<!DOCTYPE html>
<html lang="en">

<body class="sb-nav-fixed">
<?php include("bagiankode/menunav.php"); ?>
<?php include("bagiankode/menu.php"); ?>

<div id="layoutSidenav_content">
<main>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">

<body>
<?php
include("includes/config.php");

// ⏳ ambil data untuk diedit
$npm_edit = $_GET["ubahujian"];
$data = mysqli_query($conn, "SELECT * FROM ujianskripsi WHERE mhs_NPM = '$npm_edit'");
$r = mysqli_fetch_array($data);

// ⏳ list dropdown NPM & NIDN
$datamhs = mysqli_query($conn, "
SELECT bimbinganskripsi.mhs_NPM, bimbinganskripsi.dosen_NIDN
FROM bimbinganskripsi
JOIN pesertaskripsi ON bimbinganskripsi.mhs_NPM = pesertaskripsi.mhs_NPM
GROUP BY bimbinganskripsi.mhs_NPM
");

// 💾 penyimpanan update
if (isset($_POST["Simpan"])) {
    $mhs_NPM = $_POST["npmMHS"];
    $ujian_TGL = $_POST["tglUJIAN"];
    $ujian_JAM = $_POST["jamUJIAN"];

    $ujian_FOTO = $r["ujian_FOTO"]; // default pakai foto lama
    if ($_FILES["ujianFILE"]["name"] != "") {
        $foto_asal = $_FILES["ujianFILE"]["name"];
        $tmp = $_FILES["ujianFILE"]["tmp_name"];
        $size = $_FILES["ujianFILE"]["size"];
        $ext = strtolower(pathinfo($foto_asal, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'png'];
        if ($size <= 500000 && in_array($ext, $allowed)) {
            $ujian_FOTO = uniqid() . "." . $ext;
            move_uploaded_file($tmp, "images/" . $ujian_FOTO);
        }
    }

    mysqli_query($conn, "UPDATE ujianskripsi SET
        ujian_TGL = '$ujian_TGL',
        ujian_JAM = '$ujian_JAM',
        ujian_FOTO = '$ujian_FOTO'
        WHERE mhs_NPM = '$mhs_NPM'
    ");

    header("location:inputujian.php");
    exit();
}

// 🔍 tabel daftar
if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "
        SELECT * FROM ujianskripsi, bimbinganskripsi
        WHERE bimbinganskripsi.mhs_NPM = ujianskripsi.mhs_NPM
        AND ujianskripsi.mhs_NPM LIKE '%$search%'
    ");
} else {
    $query = mysqli_query($conn, "
        SELECT * FROM ujianskripsi, bimbinganskripsi
        WHERE bimbinganskripsi.mhs_NPM = ujianskripsi.mhs_NPM
    ");
}
?>

<div class="row">
<div class="col-1"></div>
<div class="col-10">
<form method="POST" enctype="multipart/form-data">

    <div class="row mb-3 mt-5">
        <label class="col-sm-2 col-form-label">NPM</label>
        <div class="col-sm-10">
            <select class="form-control" id="npmMHS" name="npmMHS" readonly>
                <option><?php echo $r["mhs_NPM"]; ?></option>
            </select>
        </div>
    </div>

    <div class="row mb-3 mt-4">
        <label class="col-sm-2 col-form-label">Tanggal Ujian</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" name="tglUJIAN" value="<?php echo $r["ujian_TGL"]; ?>">
        </div>
    </div>

    <div class="row mb-3 mt-4">
        <label class="col-sm-2 col-form-label">Jam Ujian</label>
        <div class="col-sm-10">
            <input type="time" class="form-control" name="jamUJIAN" value="<?php echo $r["ujian_JAM"]; ?>">
        </div>
    </div>

    <div class="row mb-3 mt-4">
        <label class="col-sm-2 col-form-label">Unggah Dokumen</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" name="ujianFILE">
            <small>Biarkan kosong jika tidak ingin mengubah foto</small><br>
            <?php if ($r["ujian_FOTO"] == "") { ?>
                <img src="images/noimage.png" width="100">
            <?php } else { ?>
                <img src="images/<?php echo $r["ujian_FOTO"]; ?>" width="100">
            <?php } ?>
        </div>
    </div>

    <div class="form-group-row">
        <div class="col-2"></div>
        <div class="col-10">
            <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
            <a href="inputujian.php" class="btn btn-danger">Batal</a>
        </div>
    </div>

</form>
</div>
</div>

<div class="row">
<div class="col-1"></div>
<div class="col-10">
    <div class="jumbotron mt-5 mb-3">
        <h1 class="display-5">Daftar Ujian Skripsi</h1>
    </div>

    <form method="POST">
        <div class="form-group row mt-5 mb-3">
            <label for="search" class="col-sm-2">Cari NPM Mahasiswa</label>
            <div class="col-sm-6">
                <input type="text" name="search" class="form-control"
                    value="<?php if (isset($_POST["search"])) echo $_POST["search"]; ?>">
            </div>
            <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
        </div>
    </form>

    <table class="table table-success table-striped table-hover">
        <tr>
            <th>NPM</th>
            <th>NIDN</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Foto</th>
            <th colspan="2" style="text-align:center;">Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_array($query)) { ?>
        <tr>
            <td><?php echo $row["mhs_NPM"]; ?></td>
            <td><?php echo $row["dosen_NIDN"]; ?></td>
            <td><?php echo $row["ujian_TGL"]; ?></td>
            <td><?php echo $row["ujian_JAM"]; ?></td>
            <td>
                <?php if ($row["ujian_FOTO"] == "") { ?>
                    <img src="images/noimage.png" width="88">
                <?php } else { ?>
                    <img src="images/<?php echo $row["ujian_FOTO"]; ?>" width="88">
                <?php } ?>
            </td>
            <td><a href="editujian.php?ubahujian=<?php echo $row["mhs_NPM"]; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i></a></td>
            <td><a href="hapusujian.php?hapusujian=<?php echo $row["mhs_NPM"]; ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a></td>
        </tr>
        <?php } ?>
    </table>

</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>

</div>
</main>
<?php include("bagiankode/footer.php"); ?>
</div>
<?php include("bagiankode/jsscript.php"); ?>
</body>
</html>
