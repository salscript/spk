<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?= base_url() ?>assets/back/dist/img/technolife.webp" alt="Helpdesk Logo" class="brand-image" style="opacity: 1">
        <span class="brand-text font-weight-normal">SPK IT</span>
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
                <li class="nav-header">GENERAL</li>
                <li class="nav-item">
                    <a href="<?php echo base_url('dashboard/admin') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'dashboard') echo 'active' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                    <li class="nav-item">
           <a href="<?= base_url('perhitungan/laporan_hasil') ?>" class="nav-link">
    <i class="nav-icon fas fa-print"></i>
    <p>Laporan Bonus</p>
</a>

        </li>

            </li>
                <hr>
                <li class="nav-header">ADMINISTRATION</li>
                <li class="nav-item">
                    <a href="<?php echo base_url('user/user') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'user') echo 'active' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Data Karyawan
                        </p>
                    </a>
                </li>
                <li class="nav-item" id="questioner-menu">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Questioner
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('questioner/questioner') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'questioner') echo 'active' ?>">
                                <i class="far fa-question-circle nav-icon"></i>
                                <p>Form Questioner</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('question/question') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'question') echo 'active' ?>">
                                <i class="far fa-question-circle nav-icon"></i>
                                <p>Question</p>
                            </a>
                        </li>
                    </ul>
                    <li class="nav-item">
                    <a href="<?php echo base_url('aspect/aspect') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'aspect') echo 'active' ?>">
                        <i class="nav-icon far fa-id-card"></i>
                        <p>
                            Aspect
                        </p>
                    </a>
                </li>
                    <li class="nav-item">
                    <a href="<?php echo base_url('criteria/criteria') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'criteria') echo 'active' ?>">
                        <i class="nav-icon far fa-id-card"></i>
                        <p>
                            Criteria
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('subkriteria/subkriteria') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'subkriteria') echo 'active' ?>">
                        <i class="nav-icon far fa-id-card"></i>
                        <p>
                           Sub Criteria
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('division/division') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'division') echo 'active' ?>">
                        <i class="nav-icon far fa-id-card"></i>
                        <p>
                            Division
                        </p>
                    </a>
                </li>     
                <li class="nav-item">
                    <a href="<?php echo base_url('position/position') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'position') echo 'active' ?>">
                        <i class="nav-icon far fa-id-card"></i>
                        <p>
                            Position
                        </p>
                    </a>
                </li>    
                <li class="nav-item">
                    <a href="<?php echo base_url('factor/factor') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'factor') echo 'active' ?>">
                        <i class="nav-icon far fa-id-card"></i>
                        <p>
                            Factor
                        </p>
                    </a>
                </li>
              <li class="nav-item">
                            <a href="<?= base_url('penilaian') ?>" class="nav-link <?= ($this->uri->segment(1) == 'penilaian') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>Proses Penilaian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('perhitungan/select') ?>" 
                            class="nav-link <?= $this->uri->segment(2) == 'select' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-calculator"></i>
                                <p>Perhitungan Bonus</p>
                            </a>
                        </li>
            </ul>
                    </nav>
    </div>
</aside>
<script type="text/javascript">
    $(document).ready(function() {
        let pathname = window.location.pathname;
        if (
            pathname.includes('question') ||
            pathname.includes('aspect') ||
            pathname.includes('factor') ||
            pathname.includes('criteria') ||
            pathname.includes('subcriteria')
        ) {
            $('#questioner-menu').addClass('menu-open');
            $('#questioner-menu').removeClass('menu');
        } else {
            $('#questioner-menu').removeClass('menu-open');
            $('#questioner-menu').addClass('menu');
        }
    })
</script>