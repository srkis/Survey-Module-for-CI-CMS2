<?php
 
if (!defined("BASEPATH")) exit("No direct script access allowed");
require_once dirname(__FILE__).'/BACKEND_Controller.php';

class Api extends BACKEND_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('servis');
        $this->load->model('Api_model');
    }


    function index() {
        $this->load->model('Api_model');
        $this->load->model('Anketa_model');
        $this->template['anketa'] = $this->Anketa_model->getQuestions();
        $this->layout->load($this->template, 'api_view');
    }



    public function getApi($pitanje_id = NULL, $format = NULL) {
            $this->_licence_auth();

        if (!filter_var($pitanje_id, FILTER_VALIDATE_INT)) {
            show_404();

            /* echo "<p style='color:red'><b>Not valid URL</b></p>";
              die; */
        }

        $parse_format = $this->Api_model->SurveyApi((int) $pitanje_id);

        if ($parse_format == FALSE) {
            show_404();
            /* echo "<p style='color:red'><b>Not valid URL</b></p>";
              die; */
        }


        switch ($format) {
            case 'xml':
                parse_xml($parse_format);
                break;

            case 'json':
                parse_json($parse_format);
                break;

            case 'html':
                parse_html($parse_format);
                break;

            default:
                show_404();

            /* echo "<p style='color:red'><b>Wrong format! Please try again.</b></p>";
              die; */
        }
    }

    public function getLicence($pitanje_id) {

        if (empty($pitanje_id) && !is_int($pitanje_id)) {

            show_404();
        }

        $get_licence = $this->Api_model->get_Licence((int) $pitanje_id);

        parse_json($get_licence);
    }



}
