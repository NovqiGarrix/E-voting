<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Kamu harus login terlebih dahulu
          </div>');
            redirect('auth');
        }
        $this->load->model('Admin_model');
        checkRole($this->session->userdata('role_id'));

        $user = $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array();
        $namaGuru = $user['Name'];
        $nama = url_title($namaGuru, '-', true);

        $tableGuru = $this->db->get_where('guru', ['slug' => $nama])->row_array();

        $kelas = url_title($tableGuru['Kelas'], '-', true);
        $jumlahSiswa = $this->db->get_where('user', ['slugKelas' => $kelas])->num_rows();

        $this->db->set('jumlahSiswa', $jumlahSiswa);
        $this->db->where('slug', $kelas);
        $this->db->update('kelas');
    }

    public function index()
    {

        $data = [
            'title' => 'Siswa',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
        ];

        $namaGuru = url_title($data['user']['Name'], '-', true);
        $Guru = $this->db->get_where('guru', ['slug' => $namaGuru])->row_array();
        $kelasGuru = url_title($Guru['Kelas'], '-', true);
        $data['kelas'] = $Guru['Kelas'];
        $data['siswa'] = $this->db->get_where('user', ['slugKelas' => $kelasGuru])->result_array();


        $this->load->view('template/admin/header.php', $data);
        $this->load->view('template/admin/sidebar.php', $data);
        $this->load->view('template/admin/topbar.php', $data);
        $this->load->view('admin/admin-siswa.php', $data);
        $this->load->view('template/admin/footer.php', $data);

        
    }

    public function report()
    {
        $user = $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array();
        $namaGuru = $user['Name'];
        $nama = url_title($namaGuru, '-', true);

        $tableGuru = $this->db->get_where('guru', ['slug' => $nama])->row_array();

        $kelas = url_title($tableGuru['Kelas'], '-', true);
        $jumlahSiswa = $this->db->get_where('user', ['slugKelas' => $kelas])->num_rows();

        $this->db->set('jumlahSiswa', $jumlahSiswa);
        $this->db->where('slug', $kelas);
        $this->db->update('kelas');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Laporan dikirim
          </div>');
        redirect('guru');
    }

    public function editSiswa($nisn)
    {
        $data = [
            'title' => 'Siswa',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'userEdit' => $this->db->get_where('user', ['NISN' => $nisn])->row_array(),
            'kelas' => $this->db->get('kelas')->result_array(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
        ];
        $data['jenisKelamin'] = ['Laki - Laki', 'Perempuan'];

        $this->form_validation->set_rules('nisn', 'NISN', 'required|trim|max_length[10]|numeric');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');
        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/header.php', $data);
            $this->load->view('template/admin/sidebar.php', $data);
            $this->load->view('template/admin/topbar.php', $data);
            $this->load->view('admin/edit-siswa.php', $data);
            $this->load->view('template/admin/footer.php', $data);
        } else {
            $data = [
                'NISN' => $this->input->post('nisn'),
                'Name' => $this->input->post('nama'),
                'Kelas' => $this->input->post('kelas'),
                'jenisKelamin' => $this->input->post('jenisKelamin'),
            ];

            $this->db->where('NISN', $nisn);
            $this->db->update('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data siswa berhasil di Update
          </div>');
            redirect('guru');
        }
    }
    public function deleteSiswa($nisn)
    {
        $this->db->where('NISNG', $nisn);
        $this->db->delete('user');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data siswa berhasil di hapus
          </div>');
        redirect('guru');
    }
}
