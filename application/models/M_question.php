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
}
