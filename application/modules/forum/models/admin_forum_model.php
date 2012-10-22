<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class admin_forum_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getItems() {
        $cond = "";
        if (isset($_GET["q"]) && $_GET["q"] != "") {
            $cond.=" AND name like '%" . addslashes($_GET["q"]) . "%'";
        }

        if (isset($_GET["meslek"]) && $_GET["meslek"] != "") {
            $cond.=" AND meslek_id='" . $_GET["meslek"] . "'";
        }

        $cond = "WHERE type='1' " . $cond;

        if (isset($_GET["s"]) && $_GET["s"] != "") {
            $limit = "LIMIT " . $_GET["s"] . ",20";
        } else {
            $limit = "LIMIT 0,20";
        }

        $sql = "SELECT * FROM site_forum ";
        $query = $this->db->query($sql . " " . $cond . "");
        $this->total_rows = $query->num_rows();

        $query2 = $this->db->query($sql . " " . $cond . " ORDER BY meslek_id DESC,ord ASC " . $limit);
        return $query2->result();
    }

    function getItem($id) {
        $query = $this->db->query("SELECT * FROM site_forum WHERE id='" . $id . "' ");
        $data["data"] = $query->row();
        $query2 = $this->db->query("SELECT ord,name FROM site_forum WHERE meslek_id='" . $data["data"]->meslek_id . "' AND id!='" . $data["data"]->id . "'");
        $query3 = $this->db->query("SELECT max(ord) as maxord FROM site_forum WHERE meslek_id='" . $data["data"]->meslek_id . "' AND ord<'" . $data["data"]->ord . "'");
        $row = $query3->row();
        $data["selectedOrd"] = $row->maxord;
        $data["ords"] = $query2->result();
        return $data;
    }

    function delete($id) {
        $query = $this->db->query("DELETE FROM site_forum WHERE id='$id'");
        echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
        $this->db->query("DELETE FROM site_forum WHERE forum_id='".$id."'");
       
    }

    function deleteSelected() {
        $affected = 0;
        if (is_array($this->input->post("sec")) && count($this->input->post("sec")) > 0) {
            foreach ($this->input->post("sec") as $s) {
                $query = $this->db->query("DELETE FROM site_forum WHERE id='" . $s . "'");
                ($this->db->affected_rows() > 0) ? $affected++ : "";
            }
            echo '{"success":"true","affected":"' . $affected . '"}';
        } else {
            echo '{"success":"false","msg":"' . lang("Öncelikle Seçim Yapmalısınız") . '"}';
        }
    }
    

    function setOrd() {
        $meslek_id = $this->input->post("meslek");
        $query = $this->db->query("SELECT id,name FROM site_forum WHERE meslek_id='" . $meslek_id . "' ORDER BY ord ASC");
        echo '{"success":"true","data":' . json_encode($query->result()) . '}';
    }

    function save() {
        $name = addslashes($this->input->post("name"));
        $meslek_id = $this->input->post("meslek_id");
        $ord = $this->input->post("ord");
        switch ($ord) {
            case "ilk":
                $this->db->query("UPDATE site_forum SET ord=ord+1 WHERE meslek_id='" . $meslek_id . "'");
                $query = $this->db->query("INSERT INTO site_forum (name, meslek_id, ord,savedate,type) VALUES ('" . $name . "','" . $meslek_id . "','1',NOW(),'1') ");
                if ($this->db->insert_id() > 0) {
                    echo '{"success":"true"}';
                }
                break;
            case "son":
                $query = $this->db->query("SELECT max(ord) as maksord FROM site_forum WHERE meslek_id='" . $meslek_id . "'");
                $row = $query->row();
                $query = $this->db->query("INSERT INTO site_forum (name, meslek_id, ord,savedate,type) VALUES ('" . $name . "','" . $meslek_id . "','" . ($row->maksord + 1) . "',NOW(),'1') ");
                if ($this->db->insert_id() > 0) {
                    echo '{"success":"true"}';
                }
                break;

            default :
                $query = $this->db->query("SELECT ord FROM site_forum WHERE id='" . $ord . "'");
                $row = $query->row();
                $this->db->query("UPDATE site_forum SET ord=ord+1 WHERE meslek_id='" . $meslek_id . "' AND ord>'" . $row->ord . "'");
                $query = $this->db->query("INSERT INTO site_forum (name, meslek_id, ord, savedate,type) VALUES ('" . $name . "','" . $meslek_id . "','" . ($row->ord + 1) . "',NOW(),'1') ");
                if ($this->db->insert_id() > 0) {
                    echo '{"success":"true"}';
                }
                break;
        }
    }

    function editsave($id) {
        $name = addslashes($this->input->post("name"));
        $meslek_id = $this->input->post("meslek_id");
        $ord = $this->input->post("ord");

        $this->db->query("UPDATE site_forum SET name='" . $name . "',meslek_id='" . $meslek_id . "' WHERE id='" . $id . "'");

        switch ($ord) {
            case "ilk":
                $query = $this->db->query("SELECT ord FROM site_forum WHERE id='" . $id . "'");
                $row = $query->row();
                $this->db->query("UPDATE site_forum SET ord=ord+1 WHERE meslek_id='" . $meslek_id . "' AND id!='" . $id . "' AND ord<'" . $row->ord . "'");
                $query = $this->db->query("UPDATE site_forum SET ord='1' WHERE id='" . $id . "' ");
                if ($this->db->affected_rows() > 0) {
                    echo '{"success":"true"}';
                }
                break;
            case "son":
                $query = $this->db->query("SELECT max(ord) as maksord FROM site_forum WHERE meslek_id='" . $meslek_id . "' AND id!='" . $id . "'");
                $row = $query->row();
                $query = $this->db->query("UPDATE site_forum SET ord='" . ($row->maksord + 1) . "' WHERE id='" . $id . "' ");
                if ($this->db->affected_rows() > 0) {
                    echo '{"success":"true"}';
                }
                break;

            default :
                $this->db->query("UPDATE site_forum SET ord=ord+1 WHERE meslek_id='" . $meslek_id . "' AND ord>'" . $ord . "' AND id!='" . $id . "'");
                $query = $this->db->query("UPDATE site_forum SET ord='" . ($ord + 1) . "' WHERE id='" . $id . "'");
                if ($this->db->affected_rows() > 0) {
                    echo '{"success":"true"}';
                }
                break;
        }
    }

    /*     * ********** SUB FORUMS ****************** */

    function getForums($id) {
        $query = $this->db->query("SELECT meslek_id FROM site_forum WHERE id='" . $id . "'");
        $row = $query->row();
        $query2 = $this->db->query("SELECT id,name FROM site_forum WHERE meslek_id='" . $row->meslek_id . "' AND type='1' ");
        $data = array();
        foreach ($query2->result() as $row2) {
            $data[$row2->id] = $row2->name;
        }
        return $data;
    }

    function setSubOrd() {
        $forum_id = $this->input->post("forum");
        $query = $this->db->query("SELECT id,name FROM site_forum WHERE forum_id='" . $forum_id . "' ORDER BY ord ASC");
        echo '{"success":"true","data":' . json_encode($query->result()) . '}';
    }

    function saveSubForum() {
        $name = addslashes($this->input->post("name"));
        $description = addslashes($this->input->post("description"));
        $forum_id = $this->input->post("forum_id");
        $ord = $this->input->post("ord");
        switch ($ord) {
            case "ilk":
                $this->db->query("UPDATE site_forum SET ord=ord+1 WHERE forum_id='" . $forum_id . "'");
                $query = $this->db->query("INSERT INTO site_forum (name,description, forum_id, ord,savedate,type) VALUES ('" . $name . "','" . $description . "','" . $forum_id . "','1',NOW(),'2') ");
                if ($this->db->insert_id() > 0) {
                    echo '{"success":"true"}';
                }
                break;
            case "son":
                $query = $this->db->query("SELECT max(ord) as maksord FROM site_forum WHERE forum_id='" . $forum_id . "'");
                $row = $query->row();
                $query = $this->db->query("INSERT INTO site_forum (name,description,forum_id,ord,savedate,type) VALUES ('" . $name . "','" . $description . "','" . $forum_id . "','" . ($row->maksord + 1) . "',NOW(),'2') ");
                if ($this->db->insert_id() > 0) {
                    echo '{"success":"true"}';
                }
                break;

            default :
                $query = $this->db->query("SELECT ord FROM site_forum WHERE id='" . $ord . "'");
                $row = $query->row();
                $this->db->query("UPDATE site_forum SET ord=ord+1 WHERE forum_id='" . $forum_id . "' AND ord>'" . $row->ord . "'");
                $query = $this->db->query("INSERT INTO site_forum (name, description, forum_id, ord, savedate,type) VALUES ('" . $name . "','" . $description . "','" . $forum_id . "','" . ($row->ord + 1) . "',NOW(),'2') ");
                if ($this->db->insert_id() > 0) {
                    echo '{"success":"true"}';
                }
                break;
        }
    }

    function getSubItem($id) {
        $query = $this->db->query("SELECT * FROM site_forum WHERE id='" . $id . "' ");
        $data["data"] = $query->row();
        $query2 = $this->db->query("SELECT ord,name FROM site_forum WHERE forum_id='" . $data["data"]->forum_id . "' AND id!='" . $data["data"]->id . "'");
        $query3 = $this->db->query("SELECT max(ord) as maxord FROM site_forum WHERE forum_id='" . $data["data"]->forum_id . "' AND ord<'" . $data["data"]->ord . "'");
        $row = $query3->row();
        $data["selectedOrd"] = $row->maxord;
        $data["ords"] = $query2->result();
        return $data;
    }

    function editsaveSubForum($id) {
        $name = addslashes($this->input->post("name"));
        $description = addslashes($this->input->post("description"));
        $forum_id = $this->input->post("forum_id");
        $ord = $this->input->post("ord");

        $this->db->query("UPDATE site_forum SET name='" . $name . "', description='" . $description . "', forum_id='" . $forum_id . "' WHERE id='" . $id . "'");

        switch ($ord) {
            case "ilk":
                $query = $this->db->query("SELECT ord FROM site_forum WHERE id='" . $id . "'");
                $row = $query->row();
                $this->db->query("UPDATE site_forum SET ord=ord+1 WHERE forum_id='" . $forum_id . "' AND id!='" . $id . "' AND ord<'" . $row->ord . "'");
                $query = $this->db->query("UPDATE site_forum SET ord='1' WHERE id='" . $id . "' ");
                echo '{"success":"true"}';
                break;
            case "son":
                $query = $this->db->query("SELECT max(ord) as maksord FROM site_forum WHERE forum_id='" . $forum_id . "' AND id!='" . $id . "'");
                $row = $query->row();
                $query = $this->db->query("UPDATE site_forum SET ord='" . ($row->maksord + 1) . "' WHERE id='" . $id . "' ");
                echo '{"success":"true"}';
                break;

            default :
                $this->db->query("UPDATE site_forum SET ord=ord+1 WHERE forum_id='" . $forum_id . "' AND ord>'" . $ord . "' AND id!='" . $id . "'");
                $query = $this->db->query("UPDATE site_forum SET ord='" . ($ord + 1) . "' WHERE id='" . $id . "'");
                echo '{"success":"true"}';
                break;
        }
    }
    
     function deleteSubForum($id) {
        $query = $this->db->query("DELETE FROM site_forum WHERE id='$id'");
        echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
    }


}

?>
