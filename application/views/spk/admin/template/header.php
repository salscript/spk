<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" id="userMenuDropdown" data-toggle="dropdown">
                <img src="<?php echo base_url('assets/back') ?><?= $this->session->avatar; ?>" class="user-image img-circle elevation-1" alt="User Image">
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="userMenuDropdown">
                <a href="#" class="dropdown-item text-sm">
                    <div class="media align-items-center">
                        <div class="avatar-wrapper2">
                            <img src="<?php echo base_url('assets/back') ?><?= $this->session->avatar; ?>" alt="User Avatar" class="img-size-32 img-circle">
                        </div>
                        <div class="media-body ml-3">
                            <h4 class="dropdown-item-title text-sm mb-0">
                                <?= $this->session->fullname; ?>
                            </h4>
                            <p class="text-sm text-muted mb-0"><?= $this->session->email; ?></p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('dashboard/admin') ?>" class="dropdown-item text-sm">
                    Dashboard
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('account/account_admin') ?>" class="dropdown-item text-sm">
                    Account Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('auth/logout') ?>" class="dropdown-item text-sm">
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<script type="text/javascript">
</script>