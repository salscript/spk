<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_question extends CI_Model
{

    function get_all_questions()
    {   
        $this->db->select("
            q.id as id,
            q.code_question as code,
            q.name as question,
            c.name as criteria
        ");
        $this->db->from('question q');
        $this->db->join('criteria c', 'c.id=q.criteria_id', 'left');
        return $this->db->get()->result();
    }

    function get_question_by_id($id)
    {   
        $this->db->select("
            q.id as id,
            q.code_question as code,
            q.name as question,
            c.id as criteria_id,
            c.name as criteria
        ");
        $this->db->from('question q');
        $this->db->join('criteria c', 'c.id=q.criteria_id', 'left');
        $this->db->where('q.id', $id);
        return $this->db->get()->row();
    }

   function code_question()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(code_question,4)) AS code_question FROM question");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->code_question) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        // date_default_timezone_set('Asia/Jakarta');
        return "QST" . $kd;
    }

    function save_question($data) {
        return $this->db->insert('question', $data);
    }

    function update_question($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('question', $data);
    }

    public function delete_question($id)
    {
        return $this->db->delete('question', ['id' => $id]);
    }
    public function get_questions_grouped_by_aspect()
    {
        $this->db->select('
            a.id as aspect_id, a.name as aspect_name,
            c.id as criteria_id, c.name as criteria_name,
            q.id as question_id, q.name as question_name
        ');
        $this->db->from('aspect a');
        $this->db->join('criteria c', 'c.aspect_id = a.id');
        $this->db->join('question q', 'q.criteria_id = c.id');
        $this->db->order_by('a.id, c.id, q.id');
        $query = $this->db->get();

        $result = $query->result();

        $grouped = [];

        foreach ($result as $row) {
            if (!isset($grouped[$row->aspect_id])) {
                $grouped[$row->aspect_id] = [
                    'aspect_id' => $row->aspect_id,
                    'aspect_name' => $row->aspect_name,
                    'criteria' => []
                ];
            }

            if (!isset($grouped[$row->aspect_id]['criteria'][$row->criteria_id])) {
                $grouped[$row->aspect_id]['criteria'][$row->criteria_id] = [
                    'criteria_id' => $row->criteria_id,
                    'criteria_name' => $row->criteria_name,
                    'questions' => []
                ];
            }

            $grouped[$row->aspect_id]['criteria'][$row->criteria_id]['questions'][] = (object)[
                'id' => $row->question_id,
                'name' => $row->question_name
            ];
        }

        // Reindex criteria arrays
        foreach ($grouped as &$aspect) {
            $aspect['criteria'] = array_values($aspect['criteria']);
        }

        // Reindex aspect arrays and return
        return array_values($grouped);
    }
    public function get_questions_by_type($type)
{
    // Ambil aspek berdasarkan nama
    $aspect_name = ($type == 'peer') ? 'Sikap Kerja' : 'Kemampuan';

    // Dapatkan aspect_id dari nama
    $aspect = $this->db->get_where('aspect', ['name' => $aspect_name])->row();
    if (!$aspect) return [];

    $aspect_id = $aspect->id;

    // Ambil pertanyaan yang tergabung dengan kriteria dan aspek
    $this->db->select('q.id, q.name, c.name as criteria_name, a.name as aspect_name');
    $this->db->from('question q');
    $this->db->join('criteria c', 'q.criteria_id = c.id');
    $this->db->join('aspect a', 'c.aspect_id = a.id');
    $this->db->where('c.aspect_id', $aspect_id);
    $this->db->order_by('c.name ASC, q.id ASC');

    $rows = $this->db->get()->result();

    // Kelompokkan per aspek dan kriteria
    $grouped = [];
    foreach ($rows as $row) {
        $aspect = $row->aspect_name;
        $criteria = $row->criteria_name;

        if (!isset($grouped[$aspect])) {
            $grouped[$aspect] = [];
        }
        if (!isset($grouped[$aspect][$criteria])) {
            $grouped[$aspect][$criteria] = [];
        }

        $grouped[$aspect][$criteria][] = $row;
    }

    return $grouped;
}

}
