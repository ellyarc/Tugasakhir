<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link rel="stylesheet" href="/webdev/frontend/css/bootstrap.min.css">

</head>

<body>
    <!-- MEMBUAT MENU -->
    <?php
    include "includes/config.php";
    include "includes/frontmenu.php";
    $query = mysqli_query($conn, "select * from mahasiswa, pesertaskripsi where mahasiswa.mhs_NPM = pesertaskripsi.mhs_NPM");
    $pesertaskripsi = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $pesertaskripsi[] = $row;
    }
    $query2 = mysqli_query($conn, "SELECT
    m.mhs_NPM,
    m.mhs_Nama,
    d.dosen_Nama,
    u.ujian_TGL,
    u.ujian_JAM,
    u.ujian_FOTO
FROM ujianskripsi u
JOIN mahasiswa m ON u.mhs_NPM = m.mhs_NPM
JOIN bimbinganskripsi b ON b.mhs_NPM = m.mhs_NPM
JOIN dosen d ON d.dosen_NIDN = b.dosen_NIDN");

    $queryGaleri = mysqli_query($conn, "
    SELECT
        u.ujian_FOTO,
        p.peserta_JUDUL,
        m.mhs_NAMA
    FROM ujianskripsi u
    JOIN pesertaskripsi p ON u.mhs_NPM = p.mhs_NPM
    JOIN mahasiswa m ON p.mhs_NPM = m.mhs_NPM
");

    $galeriUjian = mysqli_fetch_all($queryGaleri, MYSQLI_ASSOC);



    $ujianskripsi = [];
    while ($row2 = mysqli_fetch_assoc($query2)) {
        $ujianskripsi[] = $row2;
    }

$queryKategori = mysqli_query($conn, "
SELECT
    kategori_ID,
    kategori_Nama,
    kategori_Metode,
    kategori_KET
FROM kategori
");
$kategori = [];
while ($rowKat = mysqli_fetch_assoc($queryKategori)) {
    $kategori[] = $rowKat;
}

$queryJurnal = mysqli_query($conn, "
SELECT
    jurnal_ID,
    jurnal_Nama,
    jurnal_ISSN,
    jurnal_SINTA,
    jurnal_URL
FROM jurnal
");
$jurnal = [];
while ($rowKat = mysqli_fetch_assoc($queryJurnal)) {
    $jurnal[] = $rowKat;
}

$querySkripsi = mysqli_query($conn, "
SELECT
    publikasi_ID,
    mhs_NPM,
    kategori_ID,
    jurnal_ID,
    publikasi_JUDUL,
    publikasi_DATE
FROM skripsi
");
$skripsi = [];
while ($rowKat = mysqli_fetch_assoc($querySkripsi)) {
    $skripsi[] = $rowKat;
}

    ?>
    <!-- PENUTUP MENU -->
    <!-- PEMBUKA SLIDER -->
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/img/untar.jpg" class="d-block w-100" alt="No Picture">
                <!-- TINGGAL GANTI NAMA PATH GAMBARNYA-->
                <div class="carousel-caption d-none d-md-block">
                    <h5>Gedung Utama UNTAR</h5>
                    <p>Kampus yang strategis di Kota Jakarta Barat</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/tspace.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/untarlg.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- PENUTUP SLIDER -->

    <!-- PEMBUKA HALAMAN WEB -->
    <div class="container">
        <div class="row atas mt-5">
            <div class="col-sm-8">
                <?php foreach ($pesertaskripsi as $d): ?>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <img src="/webdev/admin/images/<?= $d['peserta_DOKUMEN']; ?>" width="110" height="85" alt="">
                        </div>
                        <div class="flex-grow-1 ms-3" style="text-align: justify;">
                            <h2><?= $d['peserta_JUDUL']; ?></h2>
                            <p>
                                Skripsi dibuat oleh peserta dengan NIM: <?= $d['mhs_NPM']; ?>, pada semester
                                <?= $d['peserta_SMT']; ?>
                                dengan tahun akademik <?= $d['peserta_THAKD']; ?>, yang mendaftar pada
                                <?= $d['peserta_TGLDAFTAR']; ?>.
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>



            <!--ATAS SEBELAH KANAN  -->
            <div class="col-sm-4">
                <div class="list-group">
                    <?php foreach ($ujianskripsi as $d): ?>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">

                                <div>
                                    <strong><?= $d['mhs_NPM']; ?></strong><br>
                                    <?= $d['mhs_Nama']; ?><br>
                                    Pembimbing: <?= $d['dosen_Nama']; ?>
                                </div>

                                <div style="text-align: right;">
                                    <strong><?= date("d M Y", strtotime($d['ujian_TGL'])); ?></strong><br>
                                    Jam: <?= date("H:i", strtotime($d['ujian_JAM'])); ?>
                                </div>

                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- PENUTUP ATAS SEBELAH KANAN -->


        <!-- GALERI FOTO -->
        <h1 class="mt-15, mb-15" style="text-align: center">Galery Photo </h1>
        <div class="galerifoto row g-4">
            <?php foreach ($galeriUjian as $d): ?>
                <?php
                $foto = !empty($d['ujian_FOTO']) ? $d['ujian_FOTO'] : 'noimage.png';
                ?>
                <figure class="col-lg-4 col-sm-6 col-xs-12">
                    <img style="width: 220px; height: 220px; object-fit: cover;" src="/webdev/admin/images/<?= $foto; ?>"
                        class="figure-img img-fluid rounded" alt="FOTO UJIAN"> <!-- KASIH GAMBAR -->
                    <figcaption class="figure-caption"><?= $d['peserta_JUDUL']; ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div> <!-- PENUTUP GALERI FOTO -->

        <div class="row tengah mt-5">
            <div class="col-md-4">
                <?php foreach ($kategori as $d): ?>
                    <div class="mb-4">
                        <h2><?= $d['kategori_Nama']; ?></h2>
                        <p style="text-align: justify;">
                            Kategori ini memiliki id: <?= $d['kategori_ID']; ?>, dilakukan dengan metode
                            <?= $d['kategori_Metode']; ?> dan masuk keterangan <?= $d['kategori_KET']; ?>.
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="col-md-4">
                <?php foreach ($jurnal as $d): ?>
                    <div class="mb-4">
                        <h2><?= $d['jurnal_Nama']; ?></h2>
                        <p style="text-align: justify;">
                            Jurnal ini memiliki id: <?= $d['jurnal_ID']; ?>, serta ISSN:
                            <?= $d['jurnal_ISSN']; ?> dengan SINTA <?= $d['jurnal_SINTA']; ?> <?= $d['jurnal_URL']; ?>.
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-4">
                <?php foreach ($skripsi as $d): ?>
                <div class="mb-4">
                        <h2><?= $d['publikasi_JUDUL']; ?></h2>
                        <p style="text-align: justify;">
                            Publikasi ini memiliki id: <?= $d['publikasi_ID']; ?>, oleh mahasiswa:
                            <?= $d['mhs_NPM']; ?> , dengan jurnal ID <?= $d['jurnal_ID']; ?> Kategori <?= $d['kategori_ID']; ?>
                            dengan judul Publikasi <?= $d['publikasi_JUDUL']; ?> diterbitkan pada <?= $d['publikasi_DATE']; ?>.
                        </p>
                    </div>
                    <?php endforeach; ?>

            </div>
        </div> <!-- PENUTUP CLASS ROW TENGAH -->

        <div class="row bawah mt-5">
            <div class="col-sm-4">
                <div class="mb-3 row">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Home</li>
                        </ol>
                    </nav>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Library</li>
                        </ol>
                    </nav>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Library</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <div class="col-sm-8">
                <div class="spinner-grow text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-info" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-dark" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="card" style="width: 18rem;">
                            <img src="assets/img/untar.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of
                                    the
                                    card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <img src="images/fotoellya.jpg" width="100%" height="90%">
                        <h1>Ellya Edyawati</h1>
                        <p>825240002 SI A 24</p>
                    </div>
                </div> <!-- PENUTUP CLASS ROW -->
            </div> <!-- PENUTUP CLASS ROW BAWAH -->
        </div> <!-- PENUTUP CLASS CONTAINER -->
    </div><!-- PENUTUP HALAMAN WEB -->


</body>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>

</html>