    <!-- NAVBAR -->
    <style type="text/css">
        .navbar::before {
            display: none;
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light <?= $nav_bg; ?>">
        <div class="container-lg">
            <a class="navbar-brand d-lg-none" href="<?= PROOT; ?>index">Vonna</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
                <!-- Navigation -->
                <ul class="navbar-nav justify-content-end w-100">
                    <li class="nav-item">
                        <a class="nav-link" id="" href="<?= PROOT; ?>about">
                            About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="" href="<?= PROOT; ?>products">
                            Products
                        </a>
                    </li>
                </ul>
            
                <!-- Brand -->
                <a class="navbar-brand d-none d-lg-block px-lg-6" href="<?= PROOT; ?>index">Vonna</a>
            
                <!-- Navigation -->
                <ul class="navbar-nav justify-content-start w-100">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="accountDropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <?= (user_is_logged_in() ? 'Hi ' . $user_data['first'] . '!' : 'Account'); ?>
                        </a>
                        <div class="dropdown-positioner">
                            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                <?php if (user_is_logged_in()): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="" href="<?= PROOT; ?>account/index">
                                            Make an order
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="" href="<?= PROOT; ?>account/profile">
                                            Profile
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="" href="<?= PROOT; ?>auth/logout">
                                            Logout
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="" href="<?= PROOT; ?>auth/signin">
                                            Sign In
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="" href="<?= PROOT; ?>auth/signup">
                                            Sign Up
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="" href="<?= PROOT; ?>auth/forgot-password">
                                            Forgot Password
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="" href="<?= PROOT; ?>contact">
                            Contact
                        </a>
                    </li>
                </ul>    
            </div>
        </div>
    </nav>