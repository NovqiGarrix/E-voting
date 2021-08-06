<?php

class Sekolah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkRole($this->session->userdata('role_id'));
    }

    public function index()
    {
        $data = [
            'title' => 'Approved',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'schools' => $this->db->get_where('schools', ['approve' => 1])->result_array()
        ];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/approvalSekolah', $data);
        $this->load->view('template/admin/footer', $data);
        $this->load->view('template/admin/schoolChart', $data);
    }

    public function unApproved()
    {
        $data = [
            'title' => 'UnApproved',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'schools' => $this->db->get_where('schools', ['approve' => 0])->result_array()
        ];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/unApprovedSekolah', $data);
        $this->load->view('template/admin/footer', $data);
    }

    public function rejected()
    {
        $data = [
            'title' => 'Rejected',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'schools' => $this->db->get_where('schools', ['approve' => 2])->result_array()
        ];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/rejectedSekolah', $data);
        $this->load->view('template/admin/footer', $data);
    }

    public function approveSchool($schoolId, $type)
    {
        $type = urldecode(base64_decode($type));

        $getSchool = $this->db->get_where('schools', ['id' => $schoolId])->row_array();

        if ($type == 'accept') {
            $this->_sendEmail($getSchool['Email'], $type);

            $this->db->set('approve', 1);
            $this->db->where('id', $schoolId);
            $this->db->update('schools');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Approved</div>');
            redirect('sekolah/unApproved');
        } else if ($type == 'reject') {
            $this->_sendEmail($getSchool['Email'], $type);

            $this->db->set('approve', 2);
            $this->db->where('id', $schoolId);
            $this->db->update('schools');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Rejected</div>');
            redirect('sekolah/unApproved');
        }
    }

    public function downloadAkreditasi()
    {
        $getFile = $this->db->get_where('schools', ['akreditasi' => $this->input->get('acc')])->row_array();

        if ($getFile) {
            $this->load->helper('download');

            $uploadPath = './assets/upload/akreditasi/';
            force_download($uploadPath . $getFile['akreditasi'], NULL);
        }
    }

    public function exportPDFApproved()
    {
        $data = [
            'title' => 'Approved Schools',
            'schools' => $this->db->get_where('schools', ['approve' => 1])->result_array()
        ];

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = $data['title'];
        $this->pdf->loadView('sekolah/pdf/approved', $data);
    }

    public function exportPDFunApproved()
    {
        $data = [
            'title' => 'UnApproved Schools',
            'schools' => $this->db->get_where('schools', ['approve' => 0])->result_array()
        ];

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = $data['title'];
        $this->pdf->loadView('sekolah/pdf/unApproved', $data);
    }

    public function exportPDFRejected()
    {
        $data = [
            'title' => 'Rejected Schools',
            'schools' => $this->db->get_where('schools', ['approve' => 2])->result_array()
        ];

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = $data['title'];
        $this->pdf->loadView('sekolah/pdf/rejected', $data);
    }




    // Send Email
    private function _sendEmail($email, $type)
    {
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

        $this->email->from($config['smtp_user'], 'E-Voting');
        $this->email->to($email);

        if ($type == 'accept') {
            $this->email->subject('E-Voting | Your Schools Approved');
            $this->email->message('<p>Congratulations, Sekolah kamu disetujui untuk melakukan Voting di Sistem kami. Silahkan<a href="' . base_url('auth') . '">Login</a> untuk memulai pemilihan</p>');
        } else if ($type == 'reject') {
            // Handle pas ketolak ? Suruh buat akun : return 0;

            $this->email->subject('E-Voting | Your Schools Rejected');
            $this->email->message('<p>Maaf, Sekolah kamu belum memenuhi syarat untuk melakukan Voting di Sistem kami. Silahkan<a href="' . base_url('auth') . '">Login</a> untuk memulai pemilihan</p>');
        }
        $this->email->send();
    }
}
