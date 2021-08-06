<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkRole($this->session->userdata('role_id'));
        $this->load->model('Admin_model');
    }

    public function index()
    {
        $data = [
            'title' => 'Role',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'roleNum' => $this->db->get('user_role')->num_rows(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
        ];

        if ($this->session->userdata('role_id') == 1) {
            $data['role'] = $this->db->get('user_role')->result_array();
        } else {
            $this->db->where('role_id' != 2);
            $data['role'] = $this->db->get('user_role')->result_array();
        }


        $this->form_validation->set_rules('roleName', 'Role Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/header', $data);
            $this->load->view('template/admin/sidebar', $data);
            $this->load->view('template/admin/topbar', $data);
            $this->load->view('admin/role-management', $data);
            $this->load->view('template/admin/footer', $data);
        } else {
            $data = [
                'role_id' => $this->input->post('roleId'),
                'roleName' => $this->input->post('roleName'),
            ];

            $this->db->insert('user_role', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Role ditambah
          </div>');
            redirect('dashboard');
        }
    }

    public function editRole($role_id)
    {
        $data = [
            'title' => 'Edit Role',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'roleWhere' => $this->db->get_where('user_role', ['role_id' => $role_id])->row_array(),
            'roleNum' => $this->db->get('user_role')->num_rows(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
        ];

        $this->form_validation->set_rules('roleName', 'Role Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/header', $data);
            $this->load->view('template/admin/sidebar', $data);
            $this->load->view('template/admin/topbar', $data);
            $this->load->view('admin/edit-role', $data);
            $this->load->view('template/admin/footer', $data);
        } else {
            $data = [
                'role_id' => $this->input->post('roleId'),
                'roleName' => $this->input->post('roleName'),
            ];

            $this->db->where('role_id', $role_id);
            $this->db->update('user_role', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role berhasil diEdit</div>');
            redirect('dashboard');
        }
    }

    public function deleteRole($role_id)
    {
        $this->db->where('role_id', $role_id);
        $this->db->delete('user_role');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Role berhasil dihapus
          </div>');
        redirect('dashboard');
    }

    public function accessRole($role_id)
    {
        $data = [
            'title' => 'Role Access',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
            'role' => $this->db->get_where('user_role', ['role_id' => $role_id])->row_array(),
            'menu' => $this->db->get('menu')->result_array()
        ];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/access-role', $data);
        $this->load->view('template/admin/footer', $data);
    }

    public function changeAccess()
    {
        $menuId = $this->input->post('menuId');
        $roleId = $this->input->post('roleId');

        if (!$menuId && !$roleId) {
            redirect('dashboard');
        }

        $result = $this->db->get_where('user_access_menu', ['menu_id' => $menuId, 'role_id' => $roleId])->num_rows();

        if ($result > 0) {
            $this->db->where('role_id', $roleId);
            $this->db->where('menu_id', $menuId);
            $this->db->delete('user_access_menu');
        } else {
            $data = [
                'menu_id' => $menuId,
                'role_id' => $roleId
            ];

            $this->db->insert('user_access_menu', $data);
        }
    }

    public function admin()
    {
        $dataPerBulanSekolah = "SELECT MONTH(tanggal) as Bulan, COUNT(*) as `jumlahPerBulan` FROM `schools` GROUP BY MONTH(tanggal)";
        $dataPerBulanSiswa = "SELECT MONTH(tanggal) AS Bulan, COUNT(*) AS `jumlahPerBulan` FROM `user` WHERE `role_id` = 10 GROUP BY MONTH(tanggal)";


        $data = [
            'title' => 'Dashboard',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'schoolRow' => $this->db->get('schools')->num_rows(),
            'guruRow' => $this->db->get_where('user', ['role_id' => 3])->num_rows(),
            'siswaRow' => $this->db->get_where('user', ['role_id' => 10])->num_rows(),
            'bulan' => $this->db->get('bulan')->result_array(),
            'dataBulanSekolah' => $this->db->query($dataPerBulanSekolah)->row_array(),
            'dataBulanSiswa' => $this->db->query($dataPerBulanSiswa)->result_array(),
        ];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('template/admin/footer', $data);
        $this->load->view('template/admin/schoolChart', $data);
        count($data['dataBulanSiswa']) < 2 ? $this->load->view('template/admin/barSiswaChart', $data) : $this->load->view('template/admin/siswaChart', $data);
    }


    // Ajax Function
    public function fetchCardData()
    {
        if ($this->input->post('id') && $this->input->post('id') == 'VqiiRixx') {
            $schoolRow = $this->db->get('schools')->num_rows();
            $guruRow = $this->db->get_where('user', ['role_id' => 3])->num_rows();
            $siswaRow = $this->db->get_where('user', ['role_id' => 10])->num_rows();

            $data = [
                'schoolData' => [
                    'schoolRow' => $schoolRow,
                    'guruRow' => $guruRow,
                    'siswaRow' => $siswaRow,
                ],
            ];
            echo json_encode($data);
        }
    }
}
