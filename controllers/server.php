<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");
require_once dirname(__FILE__) . '/BACKEND_Controller.php';

class Server extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
        $this->template['module'] = 'anketa';
        $this->load->helper('javascript');
        $this->load->library('servis');
        $this->load->model('Server_model');
        $this->load->library('encrypt');
        $this->load->library('user');
    }

    function index() {
        $parse_format = $this->layout->load($this->template, 'show_api_methods');
    }

    function get($id_anketa = 0) {
        $this->_licence_auth();
        $this->load->model('Api_model');
        $parse_format = $this->Api_model->SurveyApi((int) $id_anketa);
        parse_json($parse_format);
    }

    function post($id_anketa) {
        $this->_licence_auth();
        $ip = $this->input->ip_address();
        $this->load->helper('javascript');
        $this->load->model('Anketa_model');
        $user_id = (int) $this->id = $this->session->userdata('id');
        $odgovor_id = (int) $this->input->post('odgovor_id', TRUE);
        $pitanje_id = (int) $this->input->post('pitanje_id', TRUE);
        $komentar = $this->input->post('komentar', TRUE);

        $data = array(
            "status" => 0, "message" => 'Error! You can not vote at this time.Please come later.', 'count' => 0
        );

        if ($this->Anketa_model->checkUserVoteTime($ip)) {

            $this->db->set('vote_time', 'NOW()', FALSE);
            $this->db->insert('survey_user_answer', array(
                "survey_odgovor_id" => $odgovor_id,
                "survey_pitanje_id" => $pitanje_id,
                "survey_comments" => $komentar,
                "user_ip" => $ip,
                "user_id" => $user_id,
            ));

            $data ["message"] = 'Database Error! ';

            if ($this->db->affected_rows() > 0) {

                $data = array(
                    "status" => 1, "message" => 'Success! Thank you for your vote'
                );
            }
        }

        parse_json($data, $data['status'] ? 200 : 403);
    }


    public function checkUserData() { 

       $headers = getallheaders();

        if (isset($headers['API-KEY']) && isset($headers['Authorization'])) {

            $key = $this->encrypt->decode($headers['API-KEY']);
            $this->load->model("User_model");

            if ($check_key = $this->User_model->checkUserKey($key) == TRUE) {
                $auth = $this->_login_auth();

                if($auth['logged_in'] === TRUE){

                    $this->load->model('Anketa_model');
                    $data['anketa'] = $this->Anketa_model->showActiveSurvey();
                    $this->load->view( 'anketa/display_questions', $data);

                   // parse_json($auth, 200, $auth['logged_in']);
                }

            }else{
                die("<h3 style=color:red;>Neuspesna prijava!</h3>");
            }
        }
    }

}
