<?php ob_start();
session_start();
if (!isset($_SESSION["useremail"]))
    header("location:login.php");
?>
<?php include("bagiankode/head.php"); ?>
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
                        include("includes/config.php");//**file config.php untuk koneksi database */
                        
                        if (isset($_POST["Simpan"])) {
                            if (isset($_REQUEST["nidnDSN"])) {
                                $dosen_NIDN = $_REQUEST["nidnDSN"];
                            }
                            if (empty($_POST["nidnDSN"])) {
                                ?>
                                <h1>Maaf anda salah input</h1><?php
                                die("anda harus mengisi NIDN");
                            }

                            if (isset($_REQUEST["nikDSN"])) {
                                $dosen_NIK = $_REQUEST["nikDSN"];
                            }
                            if (empty($_POST["nikDSN"])) {
                                ?>
                                <h1>Maaf anda salah input</h1><?php
                                die("anda harus mengisi NIK");
                            }

                            if (isset($_REQUEST["namaDSN"])) {
                                $dosen_Nama = $_REQUEST["namaDSN"];
                            }
                            if (empty($_POST["namaDSN"])) {
                                ?>
                                <h1>Maaf anda salah input</h1><?php
                                die("anda harus mengisi Nama");
                            }

                            // Ambil data hanya sekali setelah validasi
                            $dosen_NIDN = $_POST["nidnDSN"];
                            $dosen_NIK = $_POST["nikDSN"];
                            $dosen_Nama = $_POST["namaDSN"];
                            $dosen_Ket = $_POST["ketDSN"];

                            mysqli_query($conn, "insert into dosen values('$dosen_NIDN', '$dosen_NIK', '$dosen_Nama', '$dosen_Ket')"); /*memasukkan data ke dalam tabel */
                            header("location:inputdosen.php");
                        }

                        $query = mysqli_query($conn, "select * from dosen");
                        ?>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <form method="POST">
                                    <div class="row mb-3 mt-5">
                                        <label for="nidnDSN" class="col-sm-2 col-form-label">NIDN Dosen</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nidnDSN" name="nidnDSN"
                                                placeholder="Nomor Induk Dosen Nasional" maxlength="10" required="">
                                        </div>
                                    </div>
                                    <div class="row mb-3 mt-5">
                                        <label for="nikDSN" class="col-sm-2 col-form-label">Nomor Induk
                                            Kependudukan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nikDSN" name="nikDSN"
                                                placeholder="Isikan Nomor Induk Kependudukan" maxlength="8" required="">
                                        </div>
                                    </div>
                                    <div class="row mb-3 mt-5">
                                        <label for="namaDSN" class="col-sm-2 col-form-label">Nama Dosen</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="namaDSN" name="namaDSN"
                                                placeholder="Isikan Nama Dosen" maxlength="30" required="">
                                        </div>
                                    </div>
                                    <div class="row mb-3 mt-5">
                                        <label for="ketDSN" class="col-sm-2 col-form-label">Keterangan Dosen</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="ketDSN" name="ketDSN"
                                                placeholder="Masukkan Keterangan Dosen">
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
                                        <h1 class="display-5">Daftar Dosen</h1>
                                    </div>

                                    <table class="table table-success table-striped table-hover">
                                        <tr class="info"><!--membuat judul-->
                                            <th>NIDN</th>
                                            <th>NIK</th>
                                            <th>Nama Dosen</th>
                                            <th>Keterangan</th>
                                            <th colspan="2" style="text-align: center;">Aksi</th>
                                        </tr>

                                        <?php { ?>
                                            <?php while ($row = mysqli_fetch_array($query)) { ?>
                                                <tr class="danger"><!--menampilkan data dari tabel kategori-->
                                                    <td><?php echo $row["dosen_NIDN"]; ?> </td>
                                                    <td><?php echo $row["dosen_NIK"]; ?> </td>
                                                    <td><?php echo $row["dosen_Nama"]; ?> </td>
                                                    <td><?php echo $row["dosen_Ket"]; ?> </td>
                                                    <td>
                                                        <a href="editdosen.php?ubahdosen=<?php echo $row["dosen_NIDN"] ?>"
                                                            class="btn btn-success" title="EDIT">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-pencil-square"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                <path fill-rule="evenodd"
                                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                            </svg>
                                                    </td>
                                                    <td>
                                                        <a href="hapusdosen.php?hapusdosen=<?php echo $row["dosen_NIDN"] ?>"
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