<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('email')) {
            redirect('home');
        }
    }

    public function index()
    {
        $data['title'] = 'Masuk | E-Voting';

        // Rules
        $this->form_validation->set_rules(
            'email',
            'Email or NISN',
            'required|trim',
            [
                'required' => 'Field ini wajib diisi'
            ]
        );
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|trim',
            [
                'required' => 'Field ini wajib diisi'
            ]
        );

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header-auth.php', $data);
            $this->load->view('auth/login.php');
            $this->load->view('template/footer-auth.php');
        } else {
            $this->__login();
        }
    }

    public function registerSchool()
    {
        $data = [
            'title' => 'Pendaftaran Sekolah | E-Voting',
            'voteMethod' => ['Import menggunakan excel', 'Register Manual']
        ];

        $this->form_validation->set_rules('npsn', 'NPSN', 'required|trim|exact_length[8]|numeric|is_unique[schools.NPSN]');
        $this->form_validation->set_rules('name', 'Nama Sekolah', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_emails|valid_email|is_unique[schools.Email]');
        $this->form_validation->set_rules(
            'pass1',
            'Password',
            'required|trim|min_length[8]|matches[pass2]',
            [
                'required' => 'Field ini wajib diisi',
                'min_length' => 'Password harus berisi minimal 8 karakter',
                'matches' => 'Password tidak sesuai dengan confirm password'
            ]
        );
        $this->form_validation->set_rules(
            'pass2',
            'Password',
            'required|trim|min_length[8]|matches[pass1]',
            [
                'required' => 'Field ini wajib diisi',
                'min_length' => 'Password harus berisi minimal 8 karakter',
                'matches' => 'Password tidak sesuai'
            ]
        );

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header-auth', $data);
            $this->load->view('auth/daftarSekolah');
            $this->load->view('template/footer-auth');
        } else {
            $uploadImg = $_FILES['akreditasiFile']['name'];

            if ($uploadImg) {
                $config['upload_path']          = './assets/upload/akreditasi/';
                $config['allowed_types']        = 'jpg|png';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('akreditasiFile')) {
                    $this->_registerSchool($this->upload->data('file_name'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('registerSchool');
                }
            }
        }
    }

    private function _registerSchool($uploadImg)
    {
        $dataSchool = [
            'Name' => $this->input->post('name'),
            'NPSN' => $this->input->post('npsn'),
            'Email' => $this->input->post('email'),
            'ip_address' => $this->_getIpAddress(),
            'voteMethod' => $this->input->post('voteMethod'),
            'approve' => 0,
            'akreditasi' => $uploadImg
        ];

        $dataUser = [
            'ip_address' => $this->_getIpAddress(),
            'Name' => $this->input->post('name'),
            'NPSN' => $this->input->post('npsn'),
            'Email' => $this->input->post('email'),
            'Password' => password_hash($this->input->post('pass1'), PASSWORD_DEFAULT),
            'img' => 'default.png',
            'dateCreated' => time(),
            'is_active' => 1,
            'role_id' => 2
        ];

        $token = base64_encode(random_bytes(32));
        $dataToken = [
            'email' => $this->input->post('email'),
            'token' => $token,
            'date_created' => time(),
        ];
        $this->db->insert('schools', $dataSchool);
        $this->db->insert('user', $dataUser);
        $this->db->insert('user_token', $dataToken);

        $this->_sendEmail($token, 'verify');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Akun kamu berhasil didaftar, silahkan check email kamu untuk melakukan aktivasi</div>');
        redirect('auth');
    }

    public function registerHead()
    {
        $data = [
            'title' => 'Pendaftaran Kepala Sekolah',
            'jenisKelamin' => ['Laki - Laki', 'Perempuan']
        ];

        $this->form_validation->set_rules('kepsekName', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('kepsekEmail', 'Email', 'required|trim|valid_emails|valid_email');
        $this->form_validation->set_rules('kepsekPass1', 'Password', 'required|trim|matches[pass2]|min_length[5]');
        $this->form_validation->set_rules('kepsekPass2', 'Repeat Password', 'required|trim|matches[pass1]|min_length[5]');


        if ($this->form_validation->run() == false) {
            $this->load->view('template/header-auth', $data);
            $this->load->view('auth/daftarHead');
            $this->load->view('template/footer-auth');
        } else {
            $dataUser = [
                'Name' => $this->input->post('name'),
                'is-voting' => 1,
                'NPSN' => $this->session->userdata('npsn'),
                'dateCreated' => time(),
                'jenisKelamin' => $this->input->post('jenisKelamin'),
                'img' => 'default.png',
                'role_id' => 3,
                'is_active' => 1,
                'Email' => $this->input->post('email'),
                'Password' => password_hash($this->input->post('pass1'), PASSWORD_DEFAULT)
            ];

            $this->db->insert('user', $dataUser);

            $token = base64_encode(random_bytes(32));
            $dataToken = [
                'token' => $token,
                'email' => $this->input->post('email'),
                'dateCreated' => time()
            ];

            $this->db->insert('user_token', $dataToken);

            $this->_sendEmail($token, 'verify');

            $this->session->unset_userdata('npsn');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Akun kamu berhasil didaftar, silahkan check email kamu untuk melakukan aktivasi</div>');
            redirect('auth');
        }
    }

    private function __login()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if (is_numeric($email)) {
            $user = $this->db->get_where('user', ['NISN' => $email])->row_array();
        } else {
            $user = $this->db->get_where('user', ['Email' => $email])->row_array();
        }

        if ($user) {
            if (password_verify($password, $user['Password'])) {
                if ($user['is_active'] == 1) {
                    $data = [
                        'email' => $user['Email'],
                        'role_id' => $user['role_id'],
                        'name' => $user['Name'],
                        'npsn' => $user['NPSN']
                    ];
                    $this->session->set_userdata($data);

                    $checkToken = $this->db->get_where('user_Token', ['email' => $user['Email']])->row_array();
                    if ($checkToken) {
                        $this->db->where('email', $user['Email']);
                        $this->db->delete('user_token');
                    }

                    redirect('home');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Akun kamu belum teraktivasi, Silahkan buka email kamu untuk melakukan aktivasi
          </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Password kamu salah
          </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Tidak ada akun dengan email tersebut
          </div>');
            redirect('auth');
        }
    }

    private function _getIpAddress()
    {
        $ip = '';

        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }

    public function checkRegister()
    {
        if ($this->input->post('id') && $this->input->post('id') == 'VqiiRixx') {
            # code...
        }
    }

    public function register()
    {
        $ip = $this->_getIpAddress();
        $user_ip = $this->db->get_where('user', ['ip_address' => $ip])->row_array();

        if ($user_ip) {
            // redirect('auth');
        }

        // Rules
        $this->form_validation->set_rules(
            'nisn',
            'NISN',
            'required|trim|numeric|is_unique[user.NISN]|exact_length[10]',
            [
                'required' => 'Field ini wajib diisi',
                'is_unique' => 'NISN ini sudah terdaftar',
                'exact_length' => 'NISN tidak valid',
                'numeric' => 'NISN tidak valid'
            ]
        );
        $this->form_validation->set_rules(
            'name',
            'Full Name',
            'required|trim',
            ['required' => 'Field ini wajib diisi']
        );
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|is_unique[user.email]|valid_emails|valid_email',
            [
                'required' => 'Field ini wajib diisi',
                'is_unique' => 'Email ini sudah terdaftar',
                'valid_email' => 'Email tidak valid',
                'valid_emails' => 'Email tidak valid'
            ]
        );
        $this->form_validation->set_rules(
            'pass1',
            'Password',
            'required|trim|min_length[8]|matches[pass2]',
            [
                'required' => 'Field ini wajib diisi',
                'min_length' => 'Password harus berisi minimal 8 karakter',
                'matches' => 'Password tidak sesuai dengan confirm password'
            ]
        );
        $this->form_validation->set_rules(
            'pass2',
            'Password',
            'required|trim|min_length[8]|matches[pass1]',
            [
                'required' => 'Field ini wajib diisi',
                'min_length' => 'Password harus berisi minimal 8 karakter',
                'matches' => 'Password tidak sesuai'
            ]
        );
        $this->form_validation->set_rules(
            'npsn',
            'NPSN',
            'required|trim|exact_length[8]',
            [
                'required' => 'Field ini wajib diisi',
                'exact_length' => 'Invalid Password',
            ]
        );

        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');

        $token_field = $this->input->post('token-input');

        $token_daftar = $this->db->get('token_daftar')->row_array();
        $token_daftar = $token_daftar['token'];

        $data['kelas'] = ['X', 'XI', 'XII'];
        $data['jurusan'] = ['IPA', 'IPS'];
        $data['noKelas'] = ['1', '2', '3', '4', '5'];
        $data['jenisKelamin'] = ['Laki - Laki', 'Perempuan'];

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Daftar | E-Voting';
            $this->load->view('template/header-auth', $data);
            $this->load->view('auth/register');
            $this->load->view('template/footer-auth');
        } else {
            $getThatSchool = $this->db->get_where('schools', ['NPSN' => $this->input->post('npsn')])->row_array();

            if ($getThatSchool) {
                if ($getThatSchool['voteMethod'] == 'Import-menggunakan-Excel') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data kamu telah di import oleh pihak sekolah</div>');
                    redirect('auth/register');
                } else {
                    $this->__register();
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Sekolah kamu belum terdaftar di sistem kami</div>');
                redirect('auth/register');
            }
        }
    }

    private function __register()
    {
        $guru = $this->db->get_where('guru', ['slug' => url_title($this->input->post('name')), 'NPSN' => $this->input->post('npsn')]);

        $kelas = $this->input->post('kelas', true) . ' ' . $this->input->post('jurusan', true) . ' ' . $this->input->post('noKelas', true);

        if ($guru->num_rows() > 0) {

            $data = [
                'NISN' => $this->input->post('nisn', true),
                'Name' => $this->input->post('name', true),
                'Email' => $this->input->post('email', true),
                'Password' => password_hash($this->input->post('pass1'), PASSWORD_DEFAULT),
                'jenisKelamin' => $this->input->post('jenisKelamin'),
                'dateCreated' => time(),
                'role_id' => 3,
                'is_active' => 0,
                'slugKelas' => '',
                'img' => 'default.png',
                'Kelas' => '',
                'ip_address' => $this->_getIpAddress(),
                'voteMehod' => 'Register-Manual',
                'tanggal' => date('Y-m-d')
            ];

            $token = base64_encode(random_bytes(32));

            $user_token = [
                'email' => $this->input->post('email'),
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user_token', $user_token);
            $this->_sendEmail($token, 'verify');

            $this->db->insert('user', $data);

            // Ke Table Guru
            $this->db->set('is_register', 1);
            $this->db->set('Kelas', $kelas);
            $this->db->where('slug', url_title($this->input->post('name'), '-', true));
            $this->db->update('guru');

            // Update ke table Kelas
            $this->db->set('wali_kelas', $this->input->post('name'));
            $this->db->where('NPSN', $this->input->post('npsn'));
            $this->db->update('kelas');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
               Akun kamu berhasil didaftar. Silahkan buka email kamu untuk melakukan aktivasi
              </div>');
            redirect('auth');
        } else {
            $nisn = $this->input->post('nisn', true);
            $name = $this->input->post('name', true);
            $email = $this->input->post('email', true);
            $pass = $this->input->post('pass1', true);
            $jenisKelamin = $this->input->post('jenisKelamin', true);

            $data = [
                'NPSN' => $this->input->post('npsn'),
                'NISN' => $nisn,
                'Name' => $name,
                'Email' => $email,
                'Password' => password_hash($pass, PASSWORD_DEFAULT),
                'jenisKelamin' => $jenisKelamin,
                'Kelas' => $kelas,
                'dateCreated' => time(),
                'role_id' => 10,
                'is_active' => 0,
                'slugKelas' => url_title($kelas, '-', true),
                'ip_address' => $this->_getIpAddress(),
                'voteMethod' => 'Register-Manual',
                'tanggal' => date('Y-m-d')
            ];

            $token = base64_encode(random_bytes(32));

            $user_token = [
                'email' => $this->input->post('email'),
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user_token', $user_token);

            $this->db->insert('user', $data);
            $this->_sendEmail($token, 'verify');

            // Update ke table Kelas
            $this->db->set('jumlahSiswa', +1);
            $this->db->where('NPSN', $this->input->post('npsn'));
            $this->db->where('slug', url_title($kelas, '-', true));
            $this->db->update('kelas');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
               Akun kamu berhasil didaftar. Silahkan buka email kamu untuk melakukan aktivasi
              </div>');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
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

        $this->email->from($config['smtp_user'], 'Nama Pengirimnya');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('E-Voting | Email Verification');
            $this->email->message('
                <p>Please confirm your email, to register your account</p>
                <a href="' . base_url('auth/verify') . '?token=' . urlencode($token) . '&email=' . urlencode(base64_encode($this->input->post('email'))) . '"class="container-confirm">Confirm Email</a>
            ');
        } else if ($type == 'forgotPassword') {
            $this->email->subject('E-Voting | Reset Password for ' . urlencode(base64_encode($this->input->post('email'))));
            $this->email->message('<p>Click this to change your password || Klik ini untuk mengganti password kamu</p><a href="' . base_url('auth/resetPassword') . '?token=' . urlencode($token) . '&email=' . $this->input->post('email') . '" class="container-confirm">Confirm Email</a>
                ');
        }

        $this->email->send();
    }

    public function verify()
    {
        $token_user = $this->input->get('token');
        $email_user = urldecode(base64_decode($this->input->get('email')));

        $email = $this->db->get_where('user', ['Email' => $email_user])->row_array();
        $token = $this->db->get_where('user_token', ['email' => $email_user, 'token' => $token_user])->row_array();

        if ($email) {
            if ($token) {
                if (time() - $token['date_created'] < (60 * 60)) {

                    $this->db->delete('user_token', ['email' => $email['Email']]);

                    $this->db->set('is_active', 1);
                    $this->db->where('Email', $email['Email']);
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                        Aktivasi akun Berhasil. Silahkan login</div>');
                    redirect('auth');
                } else {

                    $this->db->delete('user', ['Email' => $email_user]);
                    $this->db->delete('user_token', ['email' => $email_user]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Aktivasi akun gagal. Waktu aktivasi sudah expired</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
               Aktivasi akun gagal. Token tidak valid
              </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
               Aktivasi akun gagal. Email yang kamu masukkan salah
              </div>');
            redirect('auth');
        }
    }

    public function forgotPassword()
    {
        $data['title'] = 'Forgot Password';

        $this->form_validation->set_rules(
            'email',
            'Email Address',
            'required|trim|valid_emails|valid_email',
            [
                'valid_email' => 'Email wajib diisi',
                'valid_emails' => 'Email wajib diisi'

            ]
        );

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header-auth', $data);
            $this->load->view('auth/lupa-password');
            $this->load->view('template/footer-auth');
        } else {
            $emailField = $this->input->post('email');

            $user = $this->db->get_where('user', ['Email' => $emailField])->row_array();

            $user_token = $this->db->get_where('user_token', ['email' => $user['Email']])->row_array();

            if ($user) {
                if (!$user_token) {
                    if ($user['is_active'] == 1) {
                        $token = base64_encode(random_bytes(32));
                        $user_token = [
                            'email' => $emailField,
                            'token' => $token,
                            'date_created' => time()
                        ];

                        $this->db->insert('user_token', $user_token);

                        $this->_sendEmail($token, 'forgotPassword');

                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password verification telah dikirim ke email kamu</div>');
                        redirect('auth/forgotPassword');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun kamu belum teraktivasi, silahkan aktivasi terlebih dahulu</div>');
                        redirect('auth/forgotPassword');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Silahkan check email kamu untuk melakukan reset password</div>');
                    redirect('auth/forgotPassword');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak ada akun dengan email tersebut</div>');
                redirect('auth/forgotPassword');
            }
        }
    }

    public function resetPassword()
    {
        $email = urldecode(base64_decode($this->input->get('email')));
        $token = $this->input->get('token');

        $user_token = $this->db->get_where('user_token', ['email' => $email])->row_array();

        $user_email = $this->db->get_where('user', ['Email' => $email])->row_array();

        if ($user_token) {
            if (time() - $user_token['date_created'] < (60 * 60)) {

                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->db->delete('user_token', ['email' => $user_token['email']]);

                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
               Token expired
              </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Token tidak valid</div>');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->db->where('email', $this->session->userdata('reset_email'));
        $this->db->delete('user_token');

        $data['title'] = 'Forgot Password';

        $this->form_validation->set_rules(
            'pass1',
            'Email Address',
            'required|trim|min_length[8]|matches[pass2]',
            [
                'matches' => 'Password wajib sama',
                'min_length' => 'Password minimal terdiri dari 8 karakter',
                'required' => 'Password wajib diisi'

            ]
        );

        $this->form_validation->set_rules(
            'pass2',
            'Email Address',
            'required|trim|min_length[8]|matches[pass1]',
            [
                'matches' => 'Password wajib sama',
                'min_length' => 'Password minimal terdiri dari 8 karakter',
                'required' => 'Password wajib diisi'

            ]
        );

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header-auth', $data);
            $this->load->view('auth/reset-password');
            $this->load->view('template/footer-auth');
        } else {
            $pass1 = password_hash($this->input->post('pass1'), PASSWORD_DEFAULT);

            $this->db->set('Password', $pass1);
            $this->db->where('Email', $this->session->userdata('reset_email'));
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
               Password kamu berhasil di ubah
              </div>');
            redirect('auth');
        }
    }
}
