<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Count extends CI_Controller
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
		$data = [
			'title' => 'Quick Count | E-Voting',
			'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
			'slugName' => $this->input->post('slug')
		];
		$this->load->view('template/header', $data);
		$this->load->view('home/quick-count', $data);
		$this->load->view('template/footer');
	}

	public function quickCount()
	{
		$id = $this->input->post('id');

		if ($id) {
			if ($this->session->userdata('email')) {
				$result = $this->db->get_where('kandidat', ['NPSN' => $this->session->userdata('npsn')])->result_array();
			}
			echo json_encode($result);
		} else {
			redirect('count');
		}
	}
}
