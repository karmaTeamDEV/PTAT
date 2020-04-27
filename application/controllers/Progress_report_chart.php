<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Progress_report_chart extends CI_Controller {

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
			
			if(!$_SESSION['loginID'])	
				redirect(site_url.'member/logout/');		
			
    }
	 
	public function index()
	{	
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
	          //echo "<pre>";print_r($level_only);exit;
	          //$level_id_array-array();
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
	             /* foreach($level_data as $data2) {
	                  $data_str.= $data2.",";
	              } */
		          foreach($level_only as $level){
		          		if($level_data[$level['id']]){
		          	 		$data_str.= $level_data[$level['id']].",";
		          		}else{
		          	 		$data_str.= "0,";
		          		}
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
	          
	          //echo $serise_str;
//echo "<pre>";print_r($data);exit;
		}

		$this->load->view('spider_chart_view',$data);

	}
		public function evaluation_results_line_chart(){
		$data['company_id'] = $_SESSION['company_id'] ;
		//$data['level_id'] = $_POST['level_id'] ;
		$company_id=$_SESSION['company_id'] ;

		//print_r($data['company_level']);exit;
				//$level_id = $_POST['level_id']; //$this->post('level_id');
		if($company_id){
		$line_chart_date_only = $this->Dashboard_model->evaluation_results_line_chart_date_only($data['company_id']);
	          $level_str="";

	          foreach($line_chart_date_only as $date){
	          	//echo "<pre>";print_r($level);
	            $level_str.= "'".$date['f_data_date']."',";
	          }
	          $level_str=rtrim($level_str, ',');


		$line_chart_data = $this->Dashboard_model->evaluation_results_line_chart_data($data['company_id']);
	          $level_data_array=array();
	          foreach($line_chart_data as $chart_data){
	            $level_data_array[$chart_data['stage']][$chart_data['data_date']]=$chart_data['score'];

	          }
	          foreach($level_data_array as $key=>$level_data){
	              $data_str="";
	              foreach($level_data as $data2) {
	                  $data_str.= $data2.",";
	              }             
	                 $data_str=rtrim($data_str, ',');
	                 $serise_str.="{
        name: '".$key."',
        data: [".$data_str."]
    },";
				}
			    $serise_str=rtrim($serise_str, ',');
	          //$level_str=rtrim($level_str, ',');
	          $data['level_str']=$level_str;
	          $data['serise_str']=$serise_str;
		}

		$this->load->view('evaluation_results_line_chart_view',$data);

	}

}
