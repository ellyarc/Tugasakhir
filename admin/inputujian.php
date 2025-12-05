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
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title></title>

                    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">

                </head>

                <body>

                    <?php
                    include("includes/config.php");

                    if (isset($_POST["Simpan"])) {
                        $mhs_NPM = $_POST["npmMHS"];
                        $ujian_TGL = $_POST["tglUJIAN"];
                        $ujian_JAM = $_POST["jamUJIAN"];

                        $ujian_FOTO = $_FILES["ujianFILE"]["name"];
                        $file_tmp = $_FILES["ujianFILE"]["tmp_name"];
                        $file_size = $_FILES["ujianFILE"]["size"];
                        $file_ext = strtolower(pathinfo($ujian_FOTO, PATHINFO_EXTENSION));

                        $ujian_FOTO = uniqid() . "." . $file_ext;
                        $path = "images/" . $ujian_FOTO;
                        $allowed_ext = ['jpg', 'png'];
                        if ($file_size <= 500000 && in_array($file_ext, $allowed_ext)) {
                            move_uploaded_file($file_tmp, $path);
                        } else {
                            $ujian_FOTO = "";
                        }

                        mysqli_query($conn, "INSERT INTO ujianskripsi
(mhs_NPM, ujian_TGL, ujian_JAM, ujian_FOTO)
VALUES ('$mhs_NPM', '$ujian_TGL', '$ujian_JAM', '$ujian_FOTO')");


                        header("location:inputujian.php");
                        exit();
                    }

                    if (isset($_POST["kirim"])) {
                        $search = $_POST["search"];
                        $query = mysqli_query($conn, "
    SELECT *
    FROM ujianskripsi, bimbinganskripsi WHERE bimbinganskripsi.mhs_NPM = ujianskripsi.mhs_NPM
    AND ujianskripsi.mhs_NPM LIKE '%$search%'
");

                    } else {
                        $query = mysqli_query($conn, "
SELECT *
    FROM ujianskripsi, bimbinganskripsi WHERE bimbinganskripsi.mhs_NPM = ujianskripsi.mhs_NPM
");
                    }
                    $datamhs = mysqli_query($conn, "
    SELECT bimbinganskripsi.mhs_NPM, bimbinganskripsi.dosen_NIDN
    FROM bimbinganskripsi
    JOIN pesertaskripsi ON bimbinganskripsi.mhs_NPM = pesertaskripsi.mhs_NPM
    GROUP BY bimbinganskripsi.mhs_NPM
");
                    ?>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="row mb-3 mt-5">
                                    <label for="npmMHS" class="col-sm-2 col-form-label">NPM</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="npmMHS" name="npmMHS">
                                            <option>NPM Mahasiswa - NIDN Dosen</option>
                                            <?php while ($row = mysqli_fetch_array($datamhs)) { ?>
                                                <option value="<?php echo $row["mhs_NPM"] ?>"
                                                    data-nidn="<?php echo $row["dosen_NIDN"] ?>">
                                                    <?php echo $row["mhs_NPM"] ?> - <?php echo $row["dosen_NIDN"] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 mt-5">
                                    <label for="tglUJIAN" class="col-sm-2 col-form-label">Tanggal Ujian</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="tglUJIAN" name="tglUJIAN">
                                    </div>
                                </div>
                                <div class="row mb-3 mt-5">
                                    <label for="jamUJIAN" class="col-sm-2 col-form-label">Jam Ujian</label>
                                    <div class="col-sm-10">
                                        <input type="time" class="form-control" id="jamUJIAN" name="jamUJIAN">
                                    </div>
                                </div>
                                <div class="row mb-3 mt-5">
                                    <label for="ujianFILE" class="col-sm-2 col-form-label">Unggah Dokumen</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="ujianFILE" name="ujianFILE">
                                        <p class="help-block">Unggah file dokumen</p>
                                    </div>
                                </div>
                                <div class="form-group-row">
                                    <div class="col-2"></div>
                                    <div class="col-10">
                                        <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                                        <input type="reset" class="btn btn-danger" value="Batal" name="Batal">
                                    </div><!--penutup class col-10-->
                                </div><!--penutup class form-group-->
                            </form>
                            <div class="1"></div>
                        </div><!--penutup class row-->
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
                                            <input type="text" name="search" class="form-control" id="search" value="<?php if (isset($_POST["search"])) {
                                                echo $_POST["search"];
                                            } ?>" placeholder="Cari Judul Berita">
                                        </div>
                                        <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                                    </div>
                                </form>
                                <table class="table table-success table-striped table-hover">
                                    <tr class="info"><!--membuat judul-->
                                        <th>NPM Mahasiswa</th>
                                        <th>NIDN Dosen</th>
                                        <th>Tanggal Ujian</th>
                                        <th>Jam Ujian</th>
                                        <th>Foto Ujian</th>
                                        <th colspan="2" style="text-align: center;">Aksi</th>
                                    </tr>
                                    <?php { ?>
                                        <?php while ($row = mysqli_fetch_array($query)) { ?>
                                            <tr class="danger"><!--menampilkan data dari tabel kategori-->
                                                <td><?php echo $row["mhs_NPM"]; ?> </td>
                                                <td><?php echo $row["dosen_NIDN"]; ?> </td>
                                                <td><?php echo $row["ujian_TGL"]; ?> </td>
                                                <td><?php echo $row["ujian_JAM"]; ?> </td>
                                                <td>
                                                    <?php
                                                    if ($row["ujian_FOTO"] == "") {
                                                        echo "<img src='images/noimage.png' width='88'/>";
                                                    } else {
                                                        echo "<img src='images/" . $row["ujian_FOTO"] . "' width='88' class='img-responsive'/>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="editujian.php?ubahujian=<?php echo $row["mhs_NPM"] ?>"
                                                        class="btn btn-success" title="EDIT">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path
                                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                            <path fill-rule="evenodd"
                                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                        </svg>
                                                </td>
                                                <td>
                                                    <a href="hapusujian.php?hapusujian=<?php echo $row["mhs_NPM"] ?>"
                                                        class="btn btn-danger" title="HAPUS">
                                                        <i class="bi bi-trash"></i>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </table>
                            </div>><!--penutup class col-10 untuk tabel-->
                        </div>><!--penutup class row untuk tabel-->
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                        <script type="text/javascript"
                            src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
                </body>
            </div>
        </main>
        <?php include("bagiankode/footer.php"); ?>
    </div>
    </div>
    <?php include("bagiankode/jsscript.php"); ?>
</body>


</html>