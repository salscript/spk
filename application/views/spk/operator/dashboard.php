        <div class="content-wrapper">
            <small>
                <script type='text/javascript'>
                    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                    var date = new Date();
                    var day = date.getDate();
                    var month = date.getMonth();
                    var thisDay = date.getDay(),
                        thisDay = myDays[thisDay];
                    var yy = date.getYear();
                    var year = (yy < 1000) ? yy + 1900 : yy;
                    // document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
                </script>
            </small>
            <div class="content-header">
                <?php
                date_default_timezone_set('Asia/Jakarta');
                $jam = date("H:i");

                // atur salam dengan IF
                if ($jam > '05:30' && $jam < '10:00') {
                    $salam = 'Pagi';
                } elseif ($jam >= '10:00' && $jam < '15:00') {
                    $salam = 'Siang';
                } elseif ($jam < '18:00') {
                    $salam = 'Sore';
                } else {
                    $salam = 'Malam';
                }
                ?>
                <div class="container-fluid">
                    <div class="row mb-3 mt-3">
                        <div class="col-sm-6">
                            <h3 class="m-0 font-weight-bolder">Dashboard </h3>
                        </div>
                        <div class="col-sm-6">

                        </div>
                    </div>
                    <div class="alert alert-secondary" style="color: #383d41; background-color: #e2e3e5; border-color: #d6d8db;">
                        Selamat <?= $salam; ?>, Selamat Datang <b><?= $this->session->fullname; ?></b> di Administrator SPK Penetapan Persentase Bonus
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?=$questioner?></h3>

                                <p>Questioner</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="<?= base_url('questioner/questioner') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?=$penilaian?></h3>

                                <p>Penilaian</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="<?= base_url('penilaian') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                </div>
            </div>

            <section class="content">
                <!-- <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">

                                    <p>Menunggu Respon</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clock"></i>
                                </div>
                                <a href="<?php echo base_url('helpdesk/ticket/admin') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">

                                    <p>Proses Pengerjaan</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="<?php echo base_url('helpdesk/ticket/admin') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">

                                    <p>Ticket Sukses</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="<?php echo base_url('helpdesk/ticket/admin') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= $user ?></h3>

                                    <p>Users</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person"></i>
                                </div>
                                <a href="<?php echo base_url('helpdesk/user/user') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div> -->
            </section>
        </div>