<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Server_model extends CI_Model {

    public function clientsLicence($user_ip, $client_licence) {

        $this->db->select('licence');
        $this->db->from("clients");
        $this->db->where('licence', $client_licence);
        $licence = $this->db->get()->row();
        
        if (empty($licence)) {

            return FALSE;
        }

        if ( $client_licence == $licence->licence) {

            $licence_hash = $licence->licence;

            return TRUE; 

        }else{

            return FALSE;
        }
    }

 


}
