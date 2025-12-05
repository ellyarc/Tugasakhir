<?php ob_start();
session_start();
if (!isset($_SESSION["useremail"]))
    header("location:login.php");
?>
<?php
include("bagiankode/head.php");
?>
<!DOCTYPE html>
<html lang="en">

<body class="sb-nav-fixed">
    <?php include("bagiankode/menunav.php"); ?>
    <?php include("bagiankode/menu.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Kategori</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Form Edit Kategori</li>
                </ol>
<head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title></title>

                    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
                </head>
                <?php
                include("includes/config.php");

                if (isset($_GET["ubahkategori"])) {
                    $kategori_ID = $_GET["ubahkategori"];
                    $edit = mysqli_query($conn, "SELECT * FROM kategori WHERE kategori_ID = '$kategori_ID'");
                    $row_edit = mysqli_fetch_array($edit);
                } else {
                    header("location: inputkategori.php");
                }

                if (isset($_POST["Ubah"])) {
                    $kategori_Nama = $_POST["namaKAT"];
                    $kategori_Metode = $_POST["metodeKAT"];
                    $kategori_KET = $_POST["ketKAT"];

                    mysqli_query($conn, "
                        UPDATE kategori SET
                            kategori_Nama = '$kategori_Nama',
                            kategori_Metode = '$kategori_Metode',
                            kategori_KET = '$kategori_KET'
                        WHERE kategori_ID = '$kategori_ID'
                    ");

                    header("location: inputkategori.php");
                }

                $datakategori = mysqli_query($conn, "SELECT * FROM kategori");
                ?>

                <!-- FORM EDIT -->
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <form method="POST" class="mt-5">
                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label">ID Kategori</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        value="<?php echo $row_edit["kategori_ID"]; ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label">Nama Kategori</label>
                                <div class="col-sm-10">
                                    <input type="text" name="namaKAT" class="form-control"
                                        maxlength="50" required
                                        value="<?php echo $row_edit["kategori_Nama"]; ?>">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label">Metode</label>
                                <div class="col-sm-10">
                                    <input type="text" name="metodeKAT" class="form-control"
                                        maxlength="50"
                                        value="<?php echo $row_edit["kategori_Metode"]; ?>">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label">Keterangan</label>
                                <div class="col-sm-10">
                                    <input type="text" name="ketKAT" class="form-control"
                                        value="<?php echo $row_edit["kategori_KET"]; ?>">
                                </div>
                            </div>

                            <div class="form-group-row">
                                <div class="col-2"></div>
                                <div class="col-10">
                                    <input type="submit" class="btn btn-success" value="Ubah" name="Ubah">
                                    <a href="inputkategori.php" class="btn btn-danger">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="row mt-5 mb-3">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <h3>Daftar Kategori</h3>
                        <table class="table table-success table-striped table-hover">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Metode</th>
                                <th>Keterangan</th>
                                <th colspan="2" style="text-align: center;">Aksi</th>
                            </tr>

                            <?php while ($row = mysqli_fetch_array($datakategori)) { ?>
                                <tr>
                                    <td><?php echo $row["kategori_ID"]; ?></td>
                                    <td><?php echo $row["kategori_Nama"]; ?></td>
                                    <td><?php echo $row["kategori_Metode"]; ?></td>
                                    <td><?php echo $row["kategori_KET"]; ?></td>
                                    <td>
                                        <a href="editkategori.php?ubahkategori=<?php echo $row["kategori_ID"] ?>"
                                            class="btn btn-success">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="hapuskategori.php?hapuskategori=<?php echo $row["kategori_ID"] ?>"
                                            class="btn btn-danger">
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
