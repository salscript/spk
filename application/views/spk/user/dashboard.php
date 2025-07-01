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
                        Selamat <?= $salam; ?>, Selamat Datang <b><?= $this->session->fullname; ?></b>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <img src="<?= base_url('assets/back/dist/img/technolife.webp') ?>" width="190px" style="display: block; margin-left: auto; margin-right: auto; margin-top: 75px; margin-bottom: 20px">

                    <h3 class="text-center">PT. Technolife Karya Industri Utama</h3>
                    <p class="text-center">Alamat : Jl. Ir Soekarno No.4, RW.6, Cibeusi, Kec. Jatinangor, Kabupaten Sumedang, Jawa Barat 45363</p>
                </div>
            </section>
        </div>