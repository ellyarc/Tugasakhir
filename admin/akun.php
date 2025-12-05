<!DOCTYPE html>
<html lang="en">
<?php
include("bagiankode/head.php");
?>
<?php ob_start();
session_start();
if (!isset($_SESSION["useremail"]))
    header("location:login.php");
?>

<body class="sb-nav-fixed">
    <?php include("bagiankode/menunav.php"); ?>
    <?php include("bagiankode/menu.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Informasi</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Data Saya</li>
                </ol>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text" class="form-control" name="nama" value="Ellya Edyawati" readonly>
                    </inpu>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">NPM</label>
                        <input type="text" class="form-control" name="npm" value="825240002" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kelas</label>
                        <input type="text" class="form-control" name="kelas" value="SI A 2024" readonly>
                    </div>
                </div>
            </div>
        </main>
        <?php include("bagiankode/footer.php"); ?>
    </div>
    </div>
    <?php include("bagiankode/jsscript.php"); ?>
</body>

</html>