<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends MX_Controller {

	      var $template = array();

            function __construct() {
                    parent::__construct();

                    $this->load->library('administration');
                    $this->load->model('Anketa_model');
                    $this->load->model('Server_model');
                    $this->load->library('form_validation');
                    $this->load->library('security');
                    $this->load->helper('javascript');

                    $this->form_validation->CI =& $this;

                    $this->template['module'] = 'anketa';
                    $this->template['admin']   = true;
                    $this->_init();
            }

            function index() {

                  $this->user->check_level($this->template['module'], LEVEL_VIEW);
                  $this->load->model('Anketa_model');
                  $this->template['anketa'] = $this->Anketa_model->getQuestions();
                  $this->layout->load($this->template, 'admin');
            }

            function _init()  {
                    if (!isset($this->system->login_signup_enabled)) {
                            $this->system->login_signup_enabled = 1;
                }
            }


               // prikazivanje rezultata ankete na adminu (PIE CHART)

        public function showSurveyResult($survey_id){

                $this->load->model('Anketa_model');
                $this->template['data'] = $this->Anketa_model->countAnswers((int)$survey_id);
                $this->layout->load($this->template, 'show_answers');
        }


          public function show_user_Comments($survey_id){

                $this->load->model('User_model');
                parse_json($this->User_model->showComments($survey_id, $limit = 10));
          }


                // Metoda za promenu statusa ankete kada ima vise napravljenih ankteta
        public function change_status( int $id) {

                $this->load->model('Anketa_model');
                $this->template['answers'] = $this->Anketa_model->changeStatus($id);
                $this->session->set_flashdata('notification', __("Survey Enabled", $this->template['module']));
                redirect('admin/anketa');

            }

            // Metoda za Disable ako je napravljena samo jedna anketa (edit_survey)
        public function disable_Survey(int $survey_id){
                $this->load->model('Anketa_model');
                $this->template['answers'] = $this->Anketa_model->disableSurvey($survey_id);
                $this->session->set_flashdata('notification', __("Survey Disabled", $this->template['module']));
                redirect('admin/anketa');

          }


            //Metoda za brisanje ankete
        public function  delete_survey( int $delete_id) {

                $this->load->model('Anketa_model');
                if($this->template['answers'] = $this->Anketa_model->deleteSurvey($delete_id) == TRUE){      //ako anketa nije aktivirana mozemo da je obrisemo
                        $this->session->set_flashdata('notification', __("Survey Deleted", $this->template['module']));
                        redirect('admin/anketa');

                  //  Ako je anketa aktivirana vracamo false i prikazujemo obavestenje 
                }else{
                        $this->session->set_flashdata('notification', __("<p style='color:red;'><b>Cannot delete active Survey!</b></p>", $this->template['module']));
                        redirect('admin/anketa');
                }
        }

                //Metoda za Insert i Update
         public function save() { 

                $post = $this->security->xss_clean($_POST);
                $answerArr =  $data = $newanswer = array();

               if (array_key_exists("newanswer",$post) && !empty($post['newanswer'])){ 

                   $new = $this->input->post('newanswer', TRUE);

                  foreach ($new as  $new_answer){
                      $newanswer[] = $new_answer;
                  }
              }

                 if (array_key_exists("answer",$post) && !empty($post['answer'])){ 
                     $answer = $this->input->post('answer', TRUE);

                 foreach ($answer as $answer_id => $odgovor ){

                        $answerArr[$answer_id] = $odgovor;

                         $data = array(
                            "pitanje" => $this->input->post('pitanje', TRUE),
                            "pitanje_id" => (int)$this->input->post('pitanje_id', TRUE),
                            "check" => (int)$this->input->post('check', TRUE),
                            "answer" => $answerArr,
                            "newanswer" => $newanswer,
                            "body" => $this->input->post('body' ,TRUE)
                        );
                 }
             }

                    $this->load->model('Anketa_model');
                    $this->template['question'] = $this->Anketa_model->save($data);

                    $this->form_validation->CI =& $this;
                    $this->form_validation->set_rules('body',__('Description', $this->template['module']),"trim|required|min_length[3]|max_length[1200]|xss_clean");
                    $this->form_validation->set_rules('pitanje',__('Pitanje', $this->template['module']),"trim|required");

                    $this->form_validation->set_rules('answer[]', __("Answer ",$this->template['module']), "trim|required");

                    $this->form_validation->set_message('min_length', __('The %s field is required'));
                    $this->form_validation->set_error_delimiters('<p style="color:#900">', '</p>');

                    $this->form_validation->set_message('min_length', __('The %s field is required'));
                    $this->form_validation->set_message('required', __('The %s field is required'));
                    $this->form_validation->set_message('matches', __('The %s field does not match the %s field'));

            if ($this->form_validation->run() ==FALSE)  {
                  $this->layout->load($this->template, 'create');


            } else  {
                         $this->session->set_flashdata('notification', __("Survey successfully created!", $this->template['module']));
                         redirect('admin/anketa');
                     }

         }


            //Metoda za kreiranje nove ankete
        public function create() {
               $this->layout->load($this->template, 'create');

    }

            //Metoda za editovanje ankete
        public function edit_survey( int $edit_id) {

            $this->load->model('Anketa_model');
            $this->template['edit'] =$this->Anketa_model->editSurvey($edit_id);
            $this->layout->load($this->template, 'edit_survey');


    }

                     //Metoda za uklanjanje input polja sa edit strane
        public function remove_input(){
                        $id = $this->input->post('id_pitanja' , TRUE);
                     //  $id = ($_POST['id_pitanja']);
                        $this->db->delete('survey_answers', array('answers_id' => $id)); 
                        $this->session->set_flashdata('notification', __("Survey successfully updated!", $this->template['module']));
                        redirect('admin/anketa/edit_survey');
                    }



       }




?>
