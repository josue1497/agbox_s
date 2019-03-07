<?php
/**
 * clase que obtiene la peticion http 
 */
    class Request{
        public $url;
        /**
         * metodo constructor por defecto
         * 
         * @return type
         */
        public function __construct(){
            $this->url = $_SERVER["REQUEST_URI"];
        }
    }
?>