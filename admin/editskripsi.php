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
                <h1 class="mt-4">Edit Publikasi Jurnal</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Edit Data Publikasi</li>
                </ol>

                <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">

                <?php
                include("includes/config.php");

                // ⏳ AMBIL DATA YANG AKAN DIEDIT
                // Mengambil ID dari URL (dikirim dari inputskripsi.php)
                if (isset($_GET["ubahskripsi"])) {
                    $npm_edit = $_GET["ubahskripsi"];
                    $edit_query = mysqli_query($conn, "SELECT * FROM skripsi WHERE mhs_NPM = '$npm_edit'");
                    $row_edit = mysqli_fetch_array($edit_query);
                }

                // ⏳ AMBIL DATA MASTER UNTUK DROPDOWN
                $datamhs = mysqli_query($conn, "SELECT * FROM mahasiswa");
                $datakategori = mysqli_query($conn, "SELECT * FROM kategori");
                $datajurnal = mysqli_query($conn, "SELECT * FROM jurnal");

                // 💾 PROSES UPDATE DATA
                if (isset($_POST["Simpan"])) {
                    $publikasi_ID = $_POST["idPUB"];
                    $mhs_NPM = $_POST["npmMHS"]; // Ini biasanya readonly/hidden saat edit
                    $kategori_ID = $_POST["idKATEGORI"];
                    $jurnal_ID = $_POST["idJURNAL"];
                    $publikasi_JUDUL = $_POST["judulPUB"];
                    $publikasi_DATE = $_POST["datePUB"];

                    // Query Update ke tabel skripsi
                    mysqli_query($conn, "UPDATE skripsi SET
                        publikasi_ID = '$publikasi_ID',
                        kategori_ID = '$kategori_ID',
                        jurnal_ID = '$jurnal_ID',
                        publikasi_JUDUL = '$publikasi_JUDUL',
                        publikasi_DATE = '$publikasi_DATE'
                        WHERE mhs_NPM = '$mhs_NPM'
                    ");

                    header("location:inputskripsi.php");
                    exit();
                }

                // 🔍 LOGIKA PENCARIAN & TABEL DAFTAR (SAMA SEPERTI INPUT)
                if (isset($_POST["kirim"])) {
                    $search = $_POST["search"];
                    $query = mysqli_query($conn, "
                        SELECT s.publikasi_ID, m.mhs_NPM, m.mhs_Nama, k.kategori_ID, k.kategori_Nama, j.jurnal_ID, j.jurnal_Nama, s.publikasi_JUDUL, s.publikasi_DATE
                        FROM skripsi s
                        JOIN mahasiswa m ON s.mhs_NPM = m.mhs_NPM
                        JOIN kategori k ON s.kategori_ID = k.kategori_ID
                        JOIN jurnal j ON s.jurnal_ID = j.jurnal_ID
                        WHERE m.mhs_NPM LIKE '%$search%'
                    ");
                } else {
                    $query = mysqli_query($conn, "
                        SELECT s.publikasi_ID, m.mhs_NPM, m.mhs_Nama, k.kategori_ID, k.kategori_Nama, j.jurnal_ID, j.jurnal_Nama, s.publikasi_JUDUL, s.publikasi_DATE
                        FROM skripsi s
                        JOIN mahasiswa m ON s.mhs_NPM = m.mhs_NPM
                        JOIN kategori k ON s.kategori_ID = k.kategori_ID
                        JOIN jurnal j ON s.jurnal_ID = j.jurnal_ID
                    ");
                }
                ?>

                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <form method="POST" enctype="multipart/form-data">

                            <div class="row mb-3 mt-5">
                                <label class="col-sm-2 col-form-label">ID Publikasi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="idPUB" value="<?php echo $row_edit["publikasi_ID"]; ?>">
                                </div>
                            </div>

                            <div class="row mb-3 mt-4">
                                <label class="col-sm-2 col-form-label">NPM Mahasiswa</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="npmMHS" readonly>
                                        <option value="<?php echo $row_edit["mhs_NPM"]; ?>"><?php echo $row_edit["mhs_NPM"]; ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3 mt-4">
                                <label class="col-sm-2 col-form-label">Kategori Publikasi</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="idKATEGORI">
                                        <option>Pilih Kategori</option>
                                        <?php while ($k = mysqli_fetch_array($datakategori)) { ?>
                                            <option value="<?php echo $k["kategori_ID"] ?>" 
                                                <?php if ($row_edit['kategori_ID'] == $k['kategori_ID']) echo "selected"; ?>>
                                                <?php echo $k["kategori_Nama"] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3 mt-4">
                                <label class="col-sm-2 col-form-label">Jurnal</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="idJURNAL">
                                        <option>Pilih Jurnal</option>
                                        <?php while ($j = mysqli_fetch_array($datajurnal)) { ?>
                                            <option value="<?php echo $j["jurnal_ID"] ?>"
                                                <?php if ($row_edit['jurnal_ID'] == $j['jurnal_ID']) echo "selected"; ?>>
                                                <?php echo $j["jurnal_Nama"] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3 mt-4">
                                <label class="col-sm-2 col-form-label">Judul Publikasi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="judulPUB" value="<?php echo $row_edit["publikasi_JUDUL"]; ?>">
                                </div>
                            </div>

                            <div class="row mb-3 mt-4">
                                <label class="col-sm-2 col-form-label">Tanggal Publikasi</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="datePUB" value="<?php echo $row_edit["publikasi_DATE"]; ?>">
                                </div>
                            </div>

                            <div class="form-group-row">
                                <div class="col-2"></div>
                                <div class="col-10">
                                    <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                                    <a href="inputskripsi.php" class="btn btn-danger">Batal</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <div class="jumbotron mt-5 mb-3">
                            <h1 class="display-5">Daftar Publikasi Jurnal</h1>
                        </div>

                        <form method="POST">
                            <div class="form-group row mt-5 mb-3">
                                <label for="search" class="col-sm-2">Cari NPM Mahasiswa</label>
                                <div class="col-sm-6">
                                    <input type="text" name="search" class="form-control" id="search"
                                        value="<?php if (isset($_POST["search"])) { echo $_POST["search"]; } ?>"
                                        placeholder="Cari NPM">
                                </div>
                                <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                            </div>
                        </form>

                        <table class="table table-success table-striped table-hover">
                            <tr>
                                <th>ID Publikasi</th>
                                <th>NPM - Nama</th>
                                <th>Nama Kategori</th>
                                <th>Nama Jurnal</th>
                                <th>Judul Publikasi</th>
                                <th>Tanggal Publikasi</th>
                                <th colspan="2" style="text-align: center;">Aksi</th>
                            </tr>
                            <?php while ($row = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td><?php echo $row["publikasi_ID"]; ?></td>
                                    <td><?php echo $row["mhs_NPM"]; ?> - <?php echo $row["mhs_Nama"]; ?></td>
                                    <td><?php echo $row["kategori_Nama"]; ?></td>
                                    <td><?php echo $row["jurnal_Nama"]; ?></td>
                                    <td><?php echo $row["publikasi_JUDUL"]; ?></td>
                                    <td><?php echo $row["publikasi_DATE"]; ?></td>
                                    <td>
                                        <a href="editskripsi.php?ubahskripsi=<?php echo $row["mhs_NPM"] ?>" class="btn btn-success" title="EDIT">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="hapusskripsi.php?hapusskripsi=<?php echo $row["mhs_NPM"] ?>" class="btn btn-danger" title="HAPUS">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
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