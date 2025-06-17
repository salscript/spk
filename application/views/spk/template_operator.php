<?php $this->load->view('spk/operator/template/meta'); ?>
<div class="wrapper">
    <?php $this->load->view('spk/operator/template/header'); ?>
    <?php $this->load->view('spk/operator/template/sidebar'); ?>
        <script src="<?= base_url() ?>assets/back/plugins/jquery/jquery.min.js"></script>

    <?php echo $contents; ?>
    <!-- <?php $this->load->view('spk/operator/template/footer'); ?> -->
     
</div>
<?php $this->load->view('spk/operator/template/script'); ?>