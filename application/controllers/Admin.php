<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Kamu harus login terlebih dahulu</div>');

            redirect('auth');
        }

        $this->load->model('Admin_model');

        checkRole($this->session->userdata('role_id'));
    }
    public function index()
    {

        $checkKandidat = $this->db->get_where('kandidat', ['NPSN' => $this->session->userdata('npsn')])->num_rows();
        if ($checkKandidat < 1) {
            // $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
            // Silahkan tambahkan kandidat terlebih dahulu</div>');
            redirect('Data_User');
        }

        $max = $this->db->query("SELECT MAX(jumlahSuara) AS jumlahSuara FROM `kandidat`;");
        if ($max->num_rows() === 1) {
            $max = $this->db->query("SELECT MAX(jumlahSuara) AS jumlahSuara FROM `kandidat`;")->row_array();
            $max = $max['jumlahSuara'];
        }

        $data = [
            'title' => 'Dashboard',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'winner' => $this->Admin_model->get_winner($max),
            'voteMethod' => ['Import menggunakan Excel', 'Register Manual'],
            'schoolData' => $this->db->get_where('schools', ['NPSN' => $this->session->userdata('npsn'), 'Email' => $this->session->userdata('email')])->row_array(),
            'kandidat' => $this->db->get_where('kandidat', ['NPSN' => $this->session->userdata('npsn')])->result_array(),
            'npsn' => $this->session->userdata('npsn'),
            'waktu_pemilu' => $this->db->get_where('waktu_pemilu', ['NPSN' => $this->session->userdata('npsn')])->row_array()
            // 'tokenOld' => $this->db->get('token_daftar')->row_array(),
        ];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('template/admin/footer', $data);
        $this->load->view('template/admin/chartFooter', $data);
    }

    public function getSuara()
    {
        if ($this->input->post('id')) {
            $kandidat = $this->db->get_where('kandidat', ['NPSN' => $this->session->userdata('npsn')])->result_array();
            $result['kandidat'] = $kandidat;
            echo json_encode($result);
        } else {
            redirect('admin');
        }
    }

    public function handleStopVoting()
    {
        if ($this->input->get('q') && urldecode(base64_decode($this->input->get('q'))) == 'VqiiRixx') {
            $data = [
                'Waktu' => 0,
                'int_waktu' => 0,
                'while_voting' => 0
            ];

            $this->db->where('NPSN', $this->session->userdata('npsn'));
            $this->db->update('waktu_pemilu', $data);

            $this->session->set_flashdata('message', '<div role="alert" class="alert alert-primary justify-content-center">Voting diberhentikan</div>');
            redirect('admin');
        }
    }

    public function handleVotingDone()
    {
        if ($this->input->post('id') && $this->input->post('id') == 'VqiiRixx') {
            $this->db->set('while_voting', 0);
            $this->db->where('NPSN', $this->session->userdata('npsn'));
            $this->db->update('waktu_pemilu');

            $this->_sendEmail('votingDone');
        } else {
            redirect('admin');
        }
    }

    public function notification()
    {
        $data = [
            'title' => 'Notifikasi',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'suaraMasuk' => $this->Admin_model->suaraMasukFull(),
            'jumlahSuaraMasuk' => $this->db->get_where('suaramasuk', ['NPSN' => $this->session->userdata('npsn')])->num_rows(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
        ];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/admin-notification', $data);
        $this->load->view('template/admin/footer', $data);
    }

    public function reset()
    {
        $npsn = $this->session->userdata('npsn');

        // Reset Waktu Pemilihan
        $this->db->set('while_voting', 0);
        $this->db->set('int_waktu', 0);
        $this->db->set('Waktu', 0);
        $this->db->where('NPSN', $npsn);
        $this->db->update('waktu_pemilu');

        // Reset User
        $this->db->set('is-voting', 0);
        $this->db->set('kandidat', '');
        $this->db->where('NPSN', $npsn);
        $this->db->update('user');

        // Reset Kandidat
        $this->db->truncate('kandidat');

        // Reset Suara Masuk
        $this->db->where('NPSN', $npsn);
        $this->db->delete('suaramasuk');

        // Reset Schools
        $this->db->set('voteTimes', 0);
        $this->db->where('NPSN', $npsn);
        $this->db->update('schools');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sistem E-Voting berhasil di Reset</div>');
        redirect('admin');
    }

    public function updateTime()
    {
        $waktu_pemilih = $this->input->post('time_pemilu');
        $int_waktu = $this->input->post('int_waktu_pemilu');

        $npsn = $this->session->userdata('npsn');
        $checkNPSN = $this->db->get_where('waktu_pemilu', ['NPSN' => $npsn])->row_array();


        if ($waktu_pemilih && $int_waktu) {
            if ($checkNPSN) {

                // Updating
                $this->db->where('NPSN', $npsn);
                $this->db->update('waktu_pemilu', ['Waktu' => $waktu_pemilih, 'int_waktu' => $int_waktu]);

                if (strtotime($waktu_pemilih) > date('d F Y')) {
                    // Updating Waktu_pemilu
                    $this->db->set('while_voting', 1);
                    $this->db->where('NPSN', $npsn);
                    $this->db->update('waktu_pemilu');

                    // Updating Schools
                    $this->db->set('voteTimes', +1);
                    $this->db->where('NPSN', $npsn);
                    $this->db->update('schools');
                }
            } else {

                // Inserting
                if (strtotime($waktu_pemilih) > date('d F Y')) {
                    $data = [
                        'NPSN' => $npsn,
                        'Waktu' => $waktu_pemilih,
                        'int_waktu' => $int_waktu,
                        'while_voting' => 1
                    ];

                    $this->db->insert('waktu_pemilu', $data);

                    // Updating Schools
                    $this->db->set('voteTimes', +1);
                    $this->db->where('NPSN', $npsn);
                    $this->db->update('schools');
                }
            }
            $this->_sendEmail('votingStart');
        } else {
            redirect('admin');
        }
    }

    public function setTokenPendaftaran()
    {
        $npsn = $this->session->userdata('npsn');
        $token = $this->input->post('token-daftar');
        $getSchoolOnToken = $this->db->get_where('token_daftar', ['NPSN' => $npsn])->row_array();

        if ($getSchoolOnToken) {
            $data = [
                'token' => $token,
                'date_created' => time(),
                'NPSN' => $npsn
            ];
            $this->db->update('token_daftar', $data, ['NPSN' => $npsn]);
        } else {
            // Insert token baru
            $this->db->set('date_created', time());
            $this->db->set('token', $token);
            $this->db->set('NPSN', $npsn);
            $this->db->insert('token_daftar');
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Token berhasil diganti</div>');
        redirect('admin');
    }

    public function handleChangeVoteMethod()
    {
        $newMethod = $this->input->post('metode-pendaftaran');

        if ($newMethod) {
            // Update School
            $this->db->set('voteMethod', $newMethod);
            $this->db->where('NPSN', $this->session->userdata('npsn'));
            $this->db->update('schools');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Metode Pendaftaran diperbarui</div>');
            redirect('admin');
        } else {
            redirect('admin');
        }
    }

    // Ajax function

    public function getNumList()
    {
        if ($this->input->post('id')) {
            $data['numList'] = $this->db->get_where('suaramasuk', ['NPSN' => $this->session->userdata('npsn')])->num_rows();
            echo json_encode($data['numList']);
        } else {
            redirect('admin');
        }
    }

    public function getLoadList()
    {
        if ($this->input->post('id')) {
            $data['loadList'] = $this->Admin_model->getLoadList();

            echo json_encode($data['loadList']);
        } else {
            redirect('admin');
        }
    }

    public function getPemilihCard()
    {
        $npsn = $this->session->userdata('npsn');

        if ($this->input->post('id')) {
            $pemilih = $this->db->get_where('user', ['NPSN' => $npsn])->num_rows();
            $kandidat = $this->db->get_where('kandidat', ['NPSN' => $npsn])->num_rows();
            $pemilihSudah = $this->db->get_where('user', ['is-voting' => 1, 'NPSN' => $npsn])->num_rows();
            $pemilihBelum = $pemilih - $pemilihSudah;

            $data = [
                'pemilih' => $pemilih,
                'kandidat' => $kandidat,
                'pemilihSudah' => $pemilihSudah,
                'pemilihBelum' => $pemilihBelum
            ];

            echo json_encode($data);
        } else {
            redirect('admin');
        }
    }

    public function getKandidatCard()
    {
        if ($this->input->post('id')) {
            $response = $this->db->get_where('kandidat', ['NPSN' => $this->session->userdata('npsn')])->result_array();
            echo json_encode($response);
        } else {
            redirect('admin');
        }
    }

    // Send Email
    private function _sendEmail($type)
    {
        $npsn = $this->session->userdata('npsn');

        $voteMethod = $this->db->get_where('schools', ['NPSN' => $npsn])->row_array();
        $voteMethod = $voteMethod['voteMethod'];

        $getEmail = $this->db->get_where('user', ['NPSN' => $npsn, 'voteMethod' => $voteMethod])->result_array();

        $this->load->library('email');
        // Aktifkan fitur less secure app di email kamu

        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'novqigarrixdev@gmail.com',
            'smtp_pass' => 'tambunan23',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'crlf'      => "\r\n",
        ];

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        $this->email->from($config['smtp_user'], 'E-Voting Dev');
        foreach ($getEmail as $neccesaryEmail) {
            $this->email->to($neccesaryEmail['Email']);
        }

        if ($type == 'votingStart') {
            $this->email->subject('E-Voting | Notifications');
            $this->email->message('
                <h6>Pemilihan sudah baru saja dimulai. Silahkan <a href="' . base_url('auth') . '">Login</a> untuk melakukan pemilihan</h6>
            ');
        } else if ($type == 'votingDone') {
            $this->email->subject('E-Voting | Notifications');
            $this->email->message('
            <h6>Pemilihan sudah berakhir. Silahkan pergi ke halaman <a href="' . base_url('count') . '">Quick Count</a> untuk melihat hasil sementara</h6>
            ');
        }

        $this->email->send();
    }
}
