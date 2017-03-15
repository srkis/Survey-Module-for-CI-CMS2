<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

    public function getQuestions() {
        $this->db->select();
        $this->db->from("survey_question");
        $pitanja = $this->db->get()->result();

        $this->db->select();
        $this->db->from("survey_answers");
        $odgovori = $this->db->get()->result();


        foreach ($pitanja as &$pitanje) {
            foreach ($odgovori as $odgovor) {

                if ($odgovor->question_id == $pitanje->question_id)
                    $pitanje->odgovori[] = $odgovor;
            }
        }

        return $pitanja;
    }

    public function SurveyApi($pitanje_id) {
        $this->db->from("survey_question");
        $this->db->join('survey_answers', 'survey_answers.pitanje_id = survey_question.pitanje_id');
        $this->db->where('survey_question.pitanje_id', $pitanje_id);
        $data = $this->db->get()->result();

        $result = array();
        foreach ($data as $anketa => $odgovori){
        $result['anketa_id'] =  $odgovori->pitanje_id;
        $result['anketa_pitanje'] = $odgovori->pitanje;
        $result['opis'] =  $odgovori->description;
        $result['status'] = $odgovori->status;

        $result['odgovori'][] = array(
            'id' => $odgovori->odgovor_id,
            'ponudjeni_odgovor'  => $odgovori->ponudjeni_odgovori
        );

    }

        return $result;
    }

    public function  CountApiCalls($client_licence) {
        $this->db->select('COUNT(*) as total');
        $this->db->from("clients");
        $this->db->where('licence', $client_licence);
        $this->db->where('call_service_time >= DATE_SUB(NOW(), INTERVAL 1 HOUR)'); // return all records created within the hour
        $limit = $this->db->get()->row();


        if ($limit->total >= CALL_SERVIS_LIMIT) {

            return FALSE;

        } else {

            return TRUE;
        }
    }

    public function get_Licence($pitanje_id) {
        $this->db->select('licence');
        $this->db->from("clients");
        $this->db->where('survey_id', $pitanje_id);
        $licence = $this->db->get()->row(); //row

        return $licence;
    }

}
