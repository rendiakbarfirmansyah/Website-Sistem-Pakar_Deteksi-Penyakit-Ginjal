<?php 
include 'function.php';
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 0) {
        header("location: indexAdmin.php");
    } else if ($_SESSION['role'] == 2) {
        header("location: indexPakar.php");
    }
} else {
    header("location:index.php");
}

$gejala = mysqli_query($koneksi, "SELECT * FROM gejala");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
    crossorigin="anonymous"/>
    <link
    href="https://fonts.googleapis.com/css?family=Poppins:300,400,700&display=swap"
    rel="stylesheet"/>
    <link rel="stylesheet" href="custom.css" />
    <title>Cek Ginjal Yuk!</title>
</head>
<body>
    <nav class="navbar py-2 navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#"
            ><img src="gambar/logo_ginjal.png" width="147" alt="logo"
            /></a>
            <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
            >
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li>
                        <a class="btn px-2 py-2 btn-success ml-2" href="function.php?act=ulang" role="button">Cek Ulang</a>
                    </li>
                    <li>
                        <a class="btn px-2 py-2 btn-primary ml-2" href="logout.php" role="button"
                    >Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hasil mt-4">
        <div class="container">
            <div class="row">
                <div class="col align-self-center">
                    <h3 class="mb-4">Penyakit yang anda alami adalah: </h3>
                    <?php
                        // Fungsi untuk menentukan diagnosis tertinggi
                        function maximum($a, $b, $c, $d, $e, $f) {
                            $max = $a;
                            $kode = 1; 
                            if ($b > $max) { 
                                $max = $b;
                                $kode = 2;
                            } 
                            if ($c > $max) { 
                                $max = $c;
                                $kode = 3;
                            } 
                            if ($d > $max) { 
                                $max = $d;
                                $kode = 4;
                            } 
                            if ($e > $max) { 
                                $max = $e;
                                $kode = 5;
                            } 
                            if ($f > $max) { 
                                $max = $f;
                                $kode = 6;
                            } 
                            return $kode;
                        }

                        // Mendapatkan ID penyakit dengan nilai tertinggi
                        $id_penyakit = maximum($_SESSION['ginjalAkut'], $_SESSION['ginjalKronis'], $_SESSION['batuGinjal'], $_SESSION['infeksiGinjal'], $_SESSION['kankerGinjal'], $_SESSION['gagalGinjal']);

                        // Menentukan nama penyakit berdasarkan ID
                        $penyakit = [
                            1 => "Gagal Ginjal Akut",
                            2 => "Gagal Ginjal Kronis",
                            3 => "Batu Ginjal",
                            4 => "Infeksi Ginjal",
                            5 => "Kanker Ginjal",
                            6 => "Gagal Ginjal"
                        ];

                        // Menampilkan nama penyakit
                        echo '<h4><strong>' . $penyakit[$id_penyakit] . '</strong></h4>';

                        // Query solusi dari tabel solusi berdasarkan ID penyakit
                        $query = "SELECT solusi FROM solusi WHERE id_penyakit = '$id_penyakit'";
                        $data = mysqli_query($koneksi, $query);
                    ?>
                    
                    <h3 class="mb-4 mt-5">Solusi untuk penyakit anda adalah: </h3>
                    <?php
                        // Menampilkan solusi
                        if ($data && mysqli_num_rows($data) > 0) {
                            while ($row = mysqli_fetch_assoc($data)) {
                                echo '<p>' . $row['solusi'] . '</p>';
                            }
                        } else {
                            echo '<p>Solusi untuk diagnosis ini belum tersedia.</p>';
                        }
                    ?>
                </div>
                <div class="col d-none d-sm-block">
                    <img width="500" src="gambar/hasil_cek.jpg" alt="hero" />
                </div>
            </div>
        </div>
    </section>
</body>

<script
    src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
    crossorigin="anonymous"
></script>
<script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"
></script>
<script
    src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"
></script>
<script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"
></script>
</html>