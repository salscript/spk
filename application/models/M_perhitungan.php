<?php
class M_perhitungan extends CI_Model
{
   public function get_periode_penilaian()
{
    $this->db->select("DATE(na.tanggal_input) as tanggal_input, 
                      IF(h.periode_input IS NOT NULL, 1, 0) as sudah_dihitung");
    $this->db->from("nilai_aktual na");
    $this->db->join("(SELECT DISTINCT periode_input FROM hasil_profile_matching) h", 
                    "DATE(na.tanggal_input) = h.periode_input", "left");
    $this->db->group_by("DATE(na.tanggal_input)");
    $this->db->order_by("na.tanggal_input", "DESC");

    return $this->db->get()->result();
}


    public function get_nilai_aktual_per_karyawan($tanggal)
    {
        $this->db->select("
            e.id AS employee_id,
            e.fullname,
            a.id AS aspect_id,
            a.name AS aspect_name,
            c.name AS criteria_name,
            sc.value AS nilai
        ");
        $this->db->from("nilai_aktual na");
        $this->db->join("employee e", "e.id = na.employee_id");
        $this->db->join("criteria c", "c.id = na.criteria_id");
        $this->db->join("sub_criteria sc", "sc.id = na.subkriteria_id");
        $this->db->join("aspect a", "a.id = c.aspect_id");
        $this->db->where("DATE(na.tanggal_input)", $tanggal);
        $this->db->order_by("e.fullname, a.name, c.name");

        $query = $this->db->get()->result();

        $hasil = [];
        foreach ($query as $row) {
            $hasil[$row->aspect_id]['aspect_name'] = $row->aspect_name;
            $hasil[$row->aspect_id]['data'][$row->fullname][$row->criteria_name] = $row->nilai;
        }

        return $hasil;
    }

    public function get_bobot_gap($gap)
    {
        return match (true) {
            $gap === 0  => 5.0,
            $gap === 1  => 4.5,
            $gap === -1 => 4.0,
            $gap === 2  => 3.5,
            $gap === -2 => 3.0,
            $gap === 3  => 2.5,
            $gap === -3 => 2.0,
            $gap === 4  => 1.5,
            $gap === -4 => 1.0,
            default     => 1.0
        };
    }

    public function hitung_gap_by_tanggal($tanggal)
    {
        $this->db->select('
            e.id AS employee_id,
            e.fullname,
            a.id AS aspect_id,
            a.name AS aspect_name,
            c.id AS criteria_id,
            c.name AS criteria_name,
            c.target,
            sc.value AS nilai_aktual
        ');
        $this->db->from('nilai_aktual na');
        $this->db->join('employee e', 'e.id = na.employee_id');
        $this->db->join('criteria c', 'c.id = na.criteria_id');
        $this->db->join('sub_criteria sc', 'sc.id = na.subkriteria_id');
        $this->db->join('aspect a', 'a.id = c.aspect_id');
        $this->db->where('DATE(na.tanggal_input)', $tanggal);
        $this->db->order_by('a.id, e.fullname, c.name');

        $query = $this->db->get()->result();

        $result = [];

        foreach ($query as $row) {
            $gap = $row->nilai_aktual - $row->target;
            $bobot_gap = $this->get_bobot_gap($gap);

            $result[$row->aspect_id]['aspect_name'] = $row->aspect_name;
            $result[$row->aspect_id]['kriteria'][$row->criteria_id] = $row->criteria_name;
            $result[$row->aspect_id]['target'][$row->criteria_id] = $row->target;
            $result[$row->aspect_id]['data'][$row->fullname][$row->criteria_id] = [
                'actual'     => $row->nilai_aktual,
                'gap'        => $gap,
                'bobot_gap'  => $bobot_gap
            ];
        }

        return $result;
    }

    public function get_data_nilai_aktual_by_tanggal($tanggal)
    {
        $this->db->select('
            e.id AS employee_id,
            e.fullname,
            c.id AS criteria_id,
            c.name AS criteria_name,
            c.aspect_id,
            c.factor_id,
            c.target,
            sc.value AS nilai_aktual,
            f.name AS factor_type,
            c.persentase AS criteria_weight,
            a.name AS aspect_name,
            a.persentase AS aspect_persentase
        ');
        $this->db->from('nilai_aktual na');
        $this->db->join('employee e', 'e.id = na.employee_id');
        $this->db->join('criteria c', 'c.id = na.criteria_id');
        $this->db->join('sub_criteria sc', 'sc.id = na.subkriteria_id');
        $this->db->join('factor f', 'f.id = c.factor_id');
        $this->db->join('aspect a', 'a.id = c.aspect_id');
        $this->db->where('DATE(na.tanggal_input)', $tanggal);
        $this->db->order_by('e.fullname, a.id, f.id');

        return $this->db->get()->result();
    }

    public function hitung_nilai_aspek_by_tanggal($tanggal)
    {
        $data = $this->get_data_nilai_aktual_by_tanggal($tanggal);
        $grouped = [];

        foreach ($data as $row) {
            $gap = $row->nilai_aktual - $row->target;
            $bobot_gap = $this->get_bobot_gap($gap);
            $kontribusi = $bobot_gap * $row->criteria_weight;

            $grouped[$row->employee_id]['fullname'] = $row->fullname;

            $grouped[$row->employee_id]['aspek'][$row->aspect_id]['aspect_name'] = $row->aspect_name;
            $grouped[$row->employee_id]['aspek'][$row->aspect_id]['bobot_aspek'] = $row->aspect_persentase;

            $grouped[$row->employee_id]['aspek'][$row->aspect_id]['kontribusi_kriteria'][] = [
                'criteria_name'   => $row->criteria_name,
                'bobot_gap'       => $bobot_gap,
                'criteria_weight' => $row->criteria_weight,
                'kontribusi'      => round($kontribusi, 4)
            ];
        }

        $hasil = [];
        foreach ($grouped as $emp_id => $emp_data) {
            $total_nilai = 0;
            $aspek_list = [];

            foreach ($emp_data['aspek'] as $asp) {
                $kontribusi_total = 0;
                foreach ($asp['kontribusi_kriteria'] as $k) {
                    $kontribusi_total += $k['kontribusi'];
                }

                $nilai_aspek = $kontribusi_total;
                $kontribusi_aspek = $nilai_aspek * $asp['bobot_aspek'];

                $aspek_list[] = [
                    'aspect_name'       => $asp['aspect_name'],
                    'nilai_aspek'       => round($nilai_aspek, 4),
                    'bobot_aspek'       => $asp['bobot_aspek'],
                    'kontribusi_aspek'  => round($kontribusi_aspek, 4),
                    'kontribusi_kriteria' => $asp['kontribusi_kriteria']
                ];

                $total_nilai += $kontribusi_aspek;
            }

            $hasil[] = [
                'employee_id' => $emp_id,
                'fullname'    => $emp_data['fullname'],
                'aspek'       => $aspek_list,
                'total_nilai' => round($total_nilai, 4)
            ];
        }

        // Urutkan ranking
        usort($hasil, fn($a, $b) => $b['total_nilai'] <=> $a['total_nilai']);

        $rank = 1;
        foreach ($hasil as &$h) {
            $h['ranking'] = $rank++;
        }

        return $hasil;
    }

    public function get_kriteria_per_aspek($tanggal)
    {
        $this->db->select("a.id AS aspect_id, a.name AS aspect_name, c.id AS criteria_id, c.name AS criteria_name");
        $this->db->from("nilai_aktual na");
        $this->db->join("criteria c", "c.id = na.criteria_id");
        $this->db->join("aspect a", "a.id = c.aspect_id");
        $this->db->where("DATE(na.tanggal_input)", $tanggal);
        $this->db->group_by("a.id, c.id");
        $this->db->order_by("a.id, c.id");

        $result = $this->db->get()->result();

        $kriteria = [];
        foreach ($result as $row) {
            $kriteria[$row->aspect_id]['aspect_name'] = $row->aspect_name;
            $kriteria[$row->aspect_id]['kriteria'][$row->criteria_id] = $row->criteria_name;
        }

        return $kriteria;
    }
    public function hitung_cf_sf_berdasarkan_bobot_kriteria($tanggal)
{
    $data = $this->get_data_nilai_aktual_by_tanggal($tanggal);
    $hasil = [];

    foreach ($data as $row) {
        $gap = $row->nilai_aktual - $row->target;
        $bobot_gap = $this->get_bobot_gap($gap);
        $type = strtolower($row->factor_type);

        $emp_id = $row->employee_id;
        $aspect_id = $row->aspect_id;

        $hasil[$aspect_id]['aspect_name'] = $row->aspect_name;
        $hasil[$aspect_id]['kriteria'][$row->criteria_id] = [
            'name' => $row->criteria_name,
            'type' => ucfirst($type)
        ];

        $hasil[$aspect_id]['karyawan'][$emp_id]['fullname'] = $row->fullname;

        // Kelompokkan berdasarkan Core / Secondary
        $hasil[$aspect_id]['karyawan'][$emp_id]['nilai_kriteria'][$row->criteria_id] = [
            'bobot_gap' => $bobot_gap,
            'criteria_weight' => $row->criteria_weight,
            'type' => ucfirst($type)
        ];
    }

    // Hitung CF, SF dan Total per aspek per karyawan
    foreach ($hasil as &$aspek) {
        foreach ($aspek['karyawan'] as &$karyawan) {
            $cf_total = 0;
            $cf_weight = 0;
            $sf_total = 0;
            $sf_weight = 0;

            foreach ($karyawan['nilai_kriteria'] as $nilai) {
                if (strtolower($nilai['type']) == 'core') {
                    $cf_total += $nilai['bobot_gap'] * $nilai['criteria_weight'];
                    $cf_weight += $nilai['criteria_weight'];
                } else {
                    $sf_total += $nilai['bobot_gap'] * $nilai['criteria_weight'];
                    $sf_weight += $nilai['criteria_weight'];
                }
            }

            $cf_avg = $cf_weight > 0 ? $cf_total / $cf_weight : 0;
            $sf_avg = $sf_weight > 0 ? $sf_total / $sf_weight : 0;
            $total_aspek = round(($cf_avg * $cf_weight) + ($sf_avg * $sf_weight), 4);

            $karyawan['cf_nilai'] = round($cf_avg, 2);
            $karyawan['sf_nilai'] = round($sf_avg, 2);
            $karyawan['cf_weight'] = $cf_weight;
            $karyawan['sf_weight'] = $sf_weight;
            $karyawan['total_aspek'] = $total_aspek;
        }
    }

    return $hasil;
}



public function get_list_aspek($tanggal)
{
    return $this->db->select('a.id, a.name, a.persentase as bobot')
                    ->join('criteria c', 'c.aspect_id = a.id')
                    ->join('nilai_aktual na', 'na.criteria_id = c.id')
                    ->where('DATE(na.tanggal_input)', $tanggal)
                    ->group_by('a.id')
                    ->get('aspect a')->result_array();
}
public function simpan_hasil_profile_matching($tanggal)
{
    $hasil = $this->hitung_nilai_aspek_by_tanggal($tanggal);
    if (empty($hasil)) return false;

    $this->db->where('DATE(tanggal_perhitungan)', $tanggal)->delete('hasil_profile_matching');

    $total_nilai = array_sum(array_column($hasil, 'total_nilai'));

    $data = [];
    foreach ($hasil as $row) {
        $persentase = ($total_nilai > 0) 
            ? round(($row['total_nilai'] / $total_nilai) * 100, 2)
            : 0;

        $data[] = [
            'employee_id' => $row['employee_id'],
            'nilai_akhir' => $row['total_nilai'],
            'ranking' => $row['ranking'],
            'persentase_bonus' => $persentase,
            'tanggal_perhitungan' => $tanggal
        ];
    }

    $this->db->insert_batch('hasil_profile_matching', $data);
    return true;
}

public function get_tanggal_hasil()
{
    return $this->db->select('DATE(tanggal_perhitungan) as tanggal')
        ->group_by('DATE(tanggal_perhitungan)')
        ->order_by('tanggal_perhitungan', 'DESC')
        ->get('hasil_profile_matching')
        ->result();
}

public function get_hasil_by_tanggal($tanggal)
{
    return $this->db->select('h.*, e.fullname')
        ->from('hasil_profile_matching h')
        ->join('employee e', 'e.id = h.employee_id')
        ->where('DATE(h.tanggal_perhitungan)', $tanggal)
        ->order_by('h.ranking', 'ASC')
        ->get()
        ->result();
}


}
