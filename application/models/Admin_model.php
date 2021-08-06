<?php

class Admin_model extends CI_Model
{
    public function suaraMasuk()
    {
        $this->db->limit(5);
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('suaramasuk', ['NPSN' => $this->session->userdata('npsn')])->result_array();
    }

    public function suaraMasukFull()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('suaramasuk', ['NPSN' => $this->session->userdata('npsn')])->result_array();
    }

    public function getKelas()
    {
        $this->db->order_by('order_by', 'ASC');
        return $this->db->get_where('kelas', ['NPSN' => $this->session->userdata('npsn')])->result_array();
    }

    public function get_winner($max)
    {
        $this->db->where('jumlahSuara', $max);
        return $this->db->get_where('kandidat', ['NPSN' => $this->session->userdata('npsn')])->row_array();
    }

    public function getLoadList()
    {
        $this->db->limit(5);
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('suaramasuk', ['NPSN' => $this->session->userdata('npsn')])->result_array();
    }

    public function getPemilihCard()
    {
        return $this->db->get_where('user', ['NPSN' => $this->session->userdata('npsn')])->result_array();
    }
}
