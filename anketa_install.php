<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$tables = array(
            'survey_user_answer' => array(
        'fields' => array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
         
            'survey_question_id' => array(
                 'type' => 'INT',
                
            ),
            
            
             'user_ip' => array(
                 'type' => 'VARCHAR',
                'constraint' => '300',
            ),
            
            
             'survey_answer_id' => array(
                 'type' => 'INT',
            ),

             'survey_comments' => array(
                'type' => 'TEXT',
                'constraint' => '1200',
            ),

        ),
       'keys' => array(
            'id' => TRUE,
        )
       
    ),
       
    'survey_question' => array(
        'fields' => array(
            'question_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
             
            'questions' => array(
                'type' => 'VARCHAR',
                'constraint' => '300',
            ),

            'description' => array(
                'type' => 'TEXT',
                'constraint' => '1200',
            ),

            'status' => array(
                'type' => 'INT',
             ),

        ),
        'keys' => array(
            'question_id' => TRUE,
        ),
    ),
    
    'survey_answers' => array(
        'fields' => array(
            'answers_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'question_id' => array(
                'type' => 'INT',
            ),
            'offered_answers' => array(
                'type' => 'VARCHAR',
                'constraint' => '300',
            ),            
        ),
        'keys' => array(
            'answers_id' => TRUE,
        ),
    ),
    
          'clients' => array(
        'fields' => array(
            'clients_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'username' => array(
                 'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '300',
            ),
            
               'licence' => array(
                'type' => 'VARCHAR',
                'constraint' => '300',
            ),
            
               'call_service_time' => array(
                'type' => 'TIMESTAMP',
            ),
            
        ),
        'keys' => array(
            'clients_id' => TRUE,
        ),
    )
    
);

$this->load->dbforge();
foreach ($tables as $key => $table) {
    $this->dbforge->add_field($table['fields']);
    foreach ($table['keys'] as $key1 => $val1) {
        $this->dbforge->add_key($key1, $val1);
    }
    $this->dbforge->create_table($key, TRUE);
}	
