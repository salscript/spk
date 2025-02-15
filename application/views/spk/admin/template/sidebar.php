<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <!-- <img src="<?= base_url() ?>assets/back/dist/img/insaba.png" alt="Helpdesk Logo" class="brand-image" style="opacity: 1"> -->
        <span class="brand-text font-weight-normal">SPK IT</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url() ?>assets/back/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
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
                <!-- <li class="nav-item">
                    <a href="<?php echo base_url('ticket/admin') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'ticket') echo 'active' ?>">
                        <i class="nav-icon fas fa-inbox"></i>
                        <p>
                            Tickets
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('report/report_admin') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'report') echo 'active' ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Report
                        </p>
                    </a>
                </li> -->
                <hr>
                <li class="nav-header">ADMINISTRATION</li>
                <li class="nav-item" id="questioner-menu">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Questioner
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('question/question') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'question') echo 'active' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Question</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Aspect</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Factor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Criteria</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sub Criteria</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="nav-item">
                    <a href="<?php echo base_url('subject/subject') ?>" class="nav-link">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            Subject
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('client/company') ?>" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Company
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('divisi/divisi') ?>" class="nav-link">
                        <i class="nav-icon fas fa-landmark"></i>
                        <p>
                            Divisi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('client/application') ?>" class="nav-link">
                        <i class="nav-icon fas fa-window-maximize"></i>
                        <p>
                            Application
                        </p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="<?php echo base_url('user/user') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'user') echo 'active' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('userRole/user_roles') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'userRole') echo 'active' ?>">
                        <i class="nav-icon far fa-id-card"></i>
                        <p>
                            User Roles
                        </p>
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