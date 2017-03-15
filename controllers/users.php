<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Users extends CI_Controller {

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
        //$this->load->helper('auth_helper');
        //$this->load->helper('http_helper');

    }

    function index() {
        $this->load->helper('javascript');
        $this->load->model('Api_model');
        $this->load->model('Anketa_model');
        $this->template['anketa'] = $this->Anketa_model->showActiveSurvey();
        $this->layout->load($this->template, 'display_questions');
    }





}