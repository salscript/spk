<?php $this->load->view('spk/admin/template/meta'); ?>
<div class="wrapper">
    <?php $this->load->view('spk/admin/template/header'); ?>
    <?php $this->load->view('spk/admin/template/sidebar'); ?>
        <script src="<?= base_url() ?>assets/back/plugins/jquery/jquery.min.js"></script>

    <?php echo $contents; ?>
    <!-- <?php $this->load->view('spk/admin/template/footer'); ?> -->
     
</div>
<?php $this->load->view('spk/admin/template/script'); ?>