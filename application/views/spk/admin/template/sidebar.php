<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="font-family: 'Poppins', sans-serif;">

    <!-- Brand Logo -->
    <a href="<?= base_url('dashboard/admin') ?>" class="brand-link d-flex align-items-center" style="background-color: #fff; border-bottom: 1px solid #ccc;">
      <img src="<?= base_url('assets/back/dist/img/technolife.webp') ?>" 
     alt="Technolife Logo" 
     style="height: 55px; width: auto; margin-left: 10px; object-fit: contain;">
        <span class="brand-text font-weight-bold ml-2 text-dark">PT. Technolife</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets/back/uploads/avatar/' . ($this->session->avatar ?? 'user2-160x160.jpg')) ?>" 
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $this->session->fullname ?? 'Super Admin'; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?= base_url('dashboard/admin') ?>" class="nav-link <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Data Karyawan -->
                <li class="nav-item has-treeview <?= in_array($this->uri->segment(1), ['user', 'division', 'position']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Karyawan<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('user/user') ?>" class="nav-link <?= ($this->uri->segment(1) == 'user') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('division/division') ?>" class="nav-link <?= ($this->uri->segment(1) == 'division') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Division</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('position/position') ?>" class="nav-link <?= ($this->uri->segment(1) == 'position') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Position</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Questioner -->
                <li class="nav-item has-treeview <?= in_array($this->uri->segment(1), ['question', 'questioner']) ? 'menu-open' : '' ?>" id="questioner-menu">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Questioner <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('questioner/questioner') ?>" class="nav-link <?= ($this->uri->segment(1) == 'questioner') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form Questioner</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('question/question') ?>" class="nav-link <?= ($this->uri->segment(1) == 'question') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Question</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Data Kriteria -->
                <li class="nav-item has-treeview <?= in_array($this->uri->segment(1), ['aspect', 'criteria', 'subkriteria', 'factor']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-id-card"></i>
                        <p>Data Kriteria <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('aspect/aspect') ?>" class="nav-link <?= ($this->uri->segment(1) == 'aspect') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Aspect</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('criteria/criteria') ?>" class="nav-link <?= ($this->uri->segment(1) == 'criteria') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Criteria</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('subkriteria/subkriteria') ?>" class="nav-link <?= ($this->uri->segment(1) == 'subkriteria') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sub Criteria</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('factor/factor') ?>" class="nav-link <?= ($this->uri->segment(1) == 'factor') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Factor</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Proses Penilaian -->
                <li class="nav-item">
                    <a href="<?= base_url('penilaian') ?>" class="nav-link <?= ($this->uri->segment(1) == 'penilaian') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Proses Penilaian</p>
                    </a>
                </li>

                <!-- Perhitungan Bonus -->
                <li class="nav-item">
                    <a href="<?= base_url('perhitungan/select') ?>" class="nav-link <?= ($this->uri->segment(2) == 'select') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>Perhitungan Bonus</p>
                    </a>
                </li>

                <!-- Laporan Bonus -->
                <li class="nav-item">
                    <a href="<?= base_url('perhitungan/result') ?>" class="nav-link <?= ($this->uri->segment(2) == 'result') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Laporan Bonus</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
