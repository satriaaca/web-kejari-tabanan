<!-- pilih template -->
<?= $this->extend('template/admin/layout') ?>

<!-- judul halaman -->
<?= $this->section('title') ?>
Slidee
<?= $this->endSection() ?>

<!-- isi halaman -->
<?= $this->section('content') ?>
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading text-dark fw-bold fs-3 justify-content-center my-0">
                    Data Slider
                </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Dashboards</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title fw-bolder">
                        Slider
                    </div>
                    <div class="card-toolbar">
                        <button class="btn btn-primary btn-sm" id="addUsaha">Tambah data</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-dashed gx-2 gy-4 align-middle">
                            <tr class="fw-bolder bg-light">
                                <th class="ps-5">No</th>
                                <th class="min-w-100px">Gambar</th>
                                <th class="min-w-200px">Title</th>
                                <th class="min-w-100px">Link</th>
                                <th  class="min-w-200px">Aksi</th>
                            </tr>
                            <?php 
                                        $i = 1; 
                                        foreach($slide as $key => $value){ 
                                        ?>
                            <tr>
                                <td class="ps-5"><?=$i?></td>
                                <td>
                                    <img src="<?=base_url('uploads/'.$value['gambar'])?>" alt=""
                                        class="w-100px rounded">
                                </td>
                                <td>
                                    <span class="fw-bold"><?=$value['title']?></span> <br>
                                    <span class="small"><?=$value['subtitle']?></span>
                                </td>
                                <td><?=$value['link']?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-id="<?=$value['id']?>"
                                        id="ubahData">Edit</button>
                                    <button class="btn btn-sm btn-warning" data-id="<?=$value['id']?>"
                                        id="hapusUsaha">Hapus</button>
                                </td>
                            </tr>
                            <?php 
                                    $i++;
                                    } ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>

<div class="modal fade" id="modal_data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Slider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_data" method="POST" enctype="multipart/form-data" data-id="new">
            <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="p-2 border border-warning bg-light-warning mb-5 fs-4 rounded">
                        <ol>
                            <li><span class="fw-bolder">Informasi!</span> Untuk hasil yang sempurna, unggah gambar dengan rasio <b class="fw-bolder">1:1</b></li>
                            <li><span class="fw-bolder">Kosongi bagian Judul</span> jika Anda ingin menampilkan gambar secara <b>penuh</b> (rekomendasi : 1600 x 900)</li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 text-center">
                            <img src="#" id="preview" class="w-100" alt="">
                            <button type="button" class="btn btn-primary btn-sm mt-10" id="ubahGambar">Ubah gambar</button>
                        </div>
                        <div class="col-lg-9">
                        <div class="mb-3">
                        <label for="nama_usaha" class="form-label">Gambar (jpg/png)</label>
                        <input type="file" class="form-control" id="gambar" name="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="nama_usaha" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="nama_usaha" class="form-label">Subtitle</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle">
                    </div>
                    <div class="mb-3">
                        <label for="nama_usaha" class="form-label">Link</label>
                        <input type="text" class="form-control" id="link" name="link">
                    </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!--tambah file js / script-->
<?= $this->section('scripts') ?>

<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>

<script>
let editor; // Global instance

// 1. Initialize CKEditor 5 Super Build
function initCKEditor() {
    const element = document.querySelector('#isi');
    if (!element) return; // Prevent error if textarea doesn't exist

    CKEDITOR.ClassicEditor
        .create(element, {
            toolbar: {
                items: [
                    'heading', '|', 'alignment', '|',
                    'bold', 'italic', 'strikethrough', 'underline', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'imageUpload', 'blockQuote', 'insertTable', 'undo', 'redo'
                ],
                shouldNotGroupWhenFull: true
            },
            alignment: { options: ['left', 'center', 'right', 'justify'] },
            image: {
                toolbar: [
                    'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                    'toggleImageCaption', 'imageTextAlternative', '|', 'resizeImage'
                ]
            },
            ckfinder: {
                uploadUrl: '<?= site_url('api/berita/uploadImage') ?>'
            }
        })
        .then(instance => {
            editor = instance;
        })
        .catch(error => { console.error(error); });
}

$(document).ready(function() {
    initCKEditor();

    // 2. Submit Form (Save/Update)
    $(document).on('submit', '#form_data', function(e) {
        e.preventDefault();
        
        // SYNC CKEDITOR: Important for AJAX
        if (editor) {
            $('#isi').val(editor.getData());
        }

        const id = $(this).attr('data-id');
        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "<?=site_url('api/slider/save/');?>" + id,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success('Data berhasil disimpan');
                $('#modal_data').modal('hide');
                location.reload(); 
            },
            error: function(xhr) {
                const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan';
                alert(msg);
            }
        });
    });

    // 3. Add New Data
    $(document).on('click', '#addUsaha', function(e) {
        e.preventDefault();
        $('#form_data').trigger('reset');
        $('#form_data').attr('data-id', 'new');
        
        // Safety check for preview element
        const preview = document.getElementById('preview');
        if (preview) {
            preview.src = "<?= base_url('assets/media/svg/avatars/blank.svg') ?>";
        }
        
        if (editor) editor.setData(''); // Clear editor
        
        $('#gambar').prop('disabled', false); 
        $('#ubahGambar').hide();
        $('#modal_data').modal('show');
    });

    // 4. Edit Data
    $(document).on('click', '#ubahData', function(e) {
        e.preventDefault();
        const id = $(this).attr('data-id');
        $('#form_data').attr('data-id', id);

        $.getJSON("<?= site_url('api/slider/get/') ?>" + id, function(response) {
            $('#title').val(response.title);
            $('#subtitle').val(response.subtitle);
            $('#link').val(response.link);
            
            // Fill CKEditor if field exists in response
            if (editor && response.isi) {
                editor.setData(response.isi);
            }

            const preview = document.getElementById('preview');
            if (preview && response.gambar) {
                preview.src = "<?= base_url('uploads/') ?>" + response.gambar;
                $('#gambar').prop('disabled', true); 
                $('#ubahGambar').show();
            } else if (preview) {
                preview.src = "<?= base_url('assets/media/svg/avatars/blank.svg') ?>";
                $('#gambar').prop('disabled', false); 
            }
            
            $('#modal_data').modal('show');
        });
    });

    // 5. Delete Data
    $(document).on('click', '#hapusUsaha', function(e) {
        e.preventDefault();
        const id = $(this).attr('data-id');
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                type: 'POST',
                url: "<?=site_url('api/slider/delete/')?>" + id,
                data: { _method: 'DELETE' }, // standard CI4 spoofing
                success: function(response) {
                    location.reload();
                }
            });
        }
    });

    $(document).on('click', '#ubahGambar', function() {
        $('#gambar').prop('disabled', false).click(); 
    });
});
</script>

<?= $this->endSection() ?>