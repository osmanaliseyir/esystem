<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class modUsers extends MY_Controller {

    function __construct() {
        parent::__construct();
        Modules::run("users/users/yetkiCheck");
        $this->load->model("mod_user_model");
    }

    function index() {
        $data["title"] = "Kullanıcı Yönetimi";
        $data["kullanicilar"] = $this->mod_user_model->getUsers();
        $this->load->view("mod/kullanicilar", $data);
    }

    function duzenle($args) {

        if (isset($args[0]) && $args[0] != "") {
            //İd Kontrolü
            (isset($_GET["token"]) && setToken($args[0] . "users") == $_GET["token"]) ? "" : show_404();
            $data= $this->mod_user_model->getUser($args[0]);
            $this->load->view("mod/kullanici_duzenle", $data);
        } else {
            show_404();
        }
    }
    
    function editsave($args){
         if (isset($args[0]) && $args[0] != "") {
            //İd Kontrolü
            (isset($_GET["token"]) && setToken($args[0] . "users") == $_GET["token"]) ? "" : show_404();
            $this->template="ajax";
            $data= $this->mod_user_model->editSave($args[0]);
        } else {
            show_404();
        }
    }
    
    function delete($args) {

      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]."users") == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->mod_user_model->delete($args[0]);
      } else {
         show_404();
      }
   }

}

?>
