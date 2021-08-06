<?php

function checkRole($role_id)
{
    $ci = get_instance();

    $menuUri = $ci->uri->segment(1);

    $menu = $ci->db->get_where('menu', ['slugMenu' => url_title($menuUri, '_', FALSE)])->row_array();

    $menuId = $menu['id_menu'];

    $result = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menuId])->num_rows();

    if ($result < 1) {
        redirect('home');
    }
}

function checkAccess($menu_id, $role_id)
{
    $ci = get_instance();

    $result = $ci->db->get_where('user_access_menu', ['menu_id' => $menu_id, 'role_id' => $role_id]);

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
