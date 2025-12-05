<?php ob_start();
session_start();
if (!isset($_SESSION["useremail"]))
    header("location:login.php");
?>
<?php
include("bagiankode/head.php");
?>
<!DOCTYPE html>
<html>

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
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
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

                    if (isset($_GET["ubahmhs"])) {
                        $mhs_NPM = $_GET["ubahmhs"];
                        $edit = mysqli_query($conn, "
        SELECT * FROM mahasiswa
        WHERE mhs_NPM = '$mhs_NPM'
    ");
                        $row_edit = mysqli_fetch_array($edit);
                    } else {
                        $row_edit = [];
                    }

                    if (isset($_POST["Simpan"])) {
                        $mhs_NPM = $_POST["npmMHS"];
                        $mhs_Nama = $_POST["namaMHS"];
                        $mhs_Alamat = $_POST["alamatMHS"];
                        $mhs_DOB = $_POST["lahirMHS"];
                        $mhs_Ket = $_POST["ketMHS"];

                        if (isset($_GET["ubahmhs"])) {
                            mysqli_query($conn, "
            UPDATE mahasiswa SET
                mhs_Nama = '$mhs_Nama',
                mhs_Alamat = '$mhs_Alamat',
                mhs_DOB = '$mhs_DOB',
                mhs_Ket = '$mhs_Ket'
            WHERE mhs_NPM = '$mhs_NPM'
        ");
                        } else {
                            mysqli_query($conn, "
            INSERT INTO mahasiswa (mhs_NPM, mhs_Nama, mhs_Alamat, mhs_DOB, mhs_Ket)
            VALUES ('$mhs_NPM', '$mhs_Nama', '$mhs_Alamat', '$mhs_DOB', '$mhs_Ket')
        ");
                        }

                        header("location: inputmhs.php");
                        exit;

                    }
                    $query = mysqli_query($conn, "SELECT * FROM mahasiswa");
                    ?>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <form method="POST">
                                <div class="row mb-3 mt-5">
                                    <label for="npmMHS" class="col-sm-2 col-form-label">NPM Mahasiswa</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="npmMHS" name="npmMHS"
                                            placeholder="Nomor Pokok Mahasiswa"
                                            value="<?php echo $row_edit["mhs_NPM"] ?? ''; ?>" maxlength="9" required="">
                                    </div>
                                </div>
                                <div class="row mb-3 mt-5">
                                    <label for="namaMHS" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="namaMHS" name="namaMHS"
                                            placeholder="Isikan Nama Mahasiswa"
                                            value="<?php echo $row_edit["mhs_Nama"] ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3 mt-5">
                                    <label for="alamatMHS" class="col-sm-2 col-form-label">Alamat Mahasiswa</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="alamatMHS" name="alamatMHS"
                                            placeholder="Isikan Alamat Mahasiswa"
                                            value="<?php echo $row_edit["mhs_Alamat"] ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3 mt-5">
                                    <label for="lahirMHS" class="col-sm-2 col-form-label">Lahir Mahasiswa</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="lahirMHS" name="lahirMHS"
                                            value="<?php echo $row_edit["mhs_DOB"] ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3 mt-5">
                                    <label for="ketMHS" class="col-sm-2 col-form-label">Keterangan Mahasiswa</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="ketMHS" name="ketMHS"
                                            placeholder="Masukkan Keterangan Mahasiswa"
                                            value="<?php echo $row_edit["mhs_Ket"] ?? ''; ?>">
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
                                    <h1 class="display-5">Daftar Mahasiswa</h1>
                                </div>

                                <table class="table table-success table-striped table-hover">
                                    <tr class="info"><!--membuat judul-->
                                        <th>NPM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Alamat Mahasiswa</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Keterangan</th>
                                        <th colspan="2" style="text-align: center;">Aksi</th>
                                    </tr>

                                    <?php { ?>
                                        <?php while ($row = mysqli_fetch_array($query)) { ?>
                                            <tr class="danger"><!--menampilkan data dari tabel kategori-->
                                                <td><?php echo $row["mhs_NPM"]; ?> </td>
                                                <td><?php echo $row["mhs_Nama"]; ?> </td>
                                                <td><?php echo $row["mhs_Alamat"]; ?> </td>
                                                <td><?php echo $row["mhs_DOB"]; ?> </td>
                                                <td><?php echo $row["mhs_Ket"]; ?> </td>
                                                <td>
                                                    <a href="editmhs.php?ubahmhs=<?php echo $row["mhs_NPM"] ?>"
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
                                                    <a href="hapusmhs.php?hapusmhs=<?php echo $row["mhs_NPM"] ?>"
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