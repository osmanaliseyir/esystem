<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $total_rows;
    }

    function user_login() {

        $this->load->helper("email");

        $email = addslashes($this->input->post("l-email"));
        $password = addslashes($this->input->post("l-password"));
        $rememberme = $this->input->post("rememberme");

        if ($email != "") {
            if (valid_email($email) == true) {
                if ($password != "") {
                    $query = $this->db->query("SELECT * FROM site_users WHERE email='" . $email . "' AND password='" . md5($password) . "'");
                    if ($query->num_rows > 0) {
                        $row = $query->row();

                        $query2 = $this->db->query("SELECT name FROM site_meslek WHERE id='" . $row->meslek . "'");
                        $row2 = $query2->row();

                        $sessions["user_id"] = $row->id;
                        $sessions["user_adsoyad"] = $row->adsoyad;
                        $sessions["user_email"] = $row->email;
                        $sessions["user_meslek"] = $row->meslek;
                        $sessions["user_meslekname"] = $row2->name;
                        $sessions["user_image"] = $row->image;
                        $this->session->set_userdata($sessions);

                        if ($rememberme == 1) {
                            $cookie = array(
                                'name' => 'e-meslek',
                                'value' => '' . $row->id . '-' . setToken($row->id),
                                'expire' => '86500'
                            );

                            $this->input->set_cookie($cookie);
                        }

                        redirect(base_url() . "profilim");
                    } else {
                        return "E-Posta Adresi veya Şifreniz Hatalı!";
                    }
                } else {
                    return "Şifrenizi Giriniz!";
                }
            } else {
                return "E-Posta Adresinizi aaa@bbb.ccc şeklinde Giriniz!";
            }
        } else {
            return "E-Posta Adresinizi Giriniz!";
        }
    }

    function user_add() {
        $this->load->helper("email");

        $adsoyad = addslashes($this->input->post("adsoyad"));
        $email = addslashes($this->input->post("email"));
        $password = addslashes($this->input->post("password"));
        $meslek = intval($this->input->post("meslek"));
        $type = 1; // Normal User

        if ($adsoyad != "") {
            if ($email != "") {
                if (valid_email($email) == true) {
                    $query = $this->db->query("SELECT id FROM site_users WHERE email='" . $email . "'");
                    if ($query->num_rows() == 0) {
                        if ($meslek != "") {
                            if ($password != "") {
                                //Kayıt
                                $query = $this->db->query("INSERT INTO site_users (adsoyad,email,password,meslek,type,savedate,updatedate) VALUES ('" . $adsoyad . "','" . $email . "','" . md5($password) . "','" . $meslek . "','" . $type . "',NOW(),NOW())");

                                if ($this->db->insert_id() > 0) {
                                    $user_id = $this->db->insert_id();
                                    $sessions["user_id"] = $user_id;
                                    $sessions["user_adsoyad"] = $adsoyad;
                                    $sessions["user_email"] = $email;
                                    $sessions["user_meslek"] = $meslek;
                                    $this->session->set_userdata($sessions);

                                    //Diğer tabloları giriyoruz..
                                    $this->db->query("INSERT INTO site_user_kisisel (user_id) VALUES ('" . $user_id . "')");
                                    $this->db->query("INSERT INTO site_user_iletisim (user_id) VALUES ('" . $user_id . "')");

                                    echo '{"success":"true","msg":"Üyeliğiniz Başarıyla Tamamlandı! Yönlendiriliyorsunuz..."}';
                                } else {
                                    echo '{"success":"false","msg":"Hata : Kullanıcı Kaydınız Yapılamadı!"}';
                                }
                            } else {
                                echo '{"success":"false","msg":"Şifrenizi Girmelisiniz!"}';
                            }
                        } else {
                            echo '{"success":"false","msg":"Mesleğinizi Girmelisiniz!"}';
                        }
                    } else {
                        echo '{"success":"false","msg":"\"' . $email . '\" Adresi Sitemizde Kayıtlıdır!"}';
                    }
                } else {
                    echo '{"success":"false","msg":"E-Posta Adresinizi aaa@bbb.ccc şeklinde Giriniz!"}';
                }
            } else {
                echo '{"success":"false","msg":"E-Posta Adresinizi Giriniz!"}';
            }
        } else {
            echo '{"success":"false","msg":"Adınızı ve Soyadınızı Giriniz!"}';
        }
    }

    function user_forgotpassword() {
        $this->load->helper("email");
        $email = addslashes($this->input->post("f-email"));

        if ($email != "") {
            if (valid_email($email) == true) {
                $query = $this->db->query("SELECT * FROM site_users WHERE email='" . $email . "'");
                if ($query->num_rows > 0) {

                    $newPassword = rand(100000, 999999);
                    $query = $this->db->query("UPDATE site_users SET password='" . md5($newPassword) . "' WHERE email='" . $email . "'");

                    $this->load->library('email');

                    $config["mailtype"] = "html";
                    $this->email->initialize($config);

                    $this->email->from($this->config->item('admin_email'), $this->config->item('admin_name'));
                    $this->email->to('' . $email . '');
                    $this->email->subject('Şifremi Unuttum');
                    $html = $this->config->item("site_link") . " " . lang("sitesindeki hesabınızın şifresini unuttuğunuzu belirttiniz. Şifreniz yenilenmiştir.") . "<br/>";
                    $html.= lang("Kullanmış olduğunuz bu e-posta adresi ve aşağıda belirtilmiş olan şifrenizle sitemize giriş yapabilirsiniz..") . "<br/><br/>";
                    $html.= lang("Şifre Bilgileri") . "<br/>";
                    $html.="<b>" . lang("Yeni Şifreniz") . "</b><br/>";
                    $html.="" . $newPassword . "<br/>";
                    $html.="<br/><br/>";
                    $html.="" . lang("İyi Günler Dileriz") . "<br/>";
                    $html.=$this->config->item("site_link") . " " . lang("Sitesi Yönetimi") . "<br/>";
                    $this->email->message($html);
                    $this->email->send();

                    echo '{"success":"true","msg":"Yeni Şifreniz E-Posta Adresinize Gönderildi."}';
                } else {
                    echo '{"success":"false","msg":"Bu E-Posta Adresi Sistemimizde Kayıtlı Değildir!"}';
                }
            } else {
                echo '{"success":"false","msg":"E-Posta Adresinizi aaa@bbb.ccc şeklinde Giriniz!"}';
            }
        } else {
            echo '{"success":"false","msg":"E-Posta Adresinizi Giriniz!"}';
        }
    }

    function cookieCheck() {
        $this->load->helper("cookie");
        if (get_cookie('e-meslek') != "") {
            $cookie = explode('-', get_cookie('e-meslek'));

            $user_id = $cookie[0];
            $token = $cookie[1];
            if (setToken($user_id) == $token) {
                if ($user_id > 0) {
                    $query = $this->db->query("SELECT * FROM site_users WHERE id='" . $user_id . "'");
                    $row = $query->row();

                    $query2 = $this->db->query("SELECT name FROM site_meslek WHERE id='" . $row->meslek . "'");
                    $row2 = $query2->row();

                    $sessions["user_id"] = $row->id;
                    $sessions["user_adsoyad"] = $row->adsoyad;
                    $sessions["user_email"] = $row->email;
                    $sessions["user_meslek"] = $row->meslek;
                    $sessions["user_meslekname"] = $row2->name;
                    $sessions["user_image"] = $row->image;
                    $this->session->set_userdata($sessions);

                    $this->session->set_userdata($sessions);
                    redirect(base_url() . "profilim");
                }
            }
        }
    }

    function parse_signed_request($signed_request, $secret) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
            error_log('Unknown algorithm. Expected HMAC-SHA256');
            return null;
        }

        // check sig
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }
        return $data;
    }

    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    function floginget() {

        define('FACEBOOK_APP_ID', '188352007953512');
        define('FACEBOOK_SECRET', '01f5a408eb9d731512dc9a29c4954857');

        if ($_REQUEST) {
            $response = $this->parse_signed_request($_REQUEST['signed_request'], FACEBOOK_SECRET);
            $adsoyad = $response["registration"]["name"];
            $email = $response["registration"]["email"];
            $password = $response["registration"]["password"];
            $gender = $response["registration"]["gender"];
            $birtday = $response["registration"]["birthday"];
            $meslek = $response["registration"]["meslek"];
            $type = 1;


            $query = $this->db->query("INSERT INTO site_users (adsoyad,email,password,meslek,type,savedate,updatedate) VALUES ('" . $adsoyad . "','" . $email . "','" . md5($password) . "','" . $meslek . "','" . $type . "',NOW(),NOW())");
            if ($this->db->insert_id() > 0) {
                $sessions["user_id"] = $this->db->insert_id();
                $sessions["user_adsoyad"] = $adsoyad;
                $sessions["user_email"] = $email;
                $sessions["user_meslek"] = $meslek;
                $this->session->set_userdata($sessions);

                echo "<div style='width:520px; padding:10px;'><div class='success'>Kaydınız Başarıyla Yapılmıştır.</div>";
                echo "<a class='btn btnRed' href='javascript:void(0)' onclick='window.close(); window.opener.location=\"" . base_url() . "profilim\"'>Devam Et</a></div>";
            }
        } else {

            echo "<div class='alert'>Geçersiz İstek</div>";
        }
    }

    function getMesleks() {
        $cond="";
        if(isset($_GET["meslek"]) && $_GET["meslek"]!=""){
            $cond=" AND name like '%".$_GET["meslek"]."%' ";
        }
        $query = $this->db->query("SELECT id,name FROM site_meslek WHERE active='1' ".$cond." ORDER BY name ASC");
        foreach ($query->result() as $row) {
            $data[$row->id] = $row->name;
        }
        return $data;
    }

}

?>
