<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perhitungan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_perhitungan');
    }

    // Halaman pemilihan periode penilaian (berdasarkan tanggal input nilai aktual)
    public function select()
    {
        $data['title'] = 'Pilih Periode Perhitungan';
        $data['periodes'] = $this->M_perhitungan->get_periode_penilaian();
        $this->template->load('spk/template_admin', 'spk/admin/perhitungan/select_periode', $data);
    }

    // Halaman detail perhitungan berdasarkan nilai aktual
   public function detail()
{
    $tanggal = $this->input->get('tanggal');

    if (!$tanggal) {
        show_error('Tanggal input nilai belum dipilih.');
    }

    $data['title'] = 'Detail Perhitungan GAP & Nilai Akhir';
    $data['tanggal_input'] = $tanggal;
    $data['hasil_gap'] = $this->M_perhitungan->hitung_gap_by_tanggal($tanggal);
    $data['cf_sf_bobot'] = $this->M_perhitungan->hitung_cf_sf_berdasarkan_bobot_kriteria($tanggal);
    $data['list_aspek'] = $this->M_perhitungan->get_list_aspek($tanggal);
    $data['hasil_aspek'] = $this->M_perhitungan->hitung_nilai_aspek_by_tanggal($tanggal);

    // Tambahkan validasi apakah hasil sudah disimpan
   $data['is_hasil_sudah_disimpan'] = $this->db
    ->where('periode_input', $tanggal)
    ->count_all_results('hasil_profile_matching') > 0;


    $this->template->load('spk/template_admin', 'spk/admin/perhitungan/detail', $data);
}

    // Simpan hasil profile matching ke tabel hasil_profile_matching
 public function simpan_hasil()
{
    $tanggal = $this->input->post('tanggal_input');
    $this->load->model('M_perhitungan');

    $cek = $this->db->get_where('hasil_profile_matching', ['periode_input' => $tanggal])->num_rows();
    if ($cek > 0) {
        $this->session->set_flashdata('error', 'Hasil perhitungan untuk tanggal ini sudah disimpan sebelumnya.');
        redirect('perhitungan/select');
        return;
    }

    $hasil = $this->M_perhitungan->hitung_nilai_aspek_by_tanggal($tanggal);
    if (empty($hasil)) {
        $this->session->set_flashdata('error', 'Tidak ada data perhitungan yang ditemukan.');
        redirect('perhitungan/select');
        return;
    }

    $total_nilai_akhir = array_sum(array_column($hasil, 'total_nilai'));

    $data = [];
    foreach ($hasil as $row) {
        $persentase_bonus = ($total_nilai_akhir > 0)
            ? round(($row['total_nilai'] / $total_nilai_akhir) * 100, 2)
            : 0;

        $data[] = [
            'employee_id'        => $row['employee_id'],
            'periode_input'      => $tanggal,
            'nilai_akhir'        => $row['total_nilai'],
            'ranking'            => $row['ranking'],
            'persentase_bonus'   => $persentase_bonus,
            'tanggal_perhitungan'=> date('Y-m-d')
        ];
    }

    $this->db->insert_batch('hasil_profile_matching', $data);

    $this->session->set_flashdata('success', 'Hasil perhitungan berhasil disimpan.');
    redirect('perhitungan/select');
}

public function get_tanggal_hasil()
{
    return $this->db->select('DISTINCT(tanggal_perhitungan) as tanggal')
                    ->order_by('tanggal_perhitungan', 'DESC')
                    ->get('hasil_profile_matching')
                    ->result();
}



    // Tampilkan hasil perhitungan yang sudah disimpan sebelumnya
  public function hasil()
{
    $tanggal = $this->input->get('tanggal');
    $data['title'] = 'Hasil Perhitungan Profile Matching';
    $data['tanggal'] = $tanggal;

    $data['tanggal_list'] = $this->M_perhitungan->get_tanggal_hasil();

    $data['hasil'] = [];
    if ($tanggal) {
        $data['hasil'] = $this->db->select('h.*, e.fullname')
            ->from('hasil_profile_matching h')
            ->join('employee e', 'e.id = h.employee_id')
            ->where('DATE(h.tanggal_perhitungan)', $tanggal)
            ->order_by('h.ranking')
            ->get()->result();
    }

    $this->template->load('spk/template_admin', 'spk/admin/perhitungan/hasil', $data);
}

public function laporan_hasil()
{
    $tanggal = $this->input->get('tanggal');

    $data['title'] = 'Laporan Hasil Penentuan Bonus';
    $data['tanggal'] = $tanggal;
    $data['tanggal_list'] = $this->M_perhitungan->get_tanggal_hasil();

    if ($tanggal) {
        $data['hasil'] = $this->db->select('h.*, e.fullname')
            ->from('hasil_profile_matching h')
            ->join('employee e', 'e.id = h.employee_id')
            ->where('h.periode_input', $tanggal)
            ->order_by('h.ranking', 'ASC')
            ->get()->result();
    } else {
        $data['hasil'] = [];
    }

    $this->load->view('spk/admin/perhitungan/laporan_hasil', $data);
}



}
