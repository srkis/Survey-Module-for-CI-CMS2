<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anketa_model extends CI_Model {
 

        public function getQuestions() {
            $this->db->select();
            $this->db->from("survey_question");
            $pitanja = $this->db->get()->result();

            $this->db->select();
            $this->db->from("survey_answers");
            $odgovori = $this->db->get()->result();


           foreach ($pitanja as &$pitanje){
               foreach ($odgovori as $odgovor){

                   if($odgovor->pitanje_id == $pitanje->pitanje_id)
                      $pitanje->odgovori[] = $odgovor;

               }
           }

           return $pitanja;

        }


       public function checkActiveSurvey() {
            $this->db->select('status');
            $this->db->from("survey_question");
            $this->db->where("status", '1');
            $check = $this->db->get()->result();


       }

       public function showActiveSurvey() {
        
            $this->db->select('pitanje, pitanje_id');
            $this->db->from("survey_question");
            $this->db->where("status", '1');
            $pitanja = $this->db->get()->result();

            $this->db->select();
            $this->db->from("survey_answers");
            $odgovori = $this->db->get()->result();

            /*
            $this->db->from("survey");
            $this->db->join('survey_question', 'survey_question.survey_id = survey.id');
            $this->db->join('survey_answers', 'survey_answers.question_id = survey_question.question_id');
            $this->db->where('survey.id',1);
             */

           foreach ($pitanja as &$pitanje){
               foreach ($odgovori as $odgovor){

                   if($odgovor->pitanje_id == $pitanje->pitanje_id)
                      $pitanje->odgovori[] = $odgovor;

               }
           }

           return $pitanja;


        }

        public function show_user_answers(){

            $this->db->select();
            $this->db->from('survey_user_answer');
            $this->db->join('survey_question', 'survey_question.pitanje_id = survey_user_answer.survey_odgovor_id');
            $this->db->join('survey_answers', 'survey_answers.odgovor_id= survey_user_answer.survey_pitanje_id');
            
          
            
            $answers = $this->db->get()->result();

            return  $answers;
        }



            //Metoda za insert i update
        public function save($data){

                $table_row_count = $this->db->count_all('survey_question');

               //proveravamo dali ima id ankete, ako  nemamo radi insert - na else, ako imamo radimo update


               if (array_key_exists("pitanje_id",$data)  && !empty($data['pitanje_id'])){
               $pitanje_id =  (int) $data['pitanje_id'];

                // Ako hocemo da aktiviramo anketu sa edita, smestamo status na 0 da deaktiviramo aktivnu anketu 
                if($data['check'] == 1){
                        $niz_status = array(
                           'status' => 0
                       );
                        $this->db->where('status', 1);
                        $this->db->update('survey_question', $niz_status);
                  }


              // ovde radimo update 
                    $survey = array(
                        'description' => $data['body'] ,
                        'pitanje' =>  $data['pitanje'] ,
                        'status' => $data['check']
              );

                  $this->db->where('pitanje_id', (int)$pitanje_id);
                  $this->db->update('survey_question', $survey);

                      // Update offered answers

                       // $name = $data;

                        foreach ($data['answer'] as $odgovor_id=>$pitanje){

                        $survey1 = array(
                            'ponudjeni_odgovori' => $pitanje

                       );

                            $this->db->where('odgovor_id', $odgovor_id);
                            $this->db->update('survey_answers', $survey1);

                        }


                        if(isset($data['newanswer'])){

                        foreach ($data['newanswer'] as $pitanje){
                                $insert = array(
                                        'ponudjeni_odgovori' => $pitanje,
                                        'pitanje_id' => $pitanje_id 
                                     );
                                $this->db->insert('survey_answers', $insert);
                            }
                        }

                }else{
                            //Insert

                             // Proveravamo dali je checkbox cekiran za aktivaciju ankete, ako jeste radimo update u bazi i stavljamo svima status na 0, a ovoj anketi status na 1


                        if($data['check'] == 1){

                             $niz_status = array(
                            'status' => 0
                       );

                            $this->db->where('status', 1);
                            $this->db->update('survey_question', $niz_status);
                }


                        $survey = array(
                            'description' => $data['body'] ,
                            'pitanje' => $data['pitanje'],
                            'status' => $data['check']
                         );

                        $insert =  $this->db->insert('survey_question', $survey);

                        $question_id = $this->db->insert_id();

                        //Insert answers

                      // $name = $_POST;

                        foreach ($data['answer'] as $pitanje){

                        $survey1 = array(
                            'ponudjeni_odgovori' => $pitanje,
                             'pitanje_id' => $pitanje_id
                       );
                         $insert =  $this->db->insert('survey_answers', $survey1);
                    }

                    return $insert;
            }

        }



           //Metoda za promenu status ankete
        public function changeStatus(int $id){
                $data = array(
                  'status' => 0
              );

               $update  = $this->db->update('survey_question', $data);

                 $data1 = array(
                   'status' => 1
            );

                $this->db->where('pitanje_id', (int)$id);
                $update  = $this->db->update('survey_question', $data1);

                return $update;
          }


        public function deleteSurvey(int $delete_id){

                    // proveravamo dali je anketa aktivna, ako jeste vracamo false i poruku u kojoj obavestavamo admina da ne moze obrisati aktivnu anketu.
                $query =  $this->db->get_where('survey_question', array('pitanje_id' => (int)$delete_id))->result();
                foreach ($query as $row){ 
                   $row->status; 

                 }


                 if($row->status ==NULL || $row->status == 0){  // ako nije aktivirana anketa

                $this->db->delete('survey_question', array('pitanje_id' => (int)$delete_id)); 
                $this->db->delete('survey_user_answer', array('survey_odgovor_id' => (int)$delete_id));
                $this->db->delete('survey_answers', array('pitanje_id' => (int)$delete_id)); 
               return true;

            }elseif($row->status ==1){

                return false;
               // $this->db->where('question_id', $delete_id);
               // $delete = $this->db->delete('survey_question', $data);

               //return $delete;
          }
        }
                // Metoda za edit ankete po ID-ju.
        public function editSurvey($edit_id){

              $this->db->select();
              $this->db->from("survey_question");
              $this->db->where("pitanje_id", (int)$edit_id);
              $pitanja = $this->db->get()->result();

              $this->db->select();
              $this->db->from("survey_answers");
              $this->db->where("pitanje_id", (int)$edit_id);
              $odgovori = $this->db->get()->result();

           foreach ($pitanja as $pitanje){
               foreach ($odgovori as $odgovor){

                if($odgovor->pitanje_id != $edit_id){
                     return FALSE;
                     die;
                }

                 if($odgovor->pitanje_id == $pitanje->pitanje_id)
                      $pitanje->odgovori[] = $odgovor;
               }
           }
           return $pitanja;
          }



          
          
          
          
          
          
                    //Metoda za prebrojavanje rezulata po ID-ju ankete
        public function countAnswers($pitanje_id){

                    $this->db->select('survey_odgovor_id, COUNT(survey_odgovor_id) as total, ponudjeni_odgovori');
                    $this->db->join('survey_answers', 'survey_answers.odgovor_id = survey_user_answer.survey_odgovor_id');
                    $this->db->where("survey_pitanje_id",  (int)$pitanje_id);
                    $this->db->group_by('survey_odgovor_id');
                    $this->db->order_by('total', 'desc'); 
                    $odgovori = $this->db->get('survey_user_answer')->result();

                return $odgovori;
           }


        public function disableSurvey($survey_id){
                $data = array(
               'status' => 0
              );

//            $table_row_count = $this->db->count_all('survey_question');

//                if($table_row_count <= 1){
//                    return false;
//                }else{
//
//                }

               $update  = $this->db->update('survey_question', $data);

                return $update;

          }

        public function enableSurvey(int $survey_id){
                $data = array(
               'status' => 1
              );

               $update  = $this->db->update('survey_question', $data);

                return $update;

             }


           public function  checkUserIp($user_ip){

              $this->db->select('user_ip');
              $this->db->from("survey_user_answer");
              $this->db->where('user_ip', $user_ip);
              $ip = $this->db->get();    

               if($ip->num_rows() > 0){

                return FALSE;

               }else{

                   return TRUE;
               }
        } 

          public function  checkUserVoteTime($ip){
                 $this->db->select('vote_time');
                 $this->db->from("survey_user_answer");
                 $this->db->where('user_ip', $ip);
                 $this->db->order_by('vote_time', 'DESC');
                 $vote_time = strtotime($this->db->get()->row('vote_time'));

                 $vote_time = $vote_time + USER_VOTE_TIME;
                 $current_time = time();

                 if($current_time > $vote_time){
                     return TRUE;
                 }else {
                     return FALSE;
                 }

          }


       function calculate_time($date) {
            $seconds = strtotime($date) - strtotime(date('H:i:s')) ;

            $months = floor($seconds / (3600 * 24 * 30));
            $day = floor($seconds / (3600 * 24));
            $hours = floor($seconds / 3600);
            $mins = floor(($seconds - ($hours * 3600)) / 60);
            $secs = floor($seconds % 60);
            if ($seconds < 60){
                $time = $secs . " seconds ";
            }else if ($seconds < 60 * 60){
               $time = $mins . " min";
            }else if ($seconds < 24 * 60 * 60){
               $time = $hours . " hours ";
            }else if ($seconds < 24 * 60 * 60){
                $time = $day . " day ";
            }else{
                $time = $months . " month ";
            }

                return $time;

       }

          //metoda za dobavljanje ponudjenih odgovora po ID-ju ankete
        public function getAnswersbySurveyId($survey_id){
                $this->db->select();
                $this->db->from("survey_answers");
                $this->db->where("pitanje_id", (int)$survey_id);
                 $odgovori = $this->db->get()->result();

                return $odgovori;

             }


    }


