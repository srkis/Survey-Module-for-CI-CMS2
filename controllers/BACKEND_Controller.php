<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class BACKEND_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->template['module'] = 'anketa';
        $this->load->helper('javascript');
        $this->load->model('Anketa_model');
        $this->load->model('Api_model');
        $this->load->library('servis');

    }

             //protected scope when you want to make your variable/function visible in all classes that extend current class including the parent class.
            // metoda za proveru autorizacije
        protected function _licence_auth() {   
           try {
              $this->plugin->apply_filters('servis_auth', '');
          }catch (Exception $e) {
            parse_json(array(
                "status" => 0,
                "message" => $e->getMessage()
                    ), 403);
            }
        }


        protected function _login_auth() {

            try {
               return $this->plugin->apply_filters('login_auth', ''); 

            }catch (Exception $e) {

                parse_json(array(
                    "status" => 0,
                    "message" => $e->getMessage()
                       ), 401);
               }
             }

        function _start_session() {

	$data = array(
                    'id' => $this->id,
                    'username'  => $this->username,
                    'email' => $this->email, 
                    'logged_in' => $this->logged_in,
                    'auto_login'  => '0',
                    'lang'    => $this->lang,
                    'token'    => $this->token
                     );
                 }


        public function checkUserLogin() {
            $this->_login_auth();

      }


}
