<?php

class Servis {

    function __construct() {

        $this->obj = & get_instance();
        $this->obj->load->library('encrypt');
        $this->obj->load->library('session');

        $this->obj->load->model('anketa/Api_model', "Api_model");
        $this->obj->load->model('anketa/Server_model', "Server_model");
        $this->obj->load->model('anketa/Anketa_model', "Anketa_model");
        $this->obj->load->model('anketa/User_model', "User_model");
        //this filter allows us to use another type of auth (LDAP etc)
        $this->obj->plugin->add_filter('servis_auth', array(&$this, '_servis_auth'), 30, 2);
        $this->obj->plugin->add_filter('login_auth', array(&$this, '_login_auth'), 30, 2);
    }

    /* Metoda za proveru client licence koja se  salje preko hedera kako bi koristili servis. */

    function _servis_auth() {

        $ip = $this->obj->input->ip_address();

        $headers = getallheaders();

        if (isset($headers['Authorization'])) {

            list($client_licence, $pitanje_id) = explode(":", base64_decode(str_ireplace('Basic ', '', $headers['Authorization'])));

            if ($this->obj->Anketa_model->checkUserVoteTime($ip) == FALSE) {

                throw new Exception('Error! You can not vote at this time.Please come later');
            }

            if ($this->obj->Api_model->CountApiCalls($client_licence) == FALSE) {

                throw new Exception('Forbidden. You are over rate limit. Please come later');
            }

            if ($key = $this->obj->Server_model->clientsLicence($ip, $client_licence)) {

                $this->obj->db->set('call_service_time', 'NOW()', FALSE);
                $this->obj->db->insert('clients', array(
                    "survey_id" => $pitanje_id,
                    "client_ip" => $ip,
                    "licence" => $client_licence
                ));
            } else {
                throw new Exception('Forbidden! Not valid licence key ');
            }
        } else {
            throw new Exception('Forbidden! Not valid licence key');
        }

        return true;
    }



    function _login_auth() {

       

        $headers = getallheaders();

        if (isset($headers['Authorization'])) {


            /*   The list() function is used to assign values to a list of variables in one operation.
             *    This function only works on numerical arrays.
             *    The str_ireplace() function replaces some characters with some other characters in a string.
             *    The explode() function Break a string into an array:   
             */

            list($username, $password) = explode(":", base64_decode(str_ireplace('Basic ', '', $headers['Authorization'])));

            $username = $this->obj->encrypt->decode($username);  // Ove dve linije koda su ubacene za dekripciju zakomentarisati kada se loguje bez cryptovan
            $password = $this->obj->encrypt->decode($password);

            $result['username'] = $username;
            $result['password'] = $password;


            $resullt = $this->obj->plugin->apply_filters('user_crypt_auth', $result);     // libraries/User/_user_crypt_auth

            if (isset($resullt['logged_in']) && $resullt['logged_in'] !== false) {


                $client_ip = $this->obj->input->ip_address();
                $ses_id = $this->obj->session->userdata('session_id');
                $user_token = md5($ses_id);

                $user_id = $this->obj->id = $resullt['id'];
                $this->obj->username = $resullt['username'];

                $this->obj->logged_in = true;
                $this->obj->lang = $this->obj->session->userdata('lang');
                $this->obj->token = $resullt['token'];
                $this->obj->email = $resullt['email'];
                $this->obj->_start_session();

                $data = array('token' => $user_token);
                $this->obj->db->where('id', $user_id);
                $this->obj->db->update('users', $data);


            } else {
                throw new Exception('Forbidden! Wrong userame or password. Please try again');
            }
        } else {
            throw new Exception('Forbidden! Wrong userame or password. Please try again');
        }


        if ($resullt) {

            $data = array(
                "logged_in" => $resullt['logged_in'],
                "username" => ucfirst($resullt['username']),
                "email" => $resullt['email'],
                "User ID" => $resullt['id'],
               "token" => $resullt['token']
            );
            return $data;
        }
    }

}
