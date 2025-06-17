<?php $this->load->view('spk/operator/template/meta'); ?>
<div class="wrapper">
    <?php $this->load->view('spk/operator/template/header'); ?>
    <script src="<?= base_url() ?>assets/back/plugins/jquery/jquery.min.js"></script>
    <?php $this->load->view('spk/operator/template/sidebar'); ?>

    <?php echo $contents; ?>
    <!-- <?php $this->load->view('spk/operator/template/footer'); ?> -->
     
</div>
<?php $this->load->view('spk/operator/template/script'); ?>