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
                <img src="<?php echo base_url('assets/back') ?><?= $this->session->avatar; ?>" class="img-circle elevation-2" alt="User Image">
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
                    <a href="<?php echo base_url('dashboard/user') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'dashboard') echo 'active' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('questioner/questioner_user') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'questioner') echo 'active' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Questioner
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php if ($this->uri->segment(1) == 'result') echo 'active' ?>">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Result
                        </p>
                    </a>
                </li>
                <!-- <hr>
                <li class="nav-header">ADMINISTRATION</li>
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
                            <a href="#" class="nav-link <?php if ($this->uri->segment(1) == 'question') echo 'active' ?>">
                                <i class="far fa-question-circle nav-icon"></i>
                                <p>Question</p>
                            </a>
                        </li>
                    </ul> 

                </li> -->
            </ul>
        </nav>
    </div>
</aside>
<script type="text/javascript">
    $(document).ready(function() {
        let pathname = window.location.pathname;
        if (
            pathname.includes('question')
        ) {
            $('#questioner-menu').addClass('menu-open');
            $('#questioner-menu').removeClass('menu');
        } else {
            $('#questioner-menu').removeClass('menu-open');
            $('#questioner-menu').addClass('menu');
        }
    })
</script>