<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller { 	 
	 
	public function __construct()  {
            parent::__construct();
			$this->load->helper('url');			
			$this->load->helper('form');			
			$this->load->library('session');	 
			$this->load->database();		 
			$this->load->model('Member_model'); 
			
			// if(!$_SESSION['loginID'])	{
			// 	redirect(site_url.'member/index');	
			// 	exit;			
			// }
    }	 
	
	public function index()
	{
		$this->load->view('login'); 		
	}

	public function login()
	{
		 if($this->input->post()){
		 	 $user_id = $this->input->post('user_id') ;
			 $pwd = $this->input->post('password') ;
			 $user = $this->Member_model->login_member($user_id, $pwd);
  
			if($user){
				if($user[0]['status']==0){

				 	if($user[0]['role'] =='analyst'){
						$companyid = 1;
					}else{
						$companyid = $user[0]['company_id'];
					}

					$company = $this->Member_model->get_company_logo($companyid);				
					$newdata = array(
							'loginID'  => $user[0]['id'],
							'Name'     => $user[0]['first_name'].' '.$user[0]['last_name'],
							'EmailID'     =>  $user[0]['email'],
							'role'     =>  $user[0]['role'],
							'company_id'     =>  $companyid,
							'logged_in' => TRUE,
							'company_logo' => $company[0]['logo']
					); 

					 
					/// ------- User Activity Start--- /////////////
					$date_n = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('Europe/Dublin'));  
				    $json = json_decode('['.json_encode($date_n).']'); 
					$logindata['login_id'] = $newdata['loginID'];
					$logindata['ip_address'] = $_SERVER['REMOTE_ADDR'];
					$logindata['start_time'] = $json[0]->date;
					$logindata['timezone'] = $json[0]->timezone; 						 
					$newdata['user_activity_id'] = $this->Member_model->ins_data_table($logindata,'user_activity');	
					/// ------- User Activity End--- ///////////// 

					$this->session->set_userdata($newdata);			 
					//redirect(site_url.'Dashboard/progress_report_new');exit;
				redirect(site_url.'member/logging');exit;
					
				}else{
					$_SESSION['err_msg'] = "Activate your account and login again.";
					$this->load->view('login' , $data);
				}
			}
			else 
			{
				$_SESSION['err_msg'] = "Enter correct username and password";  
				$this->load->view('login' , $data);
			}

		 }else{
		 	$this->load->view('login' , $data);
		 }
		 

	}
	public function logging(){
		$this->load->view('logging' , $data);

	}
	
	public function logout()
	{	
		$date_n = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('Europe/Dublin'));  
		$json = json_decode('['.json_encode($date_n).']'); 
		/// ------- User Activity Start--- ///////////// 		
		$logindata['end_time'] = $json[0]->date;			
		$this->Member_model->update_data_table($logindata,'id',$_SESSION['user_activity_id'],'user_activity');	
		/// ------- User Activity End--- ///////////// 

		session_destroy();
		redirect(site_url.'member/');exit;
	}	

}
