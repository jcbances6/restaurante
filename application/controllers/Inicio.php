<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
			
	}

    public function index(){

        if($this->session->userdata('login')){
            
            redirect(base_url('mozo/inicio')); 
            
        }else{
            $data_user = array(
                'idusuario' => 'US001',
                'nomcorto' => 'JUAN BANCES',
                'nomlargo' => 'JUAN CARLOS BANCES COTRINA',
                'login' => TRUE
            );

            $this->session->set_userdata($data_user);
            redirect(base_url('mozo/inicio')); 

        }
 
    }


    public function logout(){
        $this->session->sess_destroy();
        // redirect('http://www.google.com.pe');
    }

}
?>