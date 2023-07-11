    <style type="text/css">
        .navbar::before {
            border-image: none !important;
        }
    </style>
    <nav class="navbar navbar-expand-lg bg-body-tertiary rounded" aria-label="Thirteenth navbar example">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
                <a class="navbar-brand col-lg-3 me-0" href="<?= PROOT; ?>">VONNA.GH</a>
                <ul class="navbar-nav col-lg-6 justify-content-lg-center">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= PROOT; ?>account/index">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= PROOT; ?>account/index">Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= PROOT; ?>account/textbooks">Text Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= PROOT; ?>account/print-job">Print Job</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="<?= PROOT; ?>account/orders">Orders</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:;">|</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= PROOT; ?>account/settings">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= PROOT; ?>account/profile">Profile</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="<?= PROOT; ?>account/change-password">Change Password</a>
                    </li> -->
                </ul>
                <div class="d-lg-flex col-lg-3 justify-content-lg-end">
                    <a href="<?= PROOT; ?>auth/logout" class="btn btn-danger btn-sm">Logout</a>
                </div>
            </div>
        </div>
    </nav>