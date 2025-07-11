<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
   <a href="<?= base_url('dashboard/admin') ?>" class="brand-link" style="background-color: #ffffff; border-bottom: 1px solid #ccc;">
      <img src="<?= base_url('assets/back/dist/img/technolife.webp') ?>" alt="AdminLTE Logo" class="brand-image" style="opacity: .8;">
      <span class="brand-text font-weight-bold ml-1 text-dark">PT. Technolife</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url('assets/back') ?><?= $this->session->avatar; ?>?>assets/back/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $this->session->fullname; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url('dashboard/operator') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'dashboard') echo 'active' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('questioner/questioner') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'questioner') echo 'active' ?>">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Questioner</p>
                            </a>
                        </li>
                <li class="nav-item">
                    <a href="<?= base_url('penilaian') ?>" class="nav-link <?= ($this->uri->segment(1) == 'penilaian') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Proses Penilaian</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('perhitungan/select') ?>" class="nav-link <?= $this->uri->segment(2) == 'select' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>Perhitungan Bonus</p>
                    </a>
                </li>
                    <li class="nav-item">
                    <a href="<?= base_url('perhitungan/result') ?>" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Laporan Bonus</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<script type="text/javascript">
    $(document).ready(function() {
        let pathname = window.location.pathname;
        // console.log(pathname);
        if (
            pathname.includes('question') ||
            pathname.includes('questioner')
        ) {
            $('#questioner-menu').addClass('menu-open');
            $('#questioner-menu').removeClass('menu');
        } else {
            $('#questioner-menu').removeClass('menu-open');
            $('#questioner-menu').addClass('menu');
        }
    })
</script>