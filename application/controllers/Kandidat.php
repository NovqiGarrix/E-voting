<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kandidat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('email')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kamu harus login terlebih dahulu</div>');
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Daftar Kandidat | E-Voting';

        $data['kandidat'] = $this->db->get_where('kandidat', ['NPSN' => $this->session->userdata('npsn')])->result_array();
        $this->load->view('template/header', $data);
        $this->load->view('home/daftar-kandidat', $data);
        $this->load->view('template/footer');
    }

    public function detailKandidat($slug)
    {
        $userEmail = $this->session->userdata('email');
        $npsn = $this->session->userdata('npsn');

        $data['kandidat'] = $this->db->get_where('kandidat', ['slug' => $slug, 'NPSN' => $npsn])->row_array();
        $data['user'] = $this->db->get_where('user', ['Email' => $userEmail, 'NPSN' => $npsn])->row_array();
        $data['title'] = $data['kandidat']['Name'] . ' | E-Voting';
        $data['time_pemilu'] = $this->db->get_where('waktu_pemilu', ['NPSN' => $npsn])->row_array();
        $data['voteSchool'] = $this->db->get_where('schools', ['NPSN' => $npsn])->row_array();


        $this->load->view('template/header', $data);
        $this->load->view('home/detail-kandidat', $data);
        $this->load->view('template/footer');
    }

    public function get_vote()
    {

        $kandidatName = base64_decode($this->input->post('kandidat'));
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
		1 Suara ditambahkan kepada kandidat ' . $kandidatName . '</div>');
        $slug = base64_decode($this->input->post('slug'));
        $userEmail = $this->session->userdata('email');

        $npsn = $this->session->userdata('npsn');

        // Ambil Data
        $k = $this->db->get_where('kandidat', ['slug' => $slug, 'NPSN' => $npsn])->row_array();
        $user = $this->db->get_where('user', ['Email' => $userEmail])->row_array();
        $waktuPemilu = $this->db->get_where('waktu_pemilu', ['NPSN' => $npsn])->row_array();

        // Update Sudah Voting
        if ($user['is-voting'] > 0) {
            redirect('count');
        } else {
            if ($kandidatName) {
                if ($waktuPemilu['Waktu'] == 0 && $waktuPemilu['while_voting'] == 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Sekolah kamu belum melakukan pemilihan</div>');
                    redirect('kandidat');
                } else {
                    $data = [
                        'is-voting' => 1,
                        'Kandidat' => $kandidatName
                    ];
                    $this->db->where('Email', $userEmail);
                    $this->db->update('user', $data);

                    $dateMsg = date('Y-m-d H:i:s');
                    $msg = 'Suara masuk dari ' . $user['Name'] . ' kepada kandidat ' . $kandidatName;
                    $this->db->set('message', $msg);
                    $this->db->set('dateCreated', $dateMsg);
                    $this->db->set('NPSN', $npsn);
                    $this->db->where('NPSN', $npsn);
                    $this->db->insert('suaramasuk');

                    // Update Jumlah Suara
                    $this->db->set('jumlahSuara', $k['jumlahSuara'] + 1);
                    $this->db->where('NPSN', $npsn);
                    $this->db->where('slug', $slug);
                    $this->db->update('kandidat');
                }
            } else {
                redirect('kandidat');
            }
        }
    }
}
