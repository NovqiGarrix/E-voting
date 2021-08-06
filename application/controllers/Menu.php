<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menu_model', 'menu');

        if (!$this->session->userdata('email')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Kamu harus login terlebih dahulu
          </div>');
            redirect('auth');
        }
        $this->load->model('Admin_model');
        checkRole($this->session->userdata('role_id'));
    }

    public function index()
    {
        $data = [
            'title' => 'Menu Management',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'menu' => $this->db->get('menu')->result_array(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'menuNum' => $this->db->get('menu')->num_rows(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
        ];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/menu-management', $data);
        $this->load->view('template/admin/footer', $data);
    }

    public function insert()
    {
        $this->form_validation->set_rules('menuIdInsert', 'Menu Id', 'required|trim|is_unique[menu.id_menu]');
        $this->form_validation->set_rules('menuNameInsert', 'Menu Name', 'required|trim|is_unique[menu.id_menu]');
        $this->form_validation->set_rules('menuRoleId', 'Role Id', 'required|trim');

        if ($this->form_validation->run() == true) {
            // Insert Ke Menu
            $maxOrderBy = $this->db->query("SELECT MAX(order_by) AS `order_by` FROM `menu`;")->row_array();
            $data = [
                'id_menu' => $this->input->post('menuIdInsert'),
                'menu' => $this->input->post('menuNameInsert'),
                'slugMenu' => url_title($this->input->post('menuNameInsert', '_', false)),
                'order_by' => $maxOrderBy['order_by']
            ];
            $this->db->insert('menu', $data);

            // Insert ke User Access Menu
            $this->db->insert(
                'user_access_menu',
                [
                    'role_id' => $this->input->post('menuRoleId'),
                    'menu_id' => $this->input->post('menuIdInsert'),
                ]
            );

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu Added</div>');
            redirect('menu');
        } else {
            redirect('menu');
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Menu',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'menu' => $this->db->get_where('menu', ['id' => $id])->row_array(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
        ];

        $this->form_validation->set_rules('menuName', 'Menu Name', 'required|trim|is_unique[menu.id_menu]');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/header', $data);
            $this->load->view('template/admin/sidebar', $data);
            $this->load->view('template/admin/topbar', $data);
            $this->load->view('admin/edit-menu', $data);
            $this->load->view('template/admin/footer', $data);
        } else {
            $data = [
                'id_menu' => $this->input->post('menuId'),
                'menu' => $this->input->post('menuName'),
                'order_by' => $this->input->post('order-by')
            ];
            $this->db->where('id', $id);
            $this->db->update('menu', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Menu Edited
                  </div>');
            redirect('menu');
        }
    }

    public function delete($id_menu)
    {
        // Deleting in Menu
        $this->db->where('id_menu', $id_menu);
        $this->db->delete('menu');

        // Deleting in User Access Menu
        $this->db->where('menu_id', $id_menu);
        $this->db->delete('user_access_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Menu Deleted </div>');
        redirect('menu');
    }


    // Submenu Management
    public function submenu()
    {
        $data = [
            'title' => 'Submenu Management',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'submenu' => $this->menu->getSubmenu(),
            'menu' => $this->db->get('menu')->result_array(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
        ];

        $this->load->view('template/admin/header', $data);
        $this->load->view('template/admin/sidebar', $data);
        $this->load->view('template/admin/topbar', $data);
        $this->load->view('admin/submenu-management', $data);
        $this->load->view('template/admin/footer', $data);
    }

    public function insertSubmenu()
    {
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim');
        $this->form_validation->set_rules('submenu', 'SubMenu', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');
        $this->form_validation->set_rules('url', 'Url', 'required|trim');

        if ($this->form_validation->run() == false) {

            redirect('menu/submenu');
        } else {
            $checkSlug = $this->db->get_where('submenu', ['slug' => $this->input->post('submenu')]);

            if ($checkSlug->num_rows() > 0) {
                $submenu = $this->input->post('submenu') . $checkSlug->num_rows() * 10 / 10 * 2;
            } else {
                $submenu = $this->input->post('submenu');
            }

            $data = [
                'slug' => url_title($submenu, '_', true),
                'menu_id' => $this->input->post('menu'),
                'submenu' => $this->input->post('submenu'),
                'icon' => $this->input->post('icon'),
                'url' => $this->input->post('url'),
                'is_active' => 1
            ];

            $this->db->insert('submenu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Submenu Added </div>');
            redirect('menu/submenu');
        }
    }

    public function is_activeSubmenu()
    {
        $slug = $this->input->post('slug');
        $is_active = $this->input->post('aktif');

        if ($is_active == 1) {
            $this->db->set('is_active', 0);
            $this->db->where('slug', $slug);
            $this->db->update('submenu');
        } else {
            $this->db->set('is_active', 1);
            $this->db->where('slug', $slug);
            $this->db->update('submenu');
        }
    }

    public function submenuDelete($slug)
    {
        $this->db->where('slug', $slug);
        $this->db->delete('submenu');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Submenu Deleted </div>');
        redirect('menu/submenu');
    }

    public function submenuEdit($slug)
    {
        $data = [
            'title' => 'Edit SubMenu',
            'user' => $this->db->get_where('user', ['Email' => $this->session->userdata('email')])->row_array(),
            'menu' => $this->db->get('menu')->result_array(),
            'submenu' => $this->db->get_where('submenu', ['slug' => $slug])->row_array(),
            'suaraMasuk' => $this->Admin_model->suaraMasuk(),
            'kandidat' => $this->db->get('kandidat')->result_array(),
        ];


        $this->form_validation->set_rules('menu', 'Menu', 'trim');
        $this->form_validation->set_rules('submenu', 'SubMenu', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');
        $this->form_validation->set_rules('url', 'Url', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/admin/header', $data);
            $this->load->view('template/admin/sidebar', $data);
            $this->load->view('template/admin/topbar', $data);
            $this->load->view('admin/edit-submenu', $data);
            $this->load->view('template/admin/footer', $data);
        } else {
            $data['submenuNow'] = $this->db->get_where('submenu', ['slug' => $slug])->row_array();

            if ($this->input->post('menu')) {
                $menuId = $this->input->post('menu');
            } else {
                $menuId = $data['submenuNow']['menu_id'];
            }

            $data = [
                'menu_id' => $menuId,
                'submenu' => $this->input->post('submenu'),
                'icon' => $this->input->post('icon'),
                'url' => $this->input->post('url')
            ];
            $this->db->where('slug', $slug);
            $this->db->update('submenu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Submenu Edited </div>');
            redirect('menu/submenu');
        }
    }
}
