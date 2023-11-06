<?php 

class Information {
    public $file_path = DATA_DIR . 'information.txt';

    public function get() {
        if (file_exists($this->file_path)) {
            $data = file($this->file_path);
            $json = json_encode($data);
            return $json;
        }
    }
}

?>