<?= $this->extend('template/publik/layout') ?>

<!-- judul halaman -->
<?= $this->section('title') ?>
Beranda
<?= $this->endSection() ?>

<!-- isi halaman -->
<?= $this->section('content') ?>
<div class="separator separator-dashed my-5"></div>


<section class="mt-10">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-primary font-bebas fs-1"><?= $berita['judul'] ?? '' ?></h3>
                <div style="margin-top:1.5rem;">
                    <?= $berita['isi'] ?? '' ?>
                </div>
            </div>
        </div>

    </div>
</section>



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

var splide = new Splide('.splide', {
    perPage: 6,
    //   rewind : true,
    type: 'loop',
    autoplay: 'start',
    breakpoints: {
        1024: { // Layar sedang, maksimal 1024px
            perPage: 5, // Tampilkan 5 item
        },
        768: { // Layar kecil, maksimal 768px
            perPage: 3, // Tampilkan 3 item
        }
    }
});

splide.mount();
</script>

<?= $this->endSection() ?>