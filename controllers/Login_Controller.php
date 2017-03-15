<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Login_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->template['module'] = 'anketa';
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('javascript');
        $this->load->helper('date');
        $this->load->model('Server_model');
        $this->load->model('Api_model');
        $this->load->library('encrypt');


      }


         public function  login_view(){

             $this->layout->load($this->template, 'login_view');
        }


         public function checklogin(){

                $username = $this->input->post("username");
                $password = $this->input->post("password");

                $username = $this->encrypt->encode($username);
                $password = $this->encrypt->encode( $password );

                $key = '12345';

                $key = $this->encrypt->encode($key);

                $header = ['API-KEY:  ' . $key];

                $URL = 'http://mojhost/ci-cms2/anketa/server/checkUserData';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$URL);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
                curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
                curl_setopt($ch, CURLOPT_VERBOSE, 1) ;
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                $result = curl_exec ($ch);       //method which will execute the cURL request

                if(!curl_exec($ch)){
                    die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
                }

                $info = curl_getinfo($ch);

                //echo "<pre>";
             //print_r($info);
             print_r($result);   
          // $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
            curl_close ($ch);

                }
        }

    /*
     * Logovanje preko User biblioteke , napravljenja nova metoda _user_crypt_auth na kraju User klase
     * 
     * 
     * 
     CURLAUTH_BASIC

     *  HTTP Basic authentication. 
        This is the default choice, and the only method that is in wide-spread use and supported virtually everywhere. 
        This sends the user name and password over the network in plain text, easily captured by others.

        **********************
        CURLOPT_RETURNTRANSFER - Return the response as a string instead of outputting it to the screen
        CURLOPT_CONNECTTIMEOUT - Number of seconds to spend attempting to connect
        CURLOPT_TIMEOUT - Number of seconds to allow cURL to execute
        CURLOPT_USERAGENT - Useragent string to use for request
        CURLOPT_URL - URL to send request to
        CURLOPT_POST - Send request as POST
        CURLOPT_POSTFIELDS - Array of data to POST in request
     * 


 */
