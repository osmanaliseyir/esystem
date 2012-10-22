<?php

/*    Kemal GOKBAS   */
/*    in 2008   			 */
/*    Upload Class           */
/*                           */

class upload_photo {

    var $upload;
    var $uploaddir;
    var $uploaded_name;
    var $upload_file;
    //uzantısız hali
    var $image_name;
    var $image_extension;
    var $img_type;
    var $extensions;
    //eni mi sabit boyumu
    var $image_resize_type;
    var $new_width;
    var $new_height;
    var $save_dir;
    var $new_name;
    //thumb ayarları
    var $thumb_resize_type;
    var $thumb;
    var $thumb_new_width;
    var $thumb_new_height;
    //kaydedilecek yer thumb i�in
    var $thumb_save_dir;
    //thumb ın yeni ismi
    var $thumb_new_name;
    public $result;

    //ilk yüklenecek yer
    function set_dir($uploaddir) {
        $this->uploaddir = $uploaddir;
    }

    //biçimlendikten sonra kaydedileceği yer
    function set_save_dir($save_dir) {
        $this->save_dir = $save_dir;
    }

    //image resize type
    function set_image_resize_type($image_resize_type) {
        $this->image_resize_type = $image_resize_type;
    }

    //thumb type
    function set_thumb_resize_type($thumb_resize_type) {
        $this->thumb_resize_type = $thumb_resize_type;
    }

    //thumb kaydedileceği  klasor
    function set_thumb_save_dir($thumb_save_dir) {
        $this->thumb_save_dir = $thumb_save_dir;
    }

    //upload yapılıyor
    function single_upload_file() {

        $uploadfile = $this->uploaddir . basename($_FILES[$this->uploaded_name]['name']);
        $this->upload_file = $uploadfile;

        $this->img_type = $_FILES[$this->uploaded_name]['type'];


        if ($_FILES[$this->uploaded_name]['name'] == "") {
            $this->result = $this->errors(1);
            return false;
        } else {

            //klasor varmı diye kontrol ediyoruz
            $this->check_dir($this->uploaddir);

            //ismi gözden geçiriliyor
            $this->rename_image(basename($uploadfile));

            //uzantı kontrol ediliyor
            $this->get_extension();

            //uzantıya izin veriliyor mu
            if ($this->extensions != "") {
                if ($this->allowed_extensions($this->extensions) === false) {
                    return false;
                }
            }

            //aynı isimde resim var mı?
            $this->exist_file($this->uploaddir);

            //upload ediliyor
            if (move_uploaded_file($_FILES[$this->uploaded_name]['tmp_name'], $this->uploaddir . basename($this->upload_file))) {
                $this->result = $this->errors(2);
                /// Resim yüklendi
            } else {
                $this->result = $this->errors(3);
            }
        }

        return basename($this->upload_file);
    }

    function multi_upload_file($key) {

        $new_upload = $this->re_array($_FILES[$this->uploaded_name]);


        $uploadfile = $this->uploaddir . $new_upload[$key]['name'];
        $this->upload_file = $uploadfile;

        //$this->img_type=$_FILES[$this->uploaded_name]['type'];

        if ($new_upload[$key]['name'] == "") {
            $this->result = $this->errors(1);
            return false;
        } else {

            //klasor varmı diye kontrol ediyoruz
            $this->check_dir($this->uploaddir);

            //ismi gözden geçiriliyor
            $this->rename_image(basename($uploadfile));

            //uzantı kontrol ediliyor
            $this->get_extension();

            //uzantıya izin veriliyor mu
            if ($this->extensions != "") {
                if ($this->allowed_extensions($this->extensions) === false) {
                    return $this->errors(5);
                }
            }

            //aynı isimde resim var mı?
            $this->exist_file($this->uploaddir);

            //upload ediliyor
            if (move_uploaded_file($new_upload[$key]['tmp_name'], $this->uploaddir . basename($this->upload_file))) {
                $this->result = $this->errors(2);
                /// Resim yüklendi
            } else {
                $this->result = $this->errors(3);
            }
        }
        return basename($this->upload_file);
    }

    function re_array($file_post) {

        $files_array = array();
        $count = count($file_post['name']);

        if (is_array($file_post)) {
            $file_keys = array_keys($file_post);

            for ($i = 0; $i < $count; $i++) {
                foreach ($file_keys as $key) {
                    $files_array[$i][$key] = $file_post[$key][$i];
                }
            }
        }
        return $files_array;
    }

    //image yeniden boyutlanıyor
    function resize_image() {

        $filename = $this->uploaddir . basename($this->upload_file);


        //image in genişliği ve yüksekliği
        list($width_orig, $height_orig) = getimagesize($filename);
        $ratio_orig = $width_orig / $height_orig;

        //sabit olan genişlik mi yükseklik mi?
        $type = $this->image_resize_type;
        if ($type == "width") {
            if ($ratio_orig > (1.5)) {
                //genişliği sabitse
                $width = $this->new_width;
                $height = ($this->new_width / $ratio_orig);
            } else {
                $height = ($this->new_width / (1.5));
                $width = $height * $ratio_orig;
            }
        } else if ($type == "height") {
            //yüksekliği sabitse
            $height = $this->new_height;
            $width = ($this->new_height * $ratio_orig);
        }

        // Resample
        $image_p = imagecreatetruecolor($width, $height);

        // Output
        $save_dir = $filename;
        $fontfile = "public/framd.ttf";

        switch ($this->image_extension) {
            case "jpg":
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                imagejpeg($image_p, $save_dir, 100);
                break;
            case "jpeg":
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                imagejpeg($image_p, $save_dir, 100);
                break;
            case "pjpeg":
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                imagejpeg($image_p, $save_dir, 100);
                break;
            case "png":
                $quality = 9; // PHP 5.1 den sonra kalite 0-9 aras�nda oluyor ( Sadece PNG i�in )
                $image = imagecreatefrompng($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                imagepng($image_p, $save_dir, 9);
                break;
            case "gif":
                $image = imagecreatefromgif($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                imagegif($image_p, $save_dir, 100);
                break;

            default:
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($image_p, $save_dir, 100);
        }
    }

    function create_thumb() {

        $filename = $this->uploaddir . basename($this->upload_file);

        //klasor var mı?
        $this->check_dir($this->thumb_save_dir);

        //image in genişliği ve yüksekliği
        list($width_orig, $height_orig) = getimagesize($filename);
        $ratio_orig = $width_orig / $height_orig;



        //sabit olan genişlik mi yükseklik mi?
        $type = $this->thumb_resize_type;
        if ($type == "width") {
            if ($ratio_orig > (1.5)) {
                //genişliği sabitse
                $width = $this->thumb_new_width;
                $height = ($this->thumb_new_width / $ratio_orig);
            } else {
                $height = ($this->thumb_new_width / (1.5));
                $width = $height * $ratio_orig;
            }
        } else if ($type == "height") {
            //yüksekliği sabitse
            $height = $this->thumb_new_height;
            $width = ($this->thumb_new_height * $ratio_orig);
        }

        // Resample
        $image_p = imagecreatetruecolor($width, $height);

        // Output
        $save_dir = $this->thumb_save_dir . basename($filename);


        switch ($this->image_extension) {
            case "jpg":
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($image_p, $save_dir, 100);
                break;
            case "jpeg":
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($image_p, $save_dir, 100);
                break;
            case "pjpeg":
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($image_p, $save_dir, 100);
                break;
            case "png":
                $quality = 9; // PHP 5.1 den sonra kalite 0-9 aras�nda oluyor ( Sadece PNG i�in )
                $image = imagecreatefrompng($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagepng($image_p, $save_dir, 9);
                break;
            case "gif":
                $image = imagecreatefromgif($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagegif($image_p, $save_dir, 100);
                break;

            default:
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($image_p, $save_dir, 100);
        }
    }

    function check_dir($dir) {
        if (is_dir($dir)) {
            return true;
        } else {
            if (mkdir($dir)) {
                return true;
            } else {
                return false;
            }
        }
    }

    function get_extension() {
        $filename = $this->upload_file;

        $extension = strrchr($filename, ".");
        $extension = str_replace(".", "", $extension);
        $filename = substr_replace($filename, "", -(strlen($extension)), strlen($extension));


        $image_name = str_replace(".", "", $filename);
        $this->image_name = $image_name;
        $this->image_extension = strtolower($extension);
    }

    function allowed_extensions() {
        if (is_array($this->extensions) and count($this->extensions) > 0) {
            if (in_array($this->image_extension, $this->extensions)) {
                return true;
            } else {
                $this->result = $this->errors(5);
                exit();
                return false;
            }
        }
    }

    function exist_file($dir) {

        $filename = basename($this->upload_file);
        if (file_exists($dir . $filename)) {
            $rand_num = rand(0, 1000);
            $this->upload_file = $this->image_name . "_" . $rand_num . "." . $this->image_extension;
            return false;
        } else {
            return true;
        }
    }

    function rename_image($image_name) {
        $turk = array(" ", "ı", "İ", "ö", "Ö", "ş", "Ş", "ğ", "Ğ", "ç", "Ç", "ü", "Ü");
        $eng = array("_", "I", "i", "o", "O", "s", "S", "g", "G", "c", "C", "u", "U");
        $image_name = str_replace($turk, $eng, $image_name);
        $this->upload_file = $this->uploaddir . $image_name;
    }

    function errors($error_no) {
        $error[1] = "Resim Seçmelisiniz";
        $error[2] = "Resim Başarıyla Yüklenmiştir.";
        $error[3] = "Yüklenemedi.";
        $error[4] = "Bu dosya Mevcut";
        $error[5] = lang("Bu uzantıya izin verilmiyor");

        return $error[$error_no];
    }

    function CroppedThumbnail($thumbnail_width, $thumbnail_height) { //$imgSrc is a FILE - Returns an image resource.
        $imgSrc = $this->uploaddir . basename($this->upload_file);

        //klasor var mı?
        $this->check_dir($this->thumb_save_dir);

        //getting the image dimensions 
        list($width_orig, $height_orig) = getimagesize($imgSrc);


        switch ($this->image_extension) {
            case "jpg":
                $myImage = imagecreatefromjpeg($imgSrc);
                break;
            case "png":
                $quality = 9; // PHP 5.1 den sonra kalite 0-9 aras�nda oluyor ( Sadece PNG i�in )
                $myImage = imagecreatefrompng($imgSrc);
                break;
            case "gif":
                $myImage = imagecreatefromgif($imgSrc);
                break;

            default:
                $myImage = imagecreatefromjpeg($imgSrc);
        }



        $ratio_orig = $width_orig / $height_orig;

        if ($thumbnail_width / $thumbnail_height > $ratio_orig) {
            $new_height = $thumbnail_width / $ratio_orig;
            $new_width = $thumbnail_width;
        } else {
            $new_width = $thumbnail_height * $ratio_orig;
            $new_height = $thumbnail_height;
        }

        $x_mid = $new_width / 2;  //horizontal middle
        $y_mid = $new_height / 2; //vertical middle

        $process = imagecreatetruecolor(round($new_width), round($new_height));

        imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
        $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresampled($thumb, $process, 0, 0, ($x_mid - ($thumbnail_width / 2)), ($y_mid - ($thumbnail_height / 2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);

        // Output
        $save_dir = $this->thumb_save_dir . basename($imgSrc);


        switch ($this->image_extension) {
            case "jpg":
                imagejpeg($thumb, $save_dir, 100);
                break;
            case "png":
                $quality = 9; // PHP 5.1 den sonra kalite 0-9 aras�nda oluyor ( Sadece PNG i�in )
                imagepng($thumb, $save_dir, 9);
                break;
            case "gif":
                imagegif($thumb, $save_dir, 100);
                break;
            default:
                imagejpeg($thumb, $save_dir, 100);
        }
    }

}

?>