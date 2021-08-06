<?php

class Pemilih_model extends CI_Model
{
    public function getPeoples($limit, $start, $keyword = null)
    {
        $npsn = $this->session->userdata('npsn');

        if ($keyword) {
            $this->db->where('NPSN', $npsn);
            $this->db->like('Name', $keyword);
            $this->db->or_like('NISN', $keyword);
            $this->db->or_like('jenisKelamin', $keyword);
            $this->db->or_like('Kelas', $keyword);
        }
        return $this->db->get_where('user', ['NPSN' => $npsn], $limit, $start)->result_array();
    }

    public function insertDataExcel($data)
    {
        $this->db->insert('user', $data);
    }
}
