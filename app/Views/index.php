<?= $this->extend('template/publik/layout') ?>

<!-- judul halaman -->
<?= $this->section('title') ?>
Beranda
<?= $this->endSection() ?>
<style>
.carousel-cell .img-full {
    width: 100%;
    /* Lebar penuh dari viewport */
    height: 500px;
    /* Atur tinggi sesuai kebutuhan */
    object-fit: contain;
    /* Agar gambar tidak terdistorsi */
}
.modal-backdrop { z-index: 1040 !important; }
#autoModal { z-index: 1050 !important; }
</style>
<!-- isi halaman -->
<?= $this->section('content') ?>
<?php 
    $featuredAgent = null;
    foreach ($agen as $a) {
        if ($a['id'] == 3) {
            $featuredAgent = $a;
            break;
        }
    }
?>

<!-- Modal -->
<?php if ($featuredAgent): ?>
<div class="modal fade" id="autoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-header border-0 p-0">
                <button type="button" class="btn-close btn-close-white ms-auto mb-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center">
                <img src="<?= base_url('uploads/' . $featuredAgent['foto']) ?>" 
                     class="img-fluid rounded shadow-lg" 
                     alt="Pop-up Image">
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- Modal -->
<div class="shadow bg-primary">
    <!--begin::Container-->
    <div class="p-0">
        <div class="main-carousel align-items-center justify-content-center ">
            <?php foreach($slider as $key => $value){
                if($value['title'] == ''){ ?>
            <div class=" carousel-cell w-100" style="height: 500px">
                <img class="img-full rounded" src="<?=base_url('uploads/'.$value['gambar'])?>"
                    style="width: 100%; height: 500px; object-fit: fit;" alt="">
                    <h3 class="fs-5 text-center text-white fw-bold my-5"><?=$value['subtitle']?></h3>
            </div>

            <?php } else { ?>
            <div class="carousel-cell p-10 align-items-center justify-content-center m-auto">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 align-items-center justify-content-center">
                        <div style="margin: auto;">
                            <h3 class="fs-3hx text-white fw-bold mb-5 font-bebas"><?=$value['title']?></h3>
                            <div class="fs-5 text-white fw-bold hover-text" data-text="<?=$value['subtitle']?>">
                                <?=$value['subtitle']?>
                            </div>
                            <a href="<?=$value['link']?>" class="btn btn-lg mt-10 btn-warning">Selengkapnya</a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center d-lg-block d-xl-block d-none ">
                        <img src="<?=base_url('uploads/'.$value['gambar'])?>" width="80%" alt="">
                    </div>
                </div>
            </div>
            <?php }
                ?>

            <?php }?>
        </div>


    </div>

</div>
<!--end::Container-->
</div>


<style>
.parent-hover:hover {
    background-color: #118B50;
    color: white !important;
}

.parent-hover:hover .parent-hover-primary {
    color: white !important;
}
</style>

<div class="p-0 mb-5">
    <div class="">
        <h3 class="text-center font-bebas fs-1 mt-10">LAYANAN <span class="text-primary">PUBLIK</span></h3>
        <div class="row pb-3 sum-container d-flex justify-content-center p-3">
            <?php foreach($layanan as $key => $value){ ?>
            <div class="col-md-3 col-sm-2 p-2 ">
                <a href="<?=$value['link']?>" target="_blank"
                    class="card h-100 hover-elevate-up shadow-sm parent-hover">
                    <div class="card-body d-flex align-items">
                        <span>
                            <i class="bi text-primary parent-hover-primary bi-arrow-up-left-circle-fill fs-4hx"></i>
                        </span>

                        <span class="ms-3 text-primary parent-hover-primary fs-4 fw-bold">
                            <?=$value['title']?>
                            <br>
                            <span
                                class="small text-gray-700 parent-hover-primary fs-6 fw-bold"><?=limitString($value['subtitle'],50)?></span>
                        </span>

                    </div>
                </a>
            </div>

            <?php } ?>
        </div>
    </div>
</div>

<section class="my-5 container-fluid">
    <div class="card-group">
        <?php foreach($berita as $row){ ?>
        <div class="card news-data" style="border-radius: 0px">
            <img class="card-img-top" src="<?=base_url('uploads/'.$row['gambar'])?>" alt="image" style="height: 320px;">
            <div class="mask">
                <h3><small class="text-white"><?= viewDate($row['created_at']) ?></small> <span
                        class="badge badge-primary">
                        Berita </span></h3>
                <!-- <a href="http://localhost/web_pn/page/berita/bU9lNnN2a3cydmUxTGpjMlp6RER0Zz09">Penggeledahan dan Penyitaan pada 3 Tempat dalam Perkara Ekspor CPO Dilakukan oleh Tim Penyidik Kejaksaan</a> -->
                <a class="f-5"
                    href="<?=site_url('berita/detail/'.$row['slug'])?>"><?=limitString($row['judul'],90)?></a>

            </div>
        </div>
        <?php } ?>

    </div>
    <div class="mt-5">
        <div class="row">
        <div class="col-lg-4">
                <h3 class="font-bebas fs-1 mt-3">Siaran Pers <span class="text-primary">Kejaksaan Agung</span></h3>

                <div id="beritaKejagung">
                    Sedang mengambil data
                </div>

              
            </div>
            <div class="col-lg-4">
                <h3 class="font-bebas fs-1 mt-3">Berita</h3>

                <?php foreach($berita_2 as $row){ ?>
                <div class="fs-6  border-primary border-bottom-dashed p-3">
                    [<?=formatDate($row['created_at'])?>] <a href="<?=site_url('berita/detail/'.$row['slug'])?>"
                        target="_blank" class="text-primary fw-bold "><?=limitString($row['judul'],90)?></a>
                </div>
                <?php } ?>
            </div>
            
            <div class="col-lg-4">
                <h3 class="font-bebas fs-1 mt-3">Pengumuman</h3>

                <?php foreach($pengumuman as $row){ ?>
                <div class="fs-6  border-primary border-bottom-dashed p-3">
                    [<?=formatDate($row['created_at'])?>] <a href="<?=site_url('berita/detail/'.$row['slug'])?>"
                        target="_blank" class="text-primary fw-bold "><?=$row['judul']?></a>
                </div>
                <?php } ?>
            </div>

        </div>
    </div>

    <div class="row mb-10 mt-10">
        <div class="col-lg-6">
            <div class="card shadow min-h-200px">
                <div class="card-body p-5">

                    <h3 class="text-primary fs-1 font-bebas">Penerimaan SPDP</h3>
                    <table class="table table-striped table-row-bordered table-row-dashed gx-2 gy-2 align-middle">
                        <thead>
                            <tr>
                                <th>No SPDP</th>
                                <th>Tanggal SPDP</th>
                                <th>Penyidik</th>
                                <th>Nama Tersangka</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center fw-bold">Dalam Pengembangan</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow min-h-200px">
                <div class="card-body p-5">

                    <h3 class="text-primary fs-1 font-bebas">Penerimaan Berkas</h3>
                    <table class="table table-striped table-row-bordered table-row-dashed gx-2 gy-2 align-middle">
                        <thead>
                            <tr>
                                <th>No SPDP</th>
                                <th>Tanggal SPDP</th>
                                <th>Penyidik</th>
                                <th>Nama Tersangka</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center fw-bold">Dalam Pengembangan</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="bg-primary py-10 ">
    <!--begin::Container-->
    <div class="container ">
        <h3 class="text-white badge fs-1 badge-warning font-bebas">Informasi Cepat</h3>
        <div class="row">
            <?php foreach($page as $key => $value){?>
            <div class="col-lg-6 col-md-6 col-6 my-2">
                <div class="card card-flush h-100">
                    <div class="card-body p-0">

                        <div class="p-5">
                            <span
                                class="card-title text-primary fw-bolder py-1 font-bebas fs-2"><?= $value['judul'] ?></span>
                            <br>
                            <p><?= limitString($value['isi']) ?></p> <a href="<?= site_url('page/'.$value['slug']) ?>"
                                class="btn btn-primary btn-sm">Masuk</a>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!--end::Container-->
</div>

<section class="mt-10">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between flex-row mb-5">
                    <h3 class="text-primary fs-1 font-bebas">Informasi Publik</h3>
                    <a href="<?=site_url('dokumen')?>" class="btn btn-primary">Lihat lainnya</a>
                </div>

                <div class="row">
                    <?php foreach($dokumen as $row){?>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <?=limitString($row['judul'],50)?>

                                <p class="text-muted small">Diunggah pada <?=viewDate($row['created_at'])?></p>

                                <div class="separator separator-dashed my-2"></div>

                                <a href="<?=base_url('uploads/'.$row['file'])?>" target="_blank"
                                    class="badge badge-primary">Unduh</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <div class="my-5">
                    <img class="rounded"
                        src="<?= $setting !== null ? (($setting['gambar_survey'] != '') ? base_url('logo/'.$setting['gambar_survey']) : base_url('assets/media/svg/files/blank-image.svg') ) : base_url('assets/media/svg/files/blank-image.svg') ?>"
                        width="100%" alt="">
                </div>

                <div class="separator separator-dashed my-5"></div>

                <?php 
// Ambil video pertama
$firstVideo = $video[0];

// Sisa video (jika ada)
$remainingVideos = array_slice($video, 1);
?>
                <iframe class="rounded" width="100%" height="315"
                    src="https://www.youtube.com/embed/<?=$firstVideo['link']?>" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                </iframe>

                <div class="row">
                    <div class="col-lg-4 col-12">
                        <h5 class="text-primary fs-1 mt-5 font-bebas">GALERI VIDEO</h5>
                        <p>Dokumentasi video kegiatan, agenda, dan program yang telah dilakukan oleh
                            <?=$setting['nama_satker']?> dalam mendukung Zona Integritas menuju Wilayah Bebas Korupsi
                            (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM).</p>
                        <a href="<?=site_url('video')?>" class="btn btn-primary">Lihat lainnya</a>
                    </div>
                    <?php foreach ($remainingVideos as $key => $value): ?>
                    <div class="col-lg-4 col-6 d-flex justify-content-center align-items-center">
                        <iframe class="rounded" width="100%" height="150"
                            src="https://www.youtube.com/embed/<?=$value['link']?>" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                        </iframe>
                    </div>
                    <?php endforeach; ?>
                </div>


                <div class="text-center ">
                    <span class="fs-1  mt-10 font-bebas"><?=$setting !== null?  $setting['motto'] : ''; ?></span>
                </div>


                <style>
                .responsive-iframe {
                    width: 100%;
                    height: 400px;
                    /* Bisa disesuaikan dengan viewport */
                    border: none;
                }
                </style>

                <div class="row mt-5">
                    <div class="col-lg-6 col-md-6 col-6">

                    </div>
                    <div class="col-lg-6 col-md-6 col-6">

                    </div>
                </div>
            </div>
            <div class="col-lg-4 rounded p-4 border border-gray-300" style="background-color: #F8FAFC">
                <h3 class="text-primary fs-1 font-bebas">Pencarian</h3>
                <input type="text" class="form-control mb-5" placeholder="Masukkan kata kunci">


                <div class="rounded border border-1 border-primary mb-3">
                    <div class="rounded-top px-3 py-1 bg-primary text-white text-center fs-3 font-bebas">Jam Kerja</div>
                    <div class="p-0">

                        <table class="table table-row-bordered  table-striped  gy-1 fs-6 bg-white">
                            <thead>
                                <tr class="bg-warning">
                                    <th class="text-center fw-bold">Hari</th>
                                    <th class="text-center fw-bold">Buka</th>
                                    <th class="text-center fw-bold">Istirahat</th>
                                    <th class="text-center fw-bold">Tutup</th>
                                </tr>
                            </thead>
                            <tr>
                                <td class="fw-bold p-2 ">Senin <br>s/d Jumat
                                </td>
                                <td class="text-end text-primary fw-bolder p-2">08.00</td>
                                <td class="text-end text-primary fw-bolder p-2">12.00-13.00</td>
                                <td class="text-end text-primary fw-bolder p-2">16.00</td>
                            </tr>
                            <tr>
                                <td class="fw-bold p-2 ">Jumat
                                </td>
                                <td class="text-end text-primary fw-bolder p-2">08.00</td>
                                <td class="text-end text-primary fw-bolder p-2">11.30-13.00</td>
                                <td class="text-end text-primary fw-bolder p-2">16.00</td>
                            </tr>

                        </table>
                    </div>
                </div>

                <h5 class="text-primary fs-1 font-bebas">INFOGRAFIS</h5>
                <section class="splide splide_role_model" aria-label="Basic Structure Example">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <?php foreach ($agen as $key => $value): ?>
                            <li class="splide__slide">
                                <img src="<?=base_url('uploads/'.$value['foto'])?>" width="100%" alt="">
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </section>

                <div class="separator separator-dashed my-2"></div>

                <h5 class="text-primary fs-1 font-bebas">HASIL SURVEY</h5>
                <section class="splide splide_survey" aria-label="Basic Structure Example">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide">
                                <img src="<?= $setting !== null ? (($setting['gambar_ikm'] != '') ? base_url('logo/'.$setting['gambar_ikm']) : base_url('assets/media/svg/files/blank-image.svg') ) : base_url('assets/media/svg/files/blank-image.svg') ?>"
                                    width="100%" alt="">
                            </li>
                            <li class="splide__slide">
                                <img src="<?= $setting !== null ? (($setting['gambar_ipak'] != '') ? base_url('logo/'.$setting['gambar_ipak']) : base_url('assets/media/svg/files/blank-image.svg') ) : base_url('assets/media/svg/files/blank-image.svg') ?>"
                                    width="100%" alt="">
                            </li>
                        </ul>
                    </div>
                </section>







            </div>
        </div>

    </div>
</section>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
<script src="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css
" rel="stylesheet">

<script>
$('.main-carousel').flickity({
    // options
    cellAlign: 'left',
    contain: true
});

new Splide('.splide_survey', {
    type: 'loop', // Slider loop (opsional)
    perPage: 1, // Tampilkan 1 item per halaman
    autoplay: true, // Slider otomatis berjalan
    interval: 3000, // Interval 3 detik
    arrows: true, // Panah navigasi
    pagination: true, // Pagination (bullets)
}).mount();

// Inisialisasi untuk slider role model
new Splide('.splide_role_model', {
    type: 'loop',
    perPage: 1,
    autoplay: true,
    interval: 3000,
    arrows: true,
    pagination: true,
}).mount();

$(document).ready(function() {
    // AJAX untuk mendapatkan data jadwal sidang
    $.ajax({
        url: '<?=site_url('dataBeritaKejagung')?>', // Endpoint ke controller
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            const container = $('#beritaKejagung');
            container.empty(); // Kosongkan container

            if (response.success && response.data.length > 0) {
                response.data.forEach((item, index) => {
                    const card = `
                           <div class="fs-6  border-primary border-bottom-dashed p-3">
                    [${item.date}] <a href="${item.link}"
                        target="_blank" class="text-primary fw-bold ">${item.title}</a>
                </div>`;
                    container.append(card);
                });
            } else {
                container.html('<div class="col-12 text-center"><p>Data tidak tersedia</p></div>');
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            $('#beritaKejagung').html(
                '<div class="col-12 text-center"><p>Gagal memuat data.</p></div>');
        }
    });

    if ($('#autoModal').length > 0) {
        $('#autoModal').modal('show');
    }
});
</script>

<?= $this->endSection() ?>