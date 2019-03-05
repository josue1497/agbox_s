<?php
//namespace App\Config\Framework;
    class Request{
        public $url;
        public function __construct(){
            $this->url = $_SERVER["REQUEST_URI"];
        }
    }
?>