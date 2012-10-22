<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class account_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function bireyselSave() {
        $adsoyad = $this->input->post("adsoyad");
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $password2 = $this->input->post("password2");
        $dogumtarihi = date("Y-m-d", strtotime($this->input->post("dogumtarihi")));
        $medenihal = $this->input->post("medenihal");
        $cinsiyet = $this->input->post("cinsiyet");
        $securitycode = $this->input->post("securitycode");
        if ($securitycode == $this->session->userdata("securitycode")) {
            if ($adsoyad != "") {
                if ($email != "") {
                    if ($password != "") {
                        if ($password2 != "") {
                            if ($password == $password2) {
                                if ($dogumtarihi != "") {
                                    $query = $this->db->query("SELECT id FROM site_users WHERE email='" . $email . "'");
                                    if ($query->num_rows() < 1) {

                                        if ($this->config->item("user_activate") == "1") {
                                            //Aktivasyon isteniyor..
                                            $active = 0;
                                            $msg = lang("Mail Adresinize bir aktivasyon kodu gönderilmiştir. Üyeliğinizi aktif hale getirmek için posta kutunuzu kontrol ediniz!");
                                            $activationCode = setToken(rand());

                                            $this->load->library('email');

                                            $config["mailtype"] = "html";
                                            $this->email->initialize($config);

                                            $this->email->from($this->config->item('admin_email'), $this->config->item('admin_name'));
                                            $this->email->to('' . $email . '');
                                            $this->email->subject(lang("Üyelik Aktivasyonu"));
                                            $html = lang("Aramıza Hoşgeldiniz") . "," . $adsoyad . ";<br/>";
                                            $html.= lang("Sitemizdeki üyeliğiniz başarıyla tamamlanmıştır. Üyeliğinizi kullanabilmek için aktif hale getirmeniz gerekmektedir.") . "<br/>";
                                            $html.= lang("Üyeliğinizi aktif hale getirmek için aşağıdaki linke tıklayın yada sitemize girerek aktivasyon kodunu giriniz.") . "<br/><br/>";
                                            $html.= lang("Aktivasyon Bilgileri") . "<br/>";
                                            $html.="<b>" . lang("Aktivasyon Kodu") . "</b><br/>";
                                            $html.="" . $activationCode . "<br/>";

                                            $html.="<b>" . lang("Aktivasyon Link") . "</b><br/>";
                                            $html.="" . base_url() . "account/activation?email=" . $email . "&code=" . $activationCode . "<br/><br/>";
                                            $html.="<br/><br/>";
                                            $html.="" . lang("İyi Günler Dileriz") . "<br/>";
                                            $html.=$this->config->item("site_link") . " " . lang("Sitesi Yönetimi") . "<br/>";
                                            $this->email->message($html);
                                            $this->email->send();
                                        } else {
                                            //Aktivasyon İstenmiyor.. Kullanıcı Aktif
                                            $active = 1;
                                            $activationCode = "";
                                            $msg = lang("Üyeliğiniz Aktifleştirildi. Kullanıcı Adı ve Şifrenizle Giriş Yapabilirsiniz... ");

                                            $this->load->library('email');

                                            $config["mailtype"] = "html";
                                            $this->email->initialize($config);

                                            $this->email->from($this->config->item('admin_email'), $this->config->item('admin_name'));
                                            $this->email->to('' . $email . '');
                                            $this->email->subject($this->session->userdata("site_link") . " " . lang("Üyelik"));
                                            $html = lang("Aramıza Hoşgeldiniz") . "," . $adsoyad . ";<br/>";
                                            $html.= lang("Sitemizdeki üyeliğiniz başarıyla tamamlanmıştır. Üyeliğiniz Aktif Hale Getirilmiştir.") . "<br/>";
                                            $html.= lang("Üyelik Bilgileriniz") . "<br/>";
                                            $html.="<b>" . lang("E-posta Adresiniz") . ":</b><br/>";
                                            $html.="" . $email . "<br/>";
                                            $html.="<b>" . lang("Şifreniz") . ":</b><br/>";
                                            $html.="" . $password . "<br/><br/>";

                                            $html.="<br/><br/>";
                                            $html.="" . lang("İyi Günler Dileriz") . "<br/>";
                                            $html.=$this->config->item("site_link") . " " . lang("Sitesi Yönetimi") . "<br/>";
                                            $this->email->message($html);
                                            $this->email->send();
                                        }

                                        //Kullanıcı Kaydı
                                        $insert = $this->db->query("INSERT INTO site_users VALUES ('','1','" . $email . "','" . md5($password) . "','" . $adsoyad . "',NOW(),NOW(),'" . $active . "','" . $activationCode . "')");
                                        $user_id = $this->db->insert_id();
                                        $update = $this->db->query("INSERT INTO site_user_kisisel VALUES ('" . $user_id . "','" . $cinsiyet . "','" . $medenihal . "','" . $dogumtarihi . "','')");
                                        if ($user_id > 0) {
                                            echo '{"success":"true","active":"' . $active . '","email":"' . $email . '","msg":"' . $msg . '"}';
                                        } else {
                                            echo '{"success":"false","msg":"' . lang("Hata: Kaydınız Yapılamadı!") . '"}';
                                        }
                                    } else {
                                        echo '{"success":"false","msg":"' . lang("Email Adresiniz Sistemimizde Kayıtlı Gözüküyor! Başka bir email adresi ile giriş yapın ya da daha önceden üye iseniz şifremiz unuttum bölümünden yeni bir şifre talep edebilirsiniz!") . '"}';
                                    }
                                } else {
                                    echo '{"success":"false","msg":"' . lang("Doğum Tarihinizi Giriniz!") . '"}';
                                }
                            } else {
                                echo '{"success":"false","msg":"' . lang("Girmiş olduğunuz şifreleriniz birbiri ile uyuşmuyor!") . '"}';
                            }
                        } else {
                            echo '{"success":"false","msg":"' . lang("Şifre Tekrarını Giriniz!") . '"}';
                        }
                    } else {
                        echo '{"success":"false","msg":"' . lang("Şifrenizi Giriniz!") . '"}';
                    }
                } else {
                    echo '{"success":"false","msg":"' . lang("E-posta Adresinizi Giriniz!") . '"}';
                }
            } else {
                echo '{"success":"false","msg":"' . lang("Adınızı ve Soyadınızı Giriniz!") . '"}';
            }
        } else {
            echo '{"success":"false","msg":"' . lang("Güvenlik Kodunu Yanlış Girdiniz!") . '"}';
        }
    }

    function kurumsalSave() {
        $adsoyad = $this->input->post("adsoyad");
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $password2 = $this->input->post("password2");
        $name = $this->input->post("name");
        $category = $this->input->post("category");
        $il = $this->input->post("il");
        $ilce = $this->input->post("ilce");
        $sabittel = $this->input->post("sabittel");
        $ceptel = $this->input->post("ceptel");
        $faks = $this->input->post("faks");
        $firmaemail = $this->input->post("firmaemail");
        $adres = $this->input->post("adres");

        if ($adsoyad != "") {
            if ($email != "") {
                if ($password != "") {
                    if ($password2 != "") {
                        if ($password == $password2) {
                            if ($name != "") {
                                if ($category != "") {
                                    $query = $this->db->query("SELECT id FROM site_users WHERE email='" . $email . "'");
                                    if ($query->num_rows() < 1) {

                                        if ($this->config->item("user_activate") == "1") {
                                            //Aktivasyon isteniyor..
                                            $active = 0;
                                            $msg = lang("Mail Adresinize bir aktivasyon kodu gönderilmiştir. Üyeliğinizi aktif hale getirmek için posta kutunuzu kontrol ediniz!");
                                            $activationCode = setToken(rand());

                                            $this->load->library('email');

                                            $config["mailtype"] = "html";
                                            $this->email->initialize($config);

                                            $this->email->from($this->config->item('admin_email'), $this->config->item('admin_name'));
                                            $this->email->to('' . $email . '');
                                            $this->email->subject(lang("Üyelik Aktivasyonu"));
                                            $html = lang("Aramıza Hoşgeldiniz") . "," . $adsoyad . ";<br/>";
                                            $html.= lang("Sitemizdeki üyeliğiniz başarıyla tamamlanmıştır. Üyeliğinizi kullanabilmek için aktif hale getirmeniz gerekmektedir.") . "<br/>";
                                            $html.= lang("Üyeliğinizi aktif hale getirmek için aşağıdaki linke tıklayın yada sitemize girerek aktivasyon kodunu giriniz.") . "<br/><br/>";
                                            $html.= lang("Aktivasyon Bilgileri") . "<br/>";
                                            $html.="<b>" . lang("Aktivasyon Kodu") . "<b><br/>";
                                            $html.="" . $activationCode . "<br/><br/>";

                                            $html.="<b>" . lang("Aktivasyon Link") . "<b><br/>";
                                            $html.="" . base_url() . "account/activation?email=" . $email . "&code=" . $activationCode . "<br/><br/>";
                                            $html.="<br/><br/>";
                                            $html.="" . lang("İyi Günler Dileriz") . "<br/>";
                                            $html.=$this->config->item("site_link") . " " . lang("Sitesi Yönetimi") . "<br/>";
                                            $this->email->message($html);
                                            $this->email->send();
                                        } else {
                                            //Aktivasyon İstenmiyor.. Kullanıcı Aktif
                                            $active = 1;
                                            $activationCode = "";
                                            $msg = lang("Üyeliğiniz Aktifleştirildi. Kullanıcı Adı ve Şifrenizle Giriş Yapabilirsiniz... ");

                                            $this->load->library('email');

                                            $config["mailtype"] = "html";
                                            $this->email->initialize($config);

                                            $this->email->from($this->config->item('admin_email'), $this->config->item('admin_name'));
                                            $this->email->to('' . $email . '');
                                            $this->email->subject($this->session->userdata("site_link") . " " . lang("Üyelik"));
                                            $html = lang("Aramıza Hoşgeldiniz") . "," . $adsoyad . ";<br/>";
                                            $html.= lang("Sitemizdeki üyeliğiniz başarıyla tamamlanmıştır. Üyeliğiniz Aktif Hale Getirilmiştir.") . "<br/>";
                                            $html.= lang("Üyelik Bilgileriniz") . "<br/>";
                                            $html.="<b>" . lang("E-posta Adresiniz") . ":</b><br/>";
                                            $html.="" . $email . "<br/>";
                                            $html.="<b>" . lang("Şifreniz") . ":</b><br/>";
                                            $html.="" . $password . "<br/><br/>";

                                            $html.="<br/><br/>";
                                            $html.="" . lang("İyi Günler Dileriz") . "<br/>";
                                            $html.=$this->config->item("site_link") . " " . lang("Sitesi Yönetimi") . "<br/>";
                                            $this->email->message($html);
                                            $this->email->send();
                                        }

                                        //Kullanıcı Kaydı
                                        $insert = $this->db->query("INSERT INTO site_users VALUES ('','2','" . $email . "','" . md5($password) . "','" . $adsoyad . "',NOW(),NOW(),'" . $active . "','" . $activationCode . "')");
                                        $user_id = $this->db->insert_id();
                                        $update = $this->db->query("INSERT INTO site_firma VALUES ('','" . $user_id . "','" . $name . "','','" . $il . "','" . $ilce . "','','" . $category . "','" . $sabittel . "','" . $ceptel . "','" . $email . "','" . $adres . "','" . $faks . "',NOW(),NOW(),'1','" . $adsoyad . "','0','','1')");
                                        if ($user_id > 0) {
                                            echo '{"success":"true","active":"' . $active . '","email":"' . $email . '","msg":"' . $msg . '"}';
                                        } else {
                                            echo '{"success":"false","msg":"' . lang("Hata: Kaydınız Yapılamadı!") . '"}';
                                        }
                                    } else {
                                        echo '{"success":"false","msg":"' . lang("Email Adresiniz Sistemimizde Kayıtlı Gözüküyor! Başka bir email adresi ile giriş yapın ya da daha önceden üye iseniz şifremiz unuttum bölümünden yeni bir şifre talep edebilirsiniz!") . '"}';
                                    }
                                } else {
                                    echo '{"success":"false","msg":"' . lang("Firmanızın Kategorisini Giriniz!") . '"}';
                                }
                            } else {
                                echo '{"success":"false","msg":"' . lang("Firmanızın Adını Giriniz!") . '"}';
                            }
                        } else {
                            echo '{"success":"false","msg":"' . lang("Girmiş olduğunuz şifreleriniz birbiri ile uyuşmuyor!") . '"}';
                        }
                    } else {
                        echo '{"success":"false","msg":"' . lang("Şifre Tekrarını Giriniz!") . '"}';
                    }
                } else {
                    echo '{"success":"false","msg":"' . lang("Şifrenizi Giriniz!") . '"}';
                }
            } else {
                echo '{"success":"false","msg":"' . lang("E-posta Adresinizi Giriniz!") . '"}';
            }
        } else {
            echo '{"success":"false","msg":"' . lang("Adınızı ve Soyadınızı Giriniz!") . '"}';
        }
    }

    function getIls() {
        $data = array();
        $query = $this->db->query("SELECT id,ad FROM il WHERE ulke_id='1'");
        foreach ($query->result() as $row) {
            $data[$row->id] = $row->ad;
        }
        return $data;
    }

    function getIlces($id="1") {
        $data = array();
        $cond = ($id == "") ? "" : " WHERE il_id='" . $id . "'";
        $query = $this->db->query("SELECT id,ad FROM ilce " . $cond . " ORDER BY ad ");
        foreach ($query->result() as $row) {
            $data[$row->id] = $row->ad;
        }
        return $data;
    }

    function getIlcesJson() {
        $id = $this->input->post("id");
        $cond = " WHERE il_id='" . $id . "'";
        $query = $this->db->query("SELECT id,ad FROM ilce " . $cond . " ORDER BY ad ");
        echo '{"success":"true","data":' . json_encode($query->result()) . '}';
    }

    function forgotPassword() {
        $email = $this->input->post("email");

        $query = $this->db->query("SELECT id,email,adsoyad,type FROM site_users WHERE email=" . $this->db->escape($email) . "");
        if ($email != "") {
            if ($query->num_rows() == 1) {

                $newPass = rand(100000, 999999);
                $query = $this->db->query("UPDATE site_users SET password='" . md5($newPass) . "' WHERE email=" . $this->db->escape($email) . " ");

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
                $html.="" . $newPass . "<br/>";
                $html.="<br/><br/>";
                $html.="" . lang("İyi Günler Dileriz") . "<br/>";
                $html.=$this->config->item("site_link") . " " . lang("Sitesi Yönetimi") . "<br/>";
                $this->email->message($html);
                $this->email->send();


                echo '{"success":"true"}';
            } else {
                echo '{"success":"false","msg":"' . lang("E-Posta Adresiniz sitemizde kayıtlı değildir.!") . '"}';
            }
        } else {
            echo '{"success":"false","msg":"' . lang("E-posta Adresinizi giriniz!") . '"}';
        }
    }

    function activationCheck() {
        $email = $this->input->post("email");
        $code = $this->input->post("activationcode");

        $query = $this->db->query("SELECT id FROM site_users WHERE email='" . $email . "' AND activationcode='" . $code . "'");
        if ($query->num_rows() == 1) {
            $row = $query->row();
            $this->db->query("UPDATE site_users SET active='1' WHERE email='" . $email . "' AND activationcode='" . $code . "'");
            echo '{"success":"true"}';

            $this->load->library('email');

            $config["mailtype"] = "html";
            $this->email->initialize($config);

            $this->email->from($this->config->item('admin_email'), $this->config->item('admin_name'));
            $this->email->to('' . $email . '');
            $this->email->subject(lang("Üyeliğiniz Aktifleştirildi."));
            $html = lang("Aramıza Hoşgeldiniz") . "," . $adsoyad . ";<br/>";
            $html.= lang("Üyeliğiniz Başarıyla Aktif Hale Getirilmiştir.") . "<br/>";
            $html.= "<a href='" . lang("site_link") . "login'>" . lang("Sitemize Giriş yapmak için tıklayın.") . "</a><br/><br/>";
            $html.="<br/><br/>";
            $html.="" . lang("İyi Günler Dileriz") . "<br/>";
            $html.=$this->config->item("site_link") . " " . lang("Sitesi Yönetimi") . "<br/>";
            $this->email->message($html);
            $this->email->send();
        } else {
            echo '{"success":"false","msg":"' . lang("E-Posta Adresi veya aktivasyon kodunuz hatalı. Eğer sorun olduğunu düşünüyorsanız müşteri temsilcilerimiz ile görüşebilirsiniz.") . '"}';
        }
    }

}

?>
