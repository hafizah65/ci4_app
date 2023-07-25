<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <!-- <a class="nav-link active" aria-current="page" href="/">Home</a> -->
                <a class="nav-link active" aria-current="page" href="<?= base_url('/') ?>">Home</a>
                <!-- base_url is used when server by xampp -->
                <a class="nav-link" href="/about">About</a>
                <a class="nav-link" href="<?= base_url("/user") ?>">Pengguna</a>
                <a class="nav-link" href="<?= base_url("/komik") ?>">Komik</a>
            </div>
        </div>
    </div>
</nav>
