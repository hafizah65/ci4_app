<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3"><?= $title; ?></h2>
            <form action="<?= base_url($action) . ($komik ? $komik['id'] : ''); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="slug" value="<?= old('slug') ?: ($komik ? $komik['slug'] : ''); ?>">
                <input type="hidden" name="sampulLama" id="sampulLama" value="<?= old('slug') ?: ($komik ? $komik['sampul'] : ''); ?>">
                <div class="row mb-3">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= validation_errors('judul') ? 'is-invalid' : '' ?>" id="judul" name="judul" value="<?= old('judul') ?: ($komik ? $komik['judul'] : ''); ?>" autofocus>
                        <div class="invalid-feedback">
                            <?= validation_show_error('judul'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-10">
                        <input type="penulis" class="form-control <?= validation_errors('penulis') ? 'is-invalid' : '' ?>" id="penulis" name="penulis" value="<?= old('penulis') ?: ($komik ? $komik['penulis'] : ''); ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('penulis'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                    <div class="col-sm-10">
                        <input type="penerbit" class="form-control <?= validation_errors('penerbit') ? 'is-invalid' : '' ?>" id="penerbit" name="penerbit" value="<?= old('penerbit') ?: ($komik ? $komik['penerbit'] : ''); ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('penerbit'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penerbit" class="col-sm-2 col-form-label">Sampul</label>
                    <div class="col-sm-2"><img src="<?= old('sampul') ?: (base_url('/img/' . ($komik != null && $komik['sampul'] != null ? $komik['sampul'] : 'book.png'))); ?>" class="img-thumbnail img-preview"></div>
                    <div class="col-sm-8">
                        <input type="file" class="form-control <?= validation_errors('sampul') ? 'is-invalid' : '' ?>" aria-label="file example" id="sampul" name="sampul" onchange="preview()">
                        <div class="invalid-feedback"> <?= validation_show_error('sampul'); ?></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    function preview() {
        console.log('ff');
        const sampul = document.querySelector('#sampul');
        const imgPreview = document.querySelector('.img-preview');

        const fileSampul = new FileReader();
        fileSampul.readAsDataURL(sampul.files[0]);

        fileSampul.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>
<?= $this->endSection(); ?>
