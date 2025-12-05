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
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
                </head>

                <body>

                    <?php
                    include("includes/config.php");

                    $NPM = $_GET["ubahbimbingan"];
                    $edit = mysqli_query($conn, "
    SELECT bimbinganskripsi.*, pesertaskripsi.peserta_JUDUL
    FROM bimbinganskripsi
    JOIN pesertaskripsi ON pesertaskripsi.mhs_NPM = bimbinganskripsi.mhs_NPM
    WHERE bimbinganskripsi.mhs_NPM = '$NPM'
");
                    $row_edit = mysqli_fetch_array($edit);

                    if (isset($_POST["Ubah"])) {
                        $dosen_NIDN = $_POST["nidnDOSEN"];
                        $mhs_NPM = $_POST["npmMHS"];
                        $bimbingan_TGL = $_POST["tglBMB"];
                        $bimbingan_ISI = $_POST["isiBMB"];

                        if (!empty($_FILES["bimbinganFILE"]["name"])) {
                            $file_name = $_FILES["bimbinganFILE"]["name"];
                            $file_tmp = $_FILES["bimbinganFILE"]["tmp_name"];
                            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                            if ($file_ext !== "pdf") {
                                echo "<script>alert('Hanya PDF yang diizinkan!');history.back();</script>";
                                exit();
                            }
                            $file_name = uniqid() . "." . $file_ext;
                            move_uploaded_file($file_tmp, "docs/" . $file_name);
                        } else {
                            $file_name = $row_edit["bimbingan_DOKUMEN"];
                        }

                        mysqli_query($conn, "
        UPDATE bimbinganskripsi SET 
        dosen_NIDN = '$dosen_NIDN',
        mhs_NPM = '$mhs_NPM',
        bimbingan_TGL = '$bimbingan_TGL',
        bimbingan_ISI = '$bimbingan_ISI',
        bimbingan_DOKUMEN = '$file_name'
        WHERE mhs_NPM = '$NPM'
    ");
                        header("location:inputbimbingan.php");
                        exit();
                    }

                    if (isset($_POST["kirim"])) {
                        $search = $_POST["search"];
                        $query = mysqli_query($conn, "
        SELECT * FROM bimbinganskripsi
        JOIN pesertaskripsi ON pesertaskripsi.mhs_NPM = bimbinganskripsi.mhs_NPM
        JOIN dosen ON dosen.dosen_NIDN = bimbinganskripsi.dosen_NIDN
        WHERE bimbinganskripsi.mhs_NPM LIKE '%$search%'
    ");
                    } else {
                        $query = mysqli_query($conn, "
        SELECT * FROM bimbinganskripsi
        JOIN pesertaskripsi ON pesertaskripsi.mhs_NPM = bimbinganskripsi.mhs_NPM
        JOIN dosen ON dosen.dosen_NIDN = bimbinganskripsi.dosen_NIDN
    ");
                    }

                    $datamhs = mysqli_query($conn, "SELECT * FROM pesertaskripsi");
                    $datadosen = mysqli_query($conn, "SELECT * FROM dosen");
                    ?>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">

                            <form method="POST" enctype="multipart/form-data">
                                <div class="row mb-3 mt-5">
                                    <label class="col-sm-2 col-form-label">NIDN Dosen</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="nidnDOSEN">
                                            <?php while ($row = mysqli_fetch_array($datadosen)) { ?>
                                                <option value="<?= $row['dosen_NIDN'] ?>"
                                                    <?= $row['dosen_NIDN'] == $row_edit['dosen_NIDN'] ? "selected" : "" ?>>
                                                    <?= $row['dosen_NIDN'] . " - " . $row['dosen_Nama'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3 mt-5">
                                    <label class="col-sm-2 col-form-label">NPM Mahasiswa</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="npmMHS">
                                            <?php while ($row = mysqli_fetch_array($datamhs)) { ?>
                                                <option value="<?= $row['mhs_NPM'] ?>"
                                                    <?= $row['mhs_NPM'] == $row_edit['mhs_NPM'] ? "selected" : "" ?>>
                                                    <?= $row['mhs_NPM'] . " - " . $row['peserta_JUDUL'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3 mt-5">
                                    <label class="col-sm-2 col-form-label">Tanggal Bimbingan</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" name="tglBMB"
                                            value="<?= $row_edit['bimbingan_TGL'] ?>">
                                    </div>
                                </div>

                                <div class="row mb-3 mt-5">
                                    <label class="col-sm-2 col-form-label">Isi Bimbingan</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="isiBMB"
                                            rows="3"><?= $row_edit['bimbingan_ISI'] ?></textarea>
                                    </div>
                                </div>

                                <div class="row mb-3 mt-5">
                                    <label class="col-sm-2 col-form-label">Unggah Dokumen</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="bimbinganFILE">
                                        <p class="help-block">Unggah file PDF</p>
                                        <?php if ($row_edit["bimbingan_DOKUMEN"] != "") { ?>
                                            <p>File saat ini: <a href="docs/<?= $row_edit['bimbingan_DOKUMEN'] ?>"
                                                    target="_blank">Lihat PDF</a></p>
                                        <?php } else { ?>
                                            <p><i>Tidak ada dokumen yang diunggah.</i></p>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group-row">
                                    <div class="col-2"></div>
                                    <div class="col-10">
                                        <input type="submit" class="btn btn-success" value="Ubah" name="Ubah">
                                        <a href="inputbimbingan.php" class="btn btn-danger">Batal</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="jumbotron mt-5 mb-3">
                                <h1 class="display-5">Daftar Bimbingan</h1>
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
                                    <th>NIDN Dosen</th>
                                    <th>NPM Mahasiswa</th>
                                    <th>Judul Skripsi</th>
                                    <th>Tanggal Bimbingan</th>
                                    <th>Isi Bimbingan</th>
                                    <th>Dokumen Bimbingan</th>
                                    <th colspan="2" style="text-align: center;">Aksi</th>
                                </tr>

                                <?php { ?>
                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <tr class="danger"><!--menampilkan data dari tabel kategori-->
                                            <td><?php echo $row["dosen_NIDN"]; ?> </td>
                                            <td><?php echo $row["mhs_NPM"]; ?> </td>
                                            <td><?php echo $row["peserta_JUDUL"]; ?> </td>
                                            <td><?php echo $row["bimbingan_TGL"]; ?> </td>
                                            <td><?php echo $row["bimbingan_ISI"]; ?> </td>
                                            <td>
                                                <?php
                                                if ($row["bimbingan_DOKUMEN"] == "") {
                                                    echo "Tidak ada file";
                                                } else {
                                                    echo "<a href='docs/" . $row["bimbingan_DOKUMEN"] . "' target='_blank'>
            Lihat PDF </a>";
                                                }

                                                ?>
                                            </td>
                                            <td>
                                                <a href="editbimbingan.php?ubahbimbingan=<?php echo $row["mhs_NPM"] ?>"
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
                                                <a href="hapusbimbingan.php?hapusbimbingan=<?php echo $row["mhs_NPM"] ?>"
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