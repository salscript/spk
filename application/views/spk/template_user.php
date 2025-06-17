<?php $this->load->view('spk/user/template/meta'); ?>
<div class="wrapper">
    <?php $this->load->view('spk/user/template/header'); ?>
    <script src="<?= base_url() ?>assets/back/plugins/jquery/jquery.min.js"></script>
    <?php $this->load->view('spk/user/template/sidebar'); ?>

    <?php echo $contents; ?>
    <!-- <?php $this->load->view('spk/user/template/footer'); ?> -->
</div>
<?php $this->load->view('spk/user/template/script'); ?>