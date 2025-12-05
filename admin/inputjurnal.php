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


                <?php
                include("includes/config.php");

                if (isset($_POST["Simpan"])) {
                    $jurnal_ID = $_POST["jurnalID"];
                    $jurnal_Nama = $_POST["jurnalNama"];
                    $jurnal_ISSN = $_POST["jurnalISSN"];
                    $jurnal_SINTA = $_POST["jurnalSinta"];
                    $jurnal_URL = $_POST["jurnalURL"];

                    mysqli_query($conn, "INSERT INTO jurnal VALUES('$jurnal_ID','$jurnal_Nama','$jurnal_ISSN','$jurnal_SINTA','$jurnal_URL')");
                    header("location:inputjurnal.php");
                }

                $query = mysqli_query($conn, "SELECT * FROM jurnal");
                ?>

                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <form method="POST">
                            <div class="row mb-3 mt-5">
                                <label class="col-sm-2 col-form-label">ID Jurnal</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="jurnalID" placeholder="ID Jurnal"
                                        required="">
                                </div>
                            </div>

                            <div class="row mb-3 mt-5">
                                <label class="col-sm-2 col-form-label">Nama Jurnal</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="jurnalNama" placeholder="Nama Jurnal"
                                        required="">
                                </div>
                            </div>

                            <div class="row mb-3 mt-5">
                                <label class="col-sm-2 col-form-label">ISSN</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="jurnalISSN" placeholder="Nomor ISSN"
                                        required="">
                                </div>
                            </div>

                            <div class="row mb-3 mt-5">
                                <label class="col-sm-2 col-form-label">SINTA</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="jurnalSinta"
                                        placeholder="Peringkat SINTA (misal: S2 / S3)">
                                </div>
                            </div>

                            <div class="row mb-3 mt-5">
                                <label class="col-sm-2 col-form-label">URL Jurnal</label>
                                <div class="col-sm-10">
                                    <input type="url" class="form-control" name="jurnalURL"
                                        placeholder="Alamat Website Jurnal">
                                </div>
                            </div>

                            <div class="form-group-row">
                                <div class="col-2"></div>
                                <div class="col-10">
                                    <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                                    <input type="reset" class="btn btn-danger" value="Batal" name="Batal">
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
                            <h1 class="display-5">Daftar Publikasi Jurnal</h1>
                        </div>

                        <table class="table table-success table-striped table-hover">
                            <tr>
                                <th>ID</th>
                                <th>Nama Jurnal</th>
                                <th>ISSN</th>
                                <th>SINTA</th>
                                <th>Website</th>
                                <th colspan="2" style="text-align: center;">Aksi</th>
                            </tr>

                            <?php while ($row = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td><?php echo $row["jurnal_ID"]; ?></td>
                                    <td><?php echo $row["jurnal_Nama"]; ?></td>
                                    <td><?php echo $row["jurnal_ISSN"]; ?></td>
                                    <td><?php echo $row["jurnal_SINTA"]; ?></td>
                                    <td><a href="<?php echo $row["jurnal_URL"]; ?>"
                                            target="_blank"><?php echo $row["jurnal_URL"]; ?></a></td>
                                    <td>
                                        <a href="editjurnal.php?ubahjurnal=<?php echo $row["jurnal_ID"] ?>"
                                            class="btn btn-success" title="EDIT">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="hapusjurnal.php?hapusjurnal=<?php echo $row["jurnal_ID"] ?>"
                                            class="btn btn-danger" title="HAPUS">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                <script type="text/javascript"
                    src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
            </div>
        </main>
        <?php include("bagiankode/footer.php"); ?>
    </div>
    <?php include("bagiankode/jsscript.php"); ?>
</body>

</html>