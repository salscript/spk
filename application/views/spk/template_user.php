<?php $this->load->view('helpdesk/user/template/meta'); ?>
<div class="wrapper">
    <?php $this->load->view('helpdesk/user/template/header'); ?>
    <?php $this->load->view('helpdesk/user/template/sidebar'); ?>
    <script src="<?= base_url() ?>assets/back/plugins/jquery/jquery.min.js"></script>

    <?php echo $contents; ?>
    <!-- <?php $this->load->view('helpdesk/user/template/footer'); ?> -->
</div>
<?php $this->load->view('helpdesk/user/template/script'); ?>