<?php

$this->set('survey_widget', 'survey_widget');

function survey_widget() {

    $obj = & get_instance();
    $data['module'] = 'anketa';
    $obj->load->model('anketa/anketa_model');
    $id = $obj->anketa_model->showActiveSurvey();
    $survey_id = 0;
    if ($id) {

        foreach ($id as $question_id) {
            $survey_id = $question_id->pitanje_id;
        }
    }
    


     $data['query'] = $obj->anketa_model->countAnswers($survey_id);
     $data['answers'] = $obj->anketa_model->getAnswersbySurveyId($survey_id);
     $data['survey_id'] = $obj->anketa_model->getAnswersbySurveyId($survey_id);
   

    $obj->load->view('blocks/survey', $data);
}

