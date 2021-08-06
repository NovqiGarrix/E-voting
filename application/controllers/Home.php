<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function index()
    {
        $npsn = $this->session->userdata('npsn');

        $data = [
            'title' => 'Home | E-Voting',
            'pemilih' => $this->db->get_where('user', ['NPSN' => $npsn])->num_rows(),
            'kandidat' => $this->db->get_where('kandidat', ['NPSN' => $npsn])->num_rows(),
            'pemilihDone' => $this->db->get_where('user', ['is-voting' => 1, 'NPSN' => $npsn])->num_rows(),
            'schoolsRow' => $this->db->get_where('schools', ['NPSN' => $npsn])->num_rows(),
        ];

        $data['pemilihBelum'] = $data['pemilih'] - $data['pemilihDone'];

        $this->load->view('template/header', $data);
        $this->load->view('home/index');
        $this->load->view('template/footer');
    }

    public function logout()
    {
        if ($this->session->userdata('email')) {
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('role_id');
            $this->session->unset_userdata('name');
            $this->session->unset_userdata('user_token');
            $this->session->unset_userdata('npsn');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Log Out Berhasil
              </div>');
            redirect('auth');
        } else {
            return false;
        }
    }
}
