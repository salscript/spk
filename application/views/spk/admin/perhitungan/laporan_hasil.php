<div class="content-wrapper">

    <style>
        body {
            background-color: #f0f0f0;
        }

        #a4-page {
            width: 794px;
            min-height: 1123px;
            background: white;
            margin: 20px auto;
            padding: 40px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .ttd-print {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
            text-align: center;
        }

        .ttd-print > div {
            width: 45%;
        }

        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
            }

            #a4-page {
                box-shadow: none;
                width: 100%;
                min-height: auto;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            hr {
                border: 1px solid black;
                margin: 10px 0;
            }

            .mt-n5 {
                margin-top: -3rem !important;
            }
        }
    </style>

    <section class="content-header">
        <div class="container-fluid">
            <h4 class="font-weight-bold">Laporan Penentuan Bonus Karyawan</h4>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- Filter Form -->
           <div class="card card-outline card-primary no-print">
    <div class="card-body">
        <form method="GET" action="<?= base_url('perhitungan/laporan_hasil') ?>">
            <div class="form-row align-items-center">
                <!-- Pilih Tanggal -->
                <div class="col-md-4">
                    <label><strong>Pilih Periode</strong></label>
                    <select name="tanggal" class="form-control" onchange="this.form.submit()" required>
                        <option value="">-- Pilih Tanggal --</option>
                        <?php foreach ($tanggal_list as $t): ?>
                            <option value="<?= $t->tanggal ?>" <?= ($tanggal == $t->tanggal) ? 'selected' : '' ?>>
                                <?= date('d M Y', strtotime($t->tanggal)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tombol Print -->
                <div class="col-md-2 mt-4">
                    <button type="button" class="btn btn-success btn-block" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>

                <!-- Tombol Back -->
                <div class="col-md-2 mt-4">
                    <button type="button" class="btn btn-primary btn-block" onclick="back()">Back</button>
                </div>

                <!-- Tombol Reload -->
                <div class="col-md-1 mt-4">
                    <button type="button" class="btn btn-outline-primary btn-block" onclick="reload()">
                        <i class="fas fa-sync"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

            <!-- Isi Laporan -->
            <?php if ($tanggal && !empty($hasil)): ?>
            <div id="a4-page">
                <div class="mb-4 position-relative">
                    <div class="row">
                        <!-- Logo -->
                        <div class="col-2 text-left">
                            <img src="<?= base_url('assets/back/dist/img/technolife.webp') ?>" alt="Logo" style="width: 80px;">
                        </div>
                        <!-- Spacer -->
                        <div class="col-10"></div>
                    </div>

                    <!-- Teks instansi -->
                    <div class="text-center mt-n5">
                        <h5 class="font-weight-bold text-uppercase mb-0">PT. TECHNOLIFE KREASI INDUSTRI UTAMA</h5>
                        <p class="mb-0" style="font-size: 12px;">
                            Alamat: Jl. Ir Soekarno No.4, RW.6, Cibeusi, Kec. Jatinangor, Kabupaten Sumedang, Jawa Barat 45363
                        </p>
                    </div>

                    <hr class="my-3">

                    <!-- Judul Laporan -->
                    <div class="text-center">
                        <h5 class="font-weight-bold text-uppercase"><u>LAPORAN PENENTUAN BONUS KARYAWAN</u></h5>
                        <p>Periode: <?= date('d M Y', strtotime($tanggal)) ?></p>
                    </div>
                </div>

                <!-- Tabel hasil -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Nilai Akhir</th>
                                <th>Ranking</th>
                                <th>Persentase Bonus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($hasil as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-left"><?= $row->fullname ?></td>
                                    <td><?= $row->nilai_akhir ?></td>
                                    <td><?= $row->ranking ?></td>
                                    <td><strong><?= $row->persentase_bonus ?>%</strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tanda Tangan -->
                <div class="ttd-print">
                    <div>
                        Mengetahui,<br><strong>HRD</strong><br><br><br><br>
                        (................................)
                    </div>
                    <div>
                        Mengetahui,<br><strong>Keuangan</strong><br><br><br><br>
                        (................................)
                    </div>
                </div>
            </div>
            <?php elseif ($tanggal): ?>
                <div class="alert alert-warning">Tidak ada hasil perhitungan untuk tanggal ini.</div>
            <?php endif; ?>
        </div>
    </section>
</div>
<script>
    function back() {
        window.history.back();
    }

    function reload() {
        location.reload();
    }
</script>

