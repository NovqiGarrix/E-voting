<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Data_User extends CI_Controller
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
        $this->load->model('Pemilih_model', 'pemilih');
    }

    // Kandidat ------------------------------------------

    public function triggerFirstModal()
    {
        $npsn = $this->session->userdata('npsn');
        $getSchool = $this->db->get_where('schools', ['NPSN' => $npsn])->row_array();

        if ($this->input->post('id') && $this->input->post('id') == 'VqiiRixx') {
            $getSchool['voteTimes'] < 1 ? $result = "Show" : $result = "Hide";

            echo json_encode($result);
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Kandidat',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'kandidat' => $this->db->get_where('kandidat', ['NPSN' => $this->session->userdata('npsn')])->result_array(),
            'kandidatRow' => $this->db->get('kandidat')->num_rows(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
        ];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/admin-kandidat', $data);
        $this->load->view('template/admin/footer', $data);
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Edit Kandidat',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'kandidat' => $this->db->get_where('kandidat', ['slug' => $slug])->row_array(),
        ];

        $this->form_validation->set_rules('imgProfile', 'Photo Profile', 'trim');
        $this->form_validation->set_rules('no-kandidat', 'No. Kandidat', 'required|trim');
        $this->form_validation->set_rules('name', 'Nama Kandidat', 'required|trim');
        $this->form_validation->set_rules('visi', 'Visi', 'required|trim');
        $this->form_validation->set_rules('misi', 'Misi', 'required|trim');


        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/header', $data);
            $this->load->view('template/admin/sidebar', $data);
            $this->load->view('template/admin/topbar', $data);
            $this->load->view('admin/edit-kandidat', $data);
            $this->load->view('template/admin/footer', $data);
        } else {

            $data['kandidatNow'] = $this->db->get_where('kandidat', ['slug' => $slug, 'NPSN' => $this->input->post('npsn')])->row_array();

            $uploadImg = $_FILES['imgProfile']['name'];

            if ($uploadImg) {
                $config['upload_path']          = './assets/img/kandidat';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 5120;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('imgProfile')) {
                    $old_img = $data['kandidatNow']['img'];

                    if ($old_img != 'default.png') {
                        unlink(FCPATH . 'assets/img/kandidat/' . $old_img);
                    }

                    $newImg = $this->upload->data('file_name');
                    $this->db->set('img', $newImg);
                    $this->db->set('noKandidat', $this->input->post('no-kandidat'));
                    $this->db->set('Name', $this->input->post('name'));
                    $this->db->set('Visi', $this->input->post('visi'));
                    $this->db->set('Misi', $this->input->post('misi'));
                    $this->db->where('slug', $slug);
                    $this->db->update('kandidat');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Kandidat Updated
          </div>');
                    redirect('Data_User');
                }
            }

            $slugKandidat = url_title($this->input->post('name', '-', TRUE));

            $this->db->set('noKandidat', $this->input->post('no-kandidat'));
            $this->db->set('slug', $slugKandidat);
            $this->db->set('Name', $this->input->post('name'));
            $this->db->set('Visi', $this->input->post('visi'));
            $this->db->set('Misi', $this->input->post('misi'));
            $this->db->where('slug', $slug);
            $this->db->update('kandidat');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Kandidat Updated
          </div>');
            redirect('Data_User');
        }
    }

    public function insertKandidat()
    {
        $this->form_validation->set_rules('noKandidat', 'No. Kandidat', 'required|trim|numeric');
        $this->form_validation->set_rules('namaKandidat', 'Nama Kandidat', 'required|trim|is_unique[kandidat.Name]');
        $this->form_validation->set_rules('visi', 'No. Kandidat', 'required|trim');
        $this->form_validation->set_rules('misi', 'No. Kandidat', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Ada kesalahan saat mengisi field
          </div>');
            redirect('Data_User');
        } else {
            $imgKandidat = $_FILES['imgKandidat']['name'];

            $getSchool = $this->db->get_where('schools', ['NPSN' => $this->session->userdata('npsn')])->row_array();

            if ($imgKandidat) {
                $config['upload_path']          = './assets/img/kandidat';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 5120;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('imgKandidat')) {
                    $newImg = $this->upload->data('file_name');
                    $data = [
                        'NPSN' => $this->input->post('npsn'),
                        'slug' => url_title($this->input->post('namaKandidat', '-', true)),
                        'noKandidat' => $this->input->post('noKandidat'),
                        'Name' => $this->input->post('namaKandidat'),
                        'Visi' => $this->input->post('visi'),
                        'Misi' => $this->input->post('misi'),
                        'img' => $newImg,
                    ];

                    $this->db->insert('kandidat', $data);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Kandidat Added
          </div>');
                    redirect('Data_User');
                }
            }
        }
    }

    public function deleteKandidat($slug, $npsn)
    {
        $this->db->where('NPSN', $npsn);
        $this->db->where('slug', $slug);
        $this->db->delete('kandidat');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Kandidat Deleted
          </div>');
        redirect('Data_User');
    }

    // Pemilih ------------------------------------------
    public function pemilih()
    {

        $data = [
            'title' => 'Pemilih',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'userSchool' => $this->db->get_where('schools', ['NPSN' => $this->session->userdata('npsn'), 'Email' => $this->session->userdata('email')])->row_array(),
            'kandidat' => $this->db->get_where('kandidat', ['NPSN' => $this->session->userdata('npsn')])->result_array(),
        ];

        // Check the Vote Method
        $voteMethod = $this->db->get_where('schools', ['NPSN' => $this->session->userdata('npsn')])->row_array();
        $data['users'] = $this->db->get_where(
            'user',
            [
                'NPSN' => $this->session->userdata('npsn'),
                'voteMethod' => $voteMethod['voteMethod']
            ]
        )->result_array();


        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/admin-pemilih', $data);
        $this->load->view('template/admin/footer', $data);
    }

    public function deletePemilih($id)
    {

        $this->db->where('NPSN', $this->session->userdata('npsn'));
        $this->db->where('id', $id);
        $this->db->delete('user');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pemilih berhasil dihapus</div>');
        redirect('Data_User/pemilih');
    }

    public function editPemilih($id)
    {
        $data = [
            'title' => 'Edit Data Pemilih',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'userEdit' => $this->db->get_where('user', ['id' => $id, 'NPSN' => $this->session->userdata('npsn')])->row_array(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
        ];

        $data['kelas'] = $this->db->get('kelas')->result_array();

        $data['jenisKelamin'] = ['Laki - Laki', 'Perempuan'];


        $this->form_validation->set_rules('nisn', 'NISN', 'required|trim|max_length[10]|numeric');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        if ($data['user']['role_id'] != 3) {
            $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');
        }
        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/header', $data);
            $this->load->view('template/admin/sidebar', $data);
            $this->load->view('template/admin/topbar', $data);
            $this->load->view('admin/edit-pemilih', $data);
            $this->load->view('template/admin/footer', $data);
        } else {
            $data = [
                'Name' => $this->input->post('nama'),
                'NISN' => $this->input->post('nisn'),
                'Kelas' => $this->input->post('kelas'),
                'jenisKelamin' => $this->input->post('jenisKelamin'),
            ];

            $this->db->where('id', $id);
            $this->db->update('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pemilih berhasil ditambahkan</div>');
            redirect('Data_User/pemilih');
        }
    }

    public function importSiswa()
    {
        $getSchool = $this->db->get_where('schools', ['NPSN' => $this->session->userdata('npsn')])->row_array();


        $config['upload_path'] = './assets/upload/excelSiswa/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['file_name'] = $getSchool['Name'] . '_' . date('d m Y');
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('importSiswaField')) {
            $dataUpload = $this->upload->data();
            $reader = ReaderEntityFactory::createXLSXReader();

            $reader->open('./assets/upload/excelSiswa/' . $dataUpload['file_name']);
            foreach ($reader->getSheetIterator() as $sheet) {
                $i = 1;
                foreach ($sheet->getRowIterator() as $sheetRow) {
                    if ($i > 1) {
                        $data = [
                            'NISN' => $sheetRow->getCellAtIndex(1),
                            'NPSN' => $getSchool['NPSN'],
                            'Name' => $sheetRow->getCellAtIndex(2),
                            'Email' => $sheetRow->getCellAtIndex(3),
                            'Password' => password_hash($sheetRow->getCellAtIndex(6), PASSWORD_DEFAULT),
                            'Kelas' => $sheetRow->getCellAtIndex(4),
                            'jenisKelamin' => $sheetRow->getCellAtIndex(5),
                            'img' => 'default.png',
                            'dateCreated' => time(),
                            'is_active' => 1,
                            'role_id' => 10,
                            'slugKelas' => url_title($sheetRow->getCellAtIndex(4), '-', true),
                            'voteMethod' => 'Import-menggunakan-Excel',
                            'tanggal' => date('Y-m-d')
                        ];
                        $this->db->insert('user', $data);
                    }
                    $i++;
                }
                $reader->close();
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diImport</div>');
            redirect('Data_User/pemilih');
            unlink('./assets/upload/excelSiswa/' . $dataUpload['file_name']);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
            redirect('Data_User/pemilih');
        }
    }

    public function downloadExampleExcel()
    {
        $this->load->helper('download');
        force_download('./assets/exampleOfExcel/exampleData.xlsx', NULL);
    }

    // Export PDF for Pemilih
    public function generateReportPemilih()
    {
        $npsn = $this->session->userdata('npsn');

        $voteMethod = $this->db->get_where('schools', ['NPSN' => $npsn])->row_array();
        $voteMethod = $voteMethod['voteMethod'];

        $data = [
            'title' => 'Data Pemilih',
            'pemilih' => $this->db->get_where('user', ['NPSN' => $npsn, 'voteMethod' => $voteMethod])->result_array()
        ];

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = $data['title'];
        $this->pdf->loadView('data_user/pdf/pemilih', $data);
    }

    // Guru
    public function guru()
    {
        $npsn = $this->session->userdata('npsn');

        $data = [
            'title' => 'Guru',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'guru' => $this->db->get_where('guru', ['NPSN' => $npsn])->result_array(),
            'guruSignUp' => $this->db->get_where('guru', ['is_register' => 1, 'NPSN' => $npsn])->num_rows(),
            'kandidat' => $this->db->get_where('kandidat', ['NPSN' => $npsn])->result_array(),
        ];

        $this->form_validation->set_rules('name', 'Nama Guru', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/header', $data);
            $this->load->view('template/admin/sidebar', $data);
            $this->load->view('template/admin/topbar', $data);
            $this->load->view('admin/admin-guru', $data);
            $this->load->view('template/admin/footer', $data);
        } else {
            $data = [
                'Name' => $this->input->post('name'),
                'slug' => url_title($this->input->post('name'), '-', true),
                'NPSN' => $npsn
            ];

            $this->db->insert('guru', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Guru berhasil ditambah</div>');
            redirect('Data_User/guru');
        }
    }

    // Kelas
    public function kelasSiswa()
    {
        $npsn = $this->session->userdata('npsn');

        $data = [
            'title' => 'Kelas',
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'kelas' => $this->Admin_model->getKelas(),
            'kelasNum' => $this->db->get_where('kelas', ['NPSN' => $npsn])->num_rows(),
            'kandidat' => $this->db->get_where('kandidat', ['NPSN' => $npsn])->result_array(),
        ];

        $data['kelasName'] = ['X', 'XI', 'XII'];
        $data['jurusan'] = ['IPA', 'IPS'];
        $data['numKelas'] = ['1', '2', '3', '4', '5'];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/admin_kelas');
        $this->load->view('template/admin/footer', $data);
    }

    public function insertKelas()
    {
        $kelasSiswa = $this->input->post('kelasName') . ' ' . $this->input->post('jurusan') . ' ' . $this->input->post('numKelas');

        $kelasSlug = url_title($kelasSiswa, '-', true);

        $this->form_validation->set_rules('kelasName', 'Nama Kelas', 'required|trim');
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'required|trim');
        $this->form_validation->set_rules('numKelas', 'Nomor Kelas', 'required|trim|numeric');
        $this->form_validation->set_rules('seluruhSiswa', 'Jumlah seluruh siswa', 'required|trim|numeric');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
           Kesalahan saat mengisi form
          </div>');
            redirect('Data_User/kelasSiswa');
        } else {
            $data = [
                'slug' => $kelasSlug,
                'kelasName' => $kelasSiswa,
                'seluruhSiswa' => $this->input->post('seluruhSiswa'),
                'order_by' => $this->input->post('orderBy'),
                'NPSN' => $this->session->userdata('npsn')
            ];

            $this->db->insert('kelas', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
           Kelas ditambahkan
          </div>');
            redirect('Data_User/kelasSiswa');
        }
    }

    public function deleteKelas($slug)
    {
        $this->db->where('slug', $slug);
        $this->db->delete('kelas');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
           Kelas dihapus
          </div>');
        redirect('Data_User/kelasSiswa');
    }
}
