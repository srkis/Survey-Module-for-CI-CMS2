<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {      
    
    public function check_users($username, $password){
        $this ->db->select('username, password');
        $this ->db->from('users');
        $this ->db->where('username', $username);
        $this ->db->where('password', MD5($password));
        $this ->db->limit(1);
 
        $query = $this->db->get();


        if($query->num_rows() == 1) {

          return TRUE;      
          }else{
          return FALSE;
        }

      }


      function exists($fields) {

          $query = $this->db->get_where('users', $fields, 1, 0);

            if($query->num_rows() == 1)
                   return TRUE;
            else
                    return FALSE;
        }



   public function showComments($survey_id, $limit){ 
               $this->db->select('survey_comments, username');
               $this->db->join('users', 'users.id = survey_user_answer.user_id');
               $this->db->where('survey_pitanje_id' , $survey_id);
               $this->db->order_by('survey_comments', 'desc'); 
               $comments = $this->db->get('survey_user_answer', $limit)->result();

                return  $comments;

          }


    public function checkUserKey($key){

        $this->db->select('key');
        $this->db->from("users");
        $this->db->where('key', $key);
        $user_key = $this->db->get()->row();

        if (empty($user_key)) {
                return FALSE;
             }

             if($user_key->key == $key){

                return TRUE;

             }else{

                return FALSE;
        }

    }


}
 
 

