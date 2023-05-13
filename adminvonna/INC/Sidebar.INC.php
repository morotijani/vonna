    
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
            <span class="fs-4">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="<?= PROOT; ?>index" class="nav-link active" aria-current="page">
                    <i data-feather="globe"></i>
                    Visit Site
                </a>
            </li>
            <li>
                <a href="<?= PROOT; ?>adminvonna/index" class="nav-link link-body-emphasis">
                    <i data-feather="database"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="<?= PROOT; ?>adminvonna/Orders" class="nav-link link-body-emphasis">
                    <i data-feather="shopping-cart"></i>
                    Orders
                </a>
            </li>
            <!-- <li>
                <a href="<?= PROOT; ?>adminvonna/Products" class="nav-link link-body-emphasis">
                    <i data-feather="table"></i>
                    Products
                </a>
            </li> -->
            <li>
                <a href="<?= PROOT; ?>adminvonna/Customers" class="nav-link link-body-emphasis">
                    <i data-feather="users"></i>
                    Customers
                </a>
            </li>
            <li>
                <a href="<?= PROOT; ?>adminvonna/Contacts" class="nav-link link-body-emphasis">
                    <i data-feather="mail"></i>
                    Contacts
                </a>
            </li>
            <li>
                <a href="<?= PROOT; ?>adminvonna/Site" class="nav-link link-body-emphasis">
                    <i data-feather="settings"></i>
                    Site Settings
                </a>
            </li>
            <li>
                <a href="<?= PROOT; ?>adminvonna/Faq" class="nav-link link-body-emphasis">
                    <i data-feather="help-circle"></i>
                    FAQ
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= PROOT; ?>assets/media/admin_pic.svg" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>Hi <?= $admin_data['first']; ?>!</strong>
            </a>
            <ul class="dropdown-menu text-small shadow">
                <li><a class="dropdown-item" href="<?= PROOT ?>adminvonna/settings">Settings</a></li>
                <li><a class="dropdown-item" href="<?= PROOT ?>adminvonna/profile">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?= PROOT; ?>adminvonna/logout">Sign out</a></li>
            </ul>
        </div>
    </div>