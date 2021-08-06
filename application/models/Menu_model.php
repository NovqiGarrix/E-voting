<?php

class Menu_model extends CI_Model
{

    public function getSubmenu()
    {
        $querySubmenu = "SELECT *
                        FROM `submenu` JOIN menu 
                        ON `submenu`.`menu_id` = `menu`.`id_menu`
                        WHERE `submenu`.`menu_id` = `menu`.`id_menu`
                        ORDER BY `menu`.`id_menu` ASC
                        ";
        return $this->db->query($querySubmenu)->result_array();
    }
}
