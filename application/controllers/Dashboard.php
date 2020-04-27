<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *

	 */
	 
	public function __construct()  {
            parent::__construct();
			$this->load->helper('url');			
			$this->load->helper('form');			
			$this->load->library('session');
			//include('/check_conn.php');			
			$this->load->database();			
			$this->load->model('Dashboard_model');  
			$this->load->model('Member_model');   
			
			if(!$_SESSION['loginID'])	
				redirect(site_url.'member/logout/');		
			
    }
	 
	public function index()
	{	
		$data['current_month'] = date('Y-m-01');
		$data['previous_month'] = date('Y-m-01', strtotime(date('Y-m')." -1 month"));
		$data['previous_next_month'] = date('Y-m-01', strtotime('-2 MONTH'));
		$data['previous_next_next_month'] = date('Y-m-01', strtotime('-3 MONTH'));
		$data['company_id'] = $_SESSION['company_id'] ;
		$data['business_impact_id'] = $this->Dashboard_model->select_business_impact_id($data['company_id']);
		$data['biz_impact'] = $this->Dashboard_model->select_all_company_biz($data['company_id']);
		$data['all_stages'] = $this->Dashboard_model->select_all_data_table('master_stages');
		$data['all_status'] = $this->Dashboard_model->select_all_data_table('master_status');
		//echo "<pre>";print_r($data['previous_month']);exit;		 
		$this->load->view('dashboard_view',$data);
	}	 

	public function progress_report(){		
		$data['current_month'] = date('Y-m-01');
		$data['previous_month'] = date('Y-m-01', strtotime(date('Y-m')." -1 month"));
		$data['previous_next_month'] = date('Y-m-01', strtotime('-2 MONTH'));
		$data['previous_next_next_month'] = date('Y-m-01', strtotime('-3 MONTH'));		

		$data['company_id'] = $_SESSION['company_id'] ;
		$data['business_impact_id'] = $this->Dashboard_model->select_business_impact_id($data['company_id']);		
		$data['biz_impact'] = $this->Dashboard_model->select_all_company_biz($data['company_id']);		
		$data['all_stages'] = $this->Dashboard_model->select_all_data_table('master_stages');
		$data['all_status'] = $this->Dashboard_model->select_all_data_table('master_status');		
		//echo "<pre>";print_r($data['previous_month']);exit;		 
		$this->load->view('new_dashboard_view_result',$data);		
	} 

	public function progress_report_new(){		
		//echo "<pre>";print_r($_SESSION);exit;
		$data['current_month'] = date('Y-m-01');
		$data['previous_month'] = date('Y-m-01', strtotime(date('Y-m')." -1 month"));
		$data['previous_next_month'] = date('Y-m-01', strtotime('-2 MONTH'));
		$data['previous_next_next_month'] = date('Y-m-01', strtotime('-3 MONTH'));		

		$data['company_id'] = $_SESSION['company_id'] ;
		$data['business_impact_id'] = $this->Dashboard_model->select_business_impact_id($data['company_id']);		
		$data['biz_impact'] = $this->Dashboard_model->select_all_company_biz($data['company_id']);		
		$data['all_stages'] = $this->Dashboard_model->select_all_data_table('master_stages');
		$data['all_status'] = $this->Dashboard_model->select_all_data_table('master_status');
		$data['title']='Progress Report';		
		//echo "<pre>";print_r($data['previous_month']);exit;		 
		$this->load->view('view_progress_report',$data);		
	} 


	public function dashboard_view_new(){		
		$data['current_month'] = date('Y-m-01');
		$data['previous_month'] = date('Y-m-01', strtotime(date('Y-m')." -1 month"));
		$data['previous_next_month'] = date('Y-m-01', strtotime('-2 MONTH'));
		$data['previous_next_next_month'] = date('Y-m-01', strtotime('-3 MONTH'));	
		$data['colorView']='1';
		$data['title']='Dashboard View';

		$data['company_id'] = $_SESSION['company_id'] ;
		$data['business_impact_id'] = $this->Dashboard_model->select_business_impact_id($data['company_id']);		
		$data['biz_impact'] = $this->Dashboard_model->select_all_company_biz($data['company_id']);		
		$data['all_stages'] = $this->Dashboard_model->select_all_data_table('master_stages');
		$data['all_status'] = $this->Dashboard_model->select_all_data_table('master_status');		
		//echo "<pre>";print_r($data['previous_month']);exit;		 
		$this->load->view('view_progress_report',$data);		
	} 


	public function spider_chart_data_manage(){
		$data['company_id'] = $_SESSION['company_id'] ;
		$data['company_level'] = $this->Dashboard_model->select_level_by_company($data['company_id']);
		//print_r($data['company_level']);exit;
		$this->load->view('spider_chart_data_manage',$data);

	}
	public function spider_chart(){
		$data['company_id'] = $_SESSION['company_id'] ;
		$data['level_id'] = $_POST['level_id'] ;
		$company_id=$_SESSION['company_id'] ;
		$data['company_level'] = $this->Dashboard_model->select_level_by_company($data['company_id']);
		//print_r($data['company_level']);exit;
				$level_id = $_POST['level_id']; //$this->post('level_id');
		if($level_id){
				//$level_id =  $this->post('level_id');
	         // $data_date =  $this->post('data_date');
	          $level_str="";
	          $level_only = $this->Dashboard_model->select_all_transaction_by_level_only($company_id,$level_id);
	          foreach($level_only as $level){
	          	//echo "<pre>";print_r($level);
	            $level_str.= "'".$level['outcomes']."',";
	          }
	          $level_str=rtrim($level_str, ',');

	          $level_data = $this->Dashboard_model->select_all_transaction_by_level_with_data($company_id,$level_id);
	          $level_data_array=array();
	          foreach($level_data as $data1){
	          	if($data1['score']){
	          			$score_persent=round($data1['score']/$data1['total']*100);
	          	}else{
	          			$score_persent=0;

	          	}
	            $level_data_array[$data1['data_date']][$data1['id']]=$score_persent;
	          }
	          	//echo "<pre>";print_r($level_data_array);exit;
	            $final_level_data_array=array();
				//echo "<pre>";print_r($level_data_array);exit;

	          foreach($level_data_array as $key=>$level_data){
				//echo "<pre>";print_r($key);exit;
	              $data_str="";
	              foreach($level_data as $data2) {
	                  $data_str.= $data2.",";
	              }             
	                 $data_str=rtrim($data_str, ',');
	                 $temp_arr['key']=$key;
	                 $temp_arr['data_str']=$data_str;
	            array_push($final_level_data_array,$temp_arr);
	            if($key)
	           $key1= date('m-d-Y',strtotime($key));
				$serise_str.="{
			        name: '".$key1."',
			        data: [".$data_str."],
			        pointPlacement: 'on'
			    },";
	          }
	                 $serise_str=rtrim($serise_str, ',');

	          $data['level_name']=$level_str;
	          $data['serise_str']=$serise_str;	          
	          
		}
		$this->load->view('spider_chart_view',$data);

	}

	function upload_company_id(){
		 
		if($_POST['company_id']){
			 $_SESSION['company_id']=$_POST['company_id'] ;
			 $company = $this->Member_model->get_company_logo($_POST['company_id']);
			 $_SESSION['company_logo'] = $company[0]['logo'];
		}
		//echo "<pre>";print_r($_SESSION);exit;
		redirect(base_url().'index.php'.$_POST['path_info']);
		exit;
	}

	function userList()
	{	
		$company_id = $_SESSION['company_id'];
		if($_POST){
			if($_POST['user_id']){

				$data['first_name'] = $_POST['first_name'];
				$data['email'] = $_POST['email'];
				$data['company_id'] = $company_id;
				$data['last_name'] = $_POST['last_name'];
				$data['password'] = $_POST['password'];
				$data['role'] = $_POST['role'];
				$data['status'] = $_POST['status'];
				$this->Dashboard_model->update_data_table($data,'id',$_POST['user_id'],'users');				 
				$_SESSION['error_message'] = $data['first_name'].' '.$data['last_name'].' Updated Successfully.';

			}else{
				$data['first_name'] = $_POST['first_name'];
				$data['email'] = $_POST['email'];
				$data['company_id'] = $company_id;
				$data['last_name'] = $_POST['last_name'];
				$data['password'] = $_POST['password'];
				$data['role'] = $_POST['role'];
				$data['status'] = $_POST['status'];
				$this->Dashboard_model->ins_data_table($data,'users');	 
				$_SESSION['error_message'] = $data['first_name'].' '.$data['last_name'].' inserted Successfully.';
			}				
		}
		$id = $this->uri->segment(3);
		if($id){
			$data['user'] = $this->Dashboard_model->select_all_userList($id,$company_id);	
			//echo "<pre>";print_r($data['user']);exit;		
		}	

		$data['all_company'] = $this->Dashboard_model->select_all_company();
		$data['all_userList'] = $this->Dashboard_model->select_all_userList('',$company_id);		 	 
		$this->load->view('view_userList',$data);
	}

	function biz_impactList()
	{	
		$company_id = $_SESSION['company_id'];
		if($_POST){
			if($_POST['biz_id']){

				$data['business_impact'] = $_POST['business_impact'];
				$data['measure'] = $_POST['measure'];
				$data['company_id'] = $company_id;
				$data['description'] = $_POST['description'];
				$data['ordering'] = $_POST['ordering'];				 
				$data['status'] = $_POST['status'];
				$this->Dashboard_model->update_data_table($data,'id',$_POST['biz_id'],'master_biz_impact');			 
				$_SESSION['error_message'] = $data['business_impact'].' Updated Successfully.';

			}else{
				$data['business_impact'] = $_POST['business_impact'];
				$data['measure'] = $_POST['measure'];
				$data['company_id'] = $company_id;
				$data['description'] = $_POST['description'];
				$data['ordering'] = $_POST['ordering'];				 
				$data['status'] = $_POST['status'];

				$this->Dashboard_model->ins_data_table($data,'master_biz_impact');	 
				$_SESSION['error_message'] = $data['business_impact'].' inserted Successfully.';
			}				
		}
		$id = $this->uri->segment(3);
		if($id){
			$data['biz_impactList'] = $this->Dashboard_model->select_all_biz_impactList($id,$company_id);	
			//echo "<pre>";print_r($data['user']);exit;		
		}

		$data['all_company'] = $this->Dashboard_model->select_all_company();
		$data['all_biz_impactList'] = $this->Dashboard_model->select_all_biz_impactList('',$company_id);			 	 
		$this->load->view('view_biz_impactList',$data);
	}

	function company_levels(){
		$company_id = $_SESSION['company_id'];
		if($_POST){
			if($_POST['level_id']){

				$data['level'] = $_POST['level'];				 
				$data['company_id'] = $company_id;
				$data['description'] = $_POST['description'];
				$data['ordering'] = $_POST['ordering'];				 
				$data['status'] = $_POST['status'];
				$this->Dashboard_model->update_data_table($data,'id',$_POST['level_id'],'master_levels');			 
				$_SESSION['error_message'] = $data['level'].' Updated Successfully.';

			}else{
				$data['level'] = $_POST['level'];				 
				$data['company_id'] = $company_id;
				$data['description'] = $_POST['description'];
				$data['ordering'] = $_POST['ordering'];				 
				$data['status'] = $_POST['status'];

				$this->Dashboard_model->ins_data_table($data,'master_levels');	 
				$_SESSION['error_message'] = $data['level'].' inserted Successfully.';
			}				
		}
		$id = $this->uri->segment(3);
		if($id){
			$data['levelList'] = $this->Dashboard_model->select_all_company_level($id,$company_id);	
			//echo "<pre>";print_r($data['user']);exit;		
		}
		$data['all_company'] = $this->Dashboard_model->select_all_company();
		$data['all_company_level'] = $this->Dashboard_model->select_all_company_level('',$company_id);			 	 
		$this->load->view('view_company_levels',$data);
	}

	function manage_outcome(){
		
		$company_id = $_SESSION['company_id'];
		if($_POST){
			if($_POST['outcome_id']){

				$data['outcomes'] = $_POST['outcomes'];				 
				$data['company_id'] = $company_id;
				$data['business_impact_id'] = $_POST['business_impact_id'];
				$data['stage_id'] = $_POST['stage_id'];
				$data['level_id'] = $_POST['level_id'];
				$data['description'] = $_POST['description'];
				//$data['ordering'] = $_POST['ordering'];				 
				$data['status'] = $_POST['status'];
				$this->Dashboard_model->update_data_table($data,'id',$_POST['outcome_id'],'tran_outcomes');			 
				$_SESSION['error_message'] = $data['outcomes'].' Updated Successfully.';

			}else{
				$data['outcomes'] = $_POST['outcomes'];				 
				$data['company_id'] = $company_id;
				$data['business_impact_id'] = $_POST['business_impact_id'];
				$data['stage_id'] = $_POST['stage_id'];
				$data['level_id'] = $_POST['level_id'];
				$data['description'] = $_POST['description'];
				//$data['ordering'] = $_POST['ordering'];				 
				$data['status'] = $_POST['status'];
				$insert_id = $this->Dashboard_model->ins_data_table($data,'tran_outcomes');	 
				// print_r($data);
				// echo $insert_id;exit;
				if($insert_id){
					$trndata['start_date'] = date('Y-m-d',strtotime($_POST['start_date']));
					$trndata['tran_outcome_id'] = $insert_id;
					$trndata['status_id'] = $_POST['status_id'];
					$trndata['status'] = 1;
					$this->Dashboard_model->ins_data_table($trndata,'tran_status');	 

					$trncoldata['start_date'] = date('Y-m-d',strtotime($_POST['start_date']));
					$trncoldata['tran_outcome_id'] = $insert_id;
					$trncoldata['class_id'] = $_POST['color_id'];
					$trncoldata['status'] = 1;
					$this->Dashboard_model->ins_data_table($trncoldata,'tran_color');	 
				}

				$_SESSION['error_message'] = $data['outcomes'].' inserted Successfully.';
			}				
		}
		$data['id'] = $this->uri->segment(3);
		if($data['id']){
			$data['outcomeList'] = $this->Dashboard_model->select_all_outcomeList($data['id'],$company_id);	
			//echo "<pre>";print_r($data['user']);exit;		
		}
		$data['biz_impact'] = $this->Dashboard_model->select_all_company_biz($company_id);
		$data['all_company'] = $this->Dashboard_model->select_all_company();
		$data['all_impactList'] = $this->Dashboard_model->select_all_outcomeList('',$company_id);	
		$data['all_stages'] = $this->Dashboard_model->select_all_data_table('master_stages');
		$data['company_level'] = $this->Dashboard_model->select_level_by_company($company_id);
		$data['all_status'] = $this->Dashboard_model->select_all_data_table('master_status');	
		$data['all_color'] = $this->Dashboard_model->select_all_color();	 	 
		$this->load->view('view_manage_outcome',$data);
	}
	
	public function manage_master_data(){
		
		$data['company_id'] = $_SESSION['company_id'];
		$data['all_biz_impactList'] = $this->Dashboard_model->select_all_biz_impactList('',$data['company_id']);	
		$data['all_company_level'] = $this->Dashboard_model->select_all_company_level('',$data['company_id']);	
		$data['biz_impact'] = $this->Dashboard_model->select_all_company_biz($data['company_id']);
		$data['all_company'] = $this->Dashboard_model->select_all_company();
		$data['all_impactList'] = $this->Dashboard_model->select_all_outcomeList('',$data['company_id']);	
		$data['all_stages'] = $this->Dashboard_model->select_all_data_table('master_stages');
		$data['company_level'] = $this->Dashboard_model->select_level_by_company($data['company_id']);
		$data['all_status'] = $this->Dashboard_model->select_all_data_table('master_status');	
		$data['all_color'] = $this->Dashboard_model->select_all_color();	 
		$data['all_userList'] = $this->Dashboard_model->select_all_userList('',$data['company_id']);		
		$this->load->view('view_manage_master_data',$data);
	}

	function manage_company()
	{	
		if($_FILES['logo']){
			$target_dir = "company_logo/";
			$target_file = $target_dir . basename($_FILES["logo"]["name"]);
            $filename = basename($_FILES["logo"]["name"]);
			// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			// 	&& $imageFileType != "gif" ) {
			// 	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			// 	    $uploadOk = 0;
			// }
            if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            	$data['logo'] = $filename;		
            } 
		}		
		if($_POST){
			if($_POST['company_id']){

				$data['company_name'] = $_POST['company_name'];
				$data['address'] = $_POST['address'];				 
				$data['description'] = $_POST['description'];
				//$data['logo'] = $filename;				 
				$data['status'] = $_POST['status'];
				$this->Dashboard_model->update_data_table($data,'id',$_POST['company_id'],'master_company');		 
				$_SESSION['error_message'] = $data['company_name'].' updated successfully.';

			}else{
				$data['company_name'] = $_POST['company_name'];
				$data['address'] = $_POST['address'];				 
				$data['description'] = $_POST['description'];
				//$data['logo'] = $filename;				 
				$data['status'] = $_POST['status'];
				$insert_id = $this->Dashboard_model->ins_data_table($data,'master_company');

				if($insert_id){

					$data1['first_name'] = 'Admin';
					$string = str_replace(' ', '', $_POST['company_name']);
					$data1['email'] = strtolower($string).'@gmail.com';
					$data1['company_id'] = $insert_id;					
					$data1['password'] = '123456';
					$data1['role'] = 'admin';
					$data1['status'] = '0';
					$this->Dashboard_model->ins_data_table($data1,'users');	
				}

				$_SESSION['error_message'] = $data['company_name'].' inserted successfully.';
			}				
		}
		$company_id = $this->uri->segment(3);
		if($company_id){
			$data['company'] = $this->Dashboard_model->select_all_companyList($company_id);	
			//echo "<pre>";print_r($data['user']);exit;		
		}	

		$data['allcompany'] = $this->Dashboard_model->select_all_companyList('');
		//echo "<pre>";print_r($data['all_company']);exit;				 	 
		$this->load->view('view_manage_company',$data);
	}

	function process_data(){
		$company_id = $_SESSION['company_id'];
	 
		//echo $company_id;exit;
		$this->Dashboard_model->add_business_outcomes($company_id);
		$this->Dashboard_model->add_levels($company_id);
		$this->Dashboard_model->add_agile_outcomes($company_id);
		$this->Dashboard_model->add_agile_outcomes_status_and_color($company_id,$_SESSION['loginID']);
		redirect(site_url.'Dashboard/progress_report_new');exit;

	} 

	// public function manage_all_status(){
		
	// 	$data['company_id'] = $_SESSION['company_id'];		  
			 
	// 	//echo "<pre>";print_r($data['all_impactList']);exit;	 		
	// 	$this->load->view('view_manage_all_status',$data);
	// }

	public function manage_all_status(){
		$data['company_id'] = $_SESSION['company_id'] ;
		$data['company_level'] = $this->Dashboard_model->select_level_by_company($data['company_id']);
		$data['all_biz_impactList'] = $this->Dashboard_model->select_all_business_outcome($data['company_id']);
		$data['all_status'] = $this->Dashboard_model->select_all_data_table('master_status');	
		$data['all_color'] = $this->Dashboard_model->select_all_color();
		//print_r($data['company_level']);exit;
		$this->load->view('view_manage_all_status',$data);

	}

	public function manage_status_color(){
		$data['company_id'] = $_SESSION['company_id'] ;
		$data['company_level'] = $this->Dashboard_model->select_level_by_company($data['company_id']);
		$data['all_biz_impactList'] = $this->Dashboard_model->select_all_business_outcome($data['company_id']);
		$data['message'] = $this->Dashboard_model->select_message_by_type('Warning');
		// $data['all_status'] = $this->Dashboard_model->select_all_data_table('master_status');	
		// $data['all_color'] = $this->Dashboard_model->select_all_color();
		//print_r($data['company_level']);exit;
		$this->load->view('view_manage_status_color',$data);

	}
	
	public function login_logout_history()
	{	
		$company_id = $_SESSION['company_id'];		 
		$data['all_login_logout_history'] = $this->Dashboard_model->select_all_login_logout_history();		 	 
		$this->load->view('view_login_logout_history',$data);
	}


	
}
