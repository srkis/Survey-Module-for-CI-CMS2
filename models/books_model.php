<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books_model extends CI_Model {


	public function getBooks() {
                    $this->db->select("*");
                    $this->db->from("books");
                    $query = $this->db->get();

                    return $query->result();

                        $num_data_returned = $query->num_rows;

                    if($num_data_returned < 1){
                        echo "There is no data in the database!";
                        exit();
                    }

	}
}
