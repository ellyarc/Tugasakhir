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

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    </head>

<?php
include("includes/config.php");

if (isset($_POST["Simpan"])) {
    $kategori_ID = $_POST["kategoriID"];
    $kategori_Nama = $_POST["kategoriNama"];
    $kategori_Metode = $_POST["kategoriMetode"];
    $kategori_KET = $_POST["kategoriKET"];

    mysqli_query($conn, "INSERT INTO kategori VALUES('$kategori_ID','$kategori_Nama','$kategori_Metode','$kategori_KET')");
    header("location:inputkategori.php");
}

$query = mysqli_query($conn, "SELECT * FROM kategori");
?>

<div class="row">
    <div class="col-1"></div>
    <div class="col-10">
        <form method="POST">
            <div class="row mb-3 mt-5">
                <label class="col-sm-2 col-form-label">ID Kategori</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="kategoriID" placeholder="ID Kategori" required>
                </div>
            </div>

            <div class="row mb-3 mt-5">
                <label class="col-sm-2 col-form-label">Nama Kategori</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="kategoriNama" placeholder="Nama Kategori" required>
                </div>
            </div>

            <div class="row mb-3 mt-5">
                <label class="col-sm-2 col-form-label">Metode</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="kategoriMetode" placeholder="Metode Kategori" required>
                </div>
            </div>

            <div class="row mb-3 mt-5">
                <label class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="kategoriKET" placeholder="Keterangan Kategori">
                </div>
            </div>

            <div class="form-group-row">
                <div class="col-2"></div>
                <div class="col-10">
                    <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                    <input type="reset" class="btn btn-danger" value="Batal">
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABLE -->
<div class="row">
    <div class="col-1"></div>
    <div class="col-10">
        <div class="jumbotron mt-5 mb-3">
            <h1 class="display-5">Daftar Kategori</h1>
        </div>

        <table class="table table-success table-striped table-hover">
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Metode</th>
                <th>Keterangan</th>
                <th colspan="2" style="text-align:center">Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($query)) { ?>
                <tr>
                    <td><?php echo $row["kategori_ID"]; ?></td>
                    <td><?php echo $row["kategori_Nama"]; ?></td>
                    <td><?php echo $row["kategori_Metode"]; ?></td>
                    <td><?php echo $row["kategori_KET"]; ?></td>
                    <td>
                        <a href="editkategori.php?ubahkategori=<?php echo $row["kategori_ID"] ?>" class="btn btn-success" title="EDIT">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                    <td>
                        <a href="hapuskategori.php?hapuskategori=<?php echo $row["kategori_ID"] ?>" class="btn btn-danger" title="HAPUS">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
</div>
</main>
<?php include("bagiankode/footer.php"); ?>
</div>
<?php include("bagiankode/jsscript.php"); ?>
</body>
</html>
