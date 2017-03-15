<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Anketa extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->template['module'] = 'anketa';
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('javascript');
        $this->load->helper('date');
        $this->load->model('Server_model');
        $this->load->model('Api_model');


        $this->form_validation->CI = & $this;
    }

    function index() {

        $this->load->model('Anketa_model');
        $this->template['anketa'] = $this->Anketa_model->showActiveSurvey();
        $this->layout->load($this->template, 'display_questions');
    }

    // Metoda za prihvatanje odgovora sa ankete i unosenje u bazu

    public function insert_user_answers() {

        $ip = $this->input->ip_address();
        $this->load->model('Anketa_model');
        $user_id = (int)$this->id = $this->session->userdata('id');

        $odgovor_id =  (int) $this->input->post('odgovor_id', TRUE);
        $pitanje_id =   (int) $this->input->post('pitanje_id', TRUE);
        $komentar=    $this->input->post('komentar', TRUE);


        $data = array(
            "status" => 0, "message" => 'Error! You can not vote at this time.Please come later.', 'count' => 0
        );

        if ($this->Anketa_model->checkUserVoteTime($ip)) {

                $this->db->set('vote_time', 'NOW()', FALSE);
                $this->db->insert('survey_user_answer', array(
                    "survey_odgovor_id" =>  $odgovor_id,
                    "survey_pitanje_id" => $pitanje_id,
                     "survey_comments" => $komentar,
                     "user_ip" => $ip,
                     "user_id" =>  $user_id,
                ));

                 $data ["message"] = 'Database Error! ';

                if ($this->db->affected_rows() > 0) {

                    $data = array(
                        "status" => 1, "message" => 'Success! Thank you for your vote',
                        "count" => $this->Anketa_model->countAnswers($pitanje_id)
                    );
                }

                // $this->template['data'] = $data;        // proveriti ovo   
         }


        if ($this->input->is_ajax_request()) {

            parse_json($data, $data['status'] ? 200 : 403);
        }

        if (!$data['status']) {    // ako je false
            $this->session->set_flashdata('notification', __('<p style="color:red;"><b>Error! You can not  vote at this time. Please come later</b></p>', $this->template['module']));
            redirect('anketa');
        }

        $this->layout->load($this->template, 'success_message');
    }


    public function widget() {
        $this->load->model('Api_model');
        $this->load->model('Anketa_model');

        parse_json($this->Anketa_model->showActiveSurvey());
    }





    
    
    
    
    
    
    
    
}
