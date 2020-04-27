<?php  
header("Access-Control-Allow-Origin: *"); 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

	public function __construct() {

		parent::__construct();

		$this->load->helper('url');
		$this->load->library('session');		
		$this->load->database() ;		
		$this->load->model('Dashboard_model');  		

	}
	
	public function index()
	{}
		



	
	function change_status_post(){ 

		// echo "<pre>";print_r($_SESSION);exit;
		  $data['status']=0;
		  //$data['end_date']=date('Y-m-d',strtotime("-1 days"));
          if($this->post('previous_startdate') == date('Y-m-d')){
            $data['end_date']=date('Y-m-d', strtotime($this->post('start_date')));
          }else{
             $data['end_date']=date('Y-m-d', strtotime('-1 day', strtotime($this->post('start_date'))));
          }

		  $update_id = $this->Dashboard_model->update_data_table($data, 'id', $this->post('tran_status_id'), 'tran_status');
		   // echo  $update_id;exit;
			
		if($update_id)
        {
        	$data1['tran_outcome_id']=$this->post('tran_outcome_id');
        	$data1['status_id']=$this->post('status_id');
        	$data1['note']=$this->post('note');
        	$data1['start_date']=date('Y-m-d',strtotime($this->post('start_date')));
        	$data1['status']=1;
        	$data1['status_changed_id']= $_SESSION['loginID'];

        	//echo "<pre>";print_r($data1);exit;
        	$insert_id = $this->Dashboard_model->ins_data_table($data1,'tran_status');
            $this->response($insert_id, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not found', );
            $this->response($list, 404);
        }
	}

    function change_color_post(){ 

        // echo "<pre>";print_r($_SESSION);exit;
          $data['status']=0;
          //$data['end_date']=date('Y-m-d',strtotime("-1 days"));
          //$data['end_date']=date('Y-m-d', strtotime('-1 day', strtotime($this->post('color_date'))));

          if($this->post('previous_colordate') == date('Y-m-d')){
            $data['end_date']=date('Y-m-d', strtotime($this->post('color_date')));
          }else{
             $data['end_date']=date('Y-m-d', strtotime('-1 day', strtotime($this->post('color_date'))));
          }


          $update_id = $this->Dashboard_model->update_data_table($data, 'id', $this->post('tran_color_id'), 'tran_color');
           // echo  $update_id;exit;
            
        if($update_id)
        {
            $data1['tran_outcome_id']=$this->post('tran_outcome_id');
            $data1['class_id']=$this->post('color_id');
            $data1['note']=$this->post('color_note');
            $data1['start_date']=date('Y-m-d',strtotime($this->post('color_date')));
            $data1['status']=1;
            $data1['status_changed_id']= $_SESSION['loginID'];

            //echo "<pre>";print_r($data1);exit;
            $insert_id = $this->Dashboard_model->ins_data_table($data1,'tran_color');
            $this->response($insert_id, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not found', );
            $this->response($list, 404);
        }
    }

	function add_comment_post(){ 

		// echo "<pre>";print_r($_SESSION);exit;		
		if($this->post('comment'))
        {        	
        	$data1['tran_status_id']=$this->post('tran_status_id');
        	$data1['tran_outcome_id']=$this->post('outcome_id'); 
        	$data1['note']=$this->post('comment');        	 
        	$data1['added_by']= $_SESSION['loginID'];
        	//echo "<pre>";print_r($data1);exit;
        	$this->Dashboard_model->ins_data_table($data1,'outcome_comments');
        	$myarray = $this->Dashboard_model->select_all_comment_by_outcome_id($data1['tran_outcome_id']);
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not found', );
            $this->response($list, 404);
        }
	}

    function calculate_score_post(){

        if($this->post('id'))
        {   
          $data['current_percentage'] = $this->post('cur_percentage');
          $data['score'] = $this->post('score');
          $update_id = $this->Dashboard_model->update_data_table($data, 'id', $this->post('id'), 'tran_capability_acceptance');      
            $this->response($update_id, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'Record not found', );
            $this->response($list, 404);
        }

    }

    function add_update_user_post(){ 

        if($this->post())
        {
            if($_POST['user_id']){

                $data['first_name'] = $_POST['first_name'];
                $data['email'] = $_POST['email'];
                $data['company_id'] = $_POST['company_id'];
                $data['last_name'] = $_POST['last_name'];
                $data['password'] = $_POST['password'];
                $data['role'] = $_POST['role'];
                $data['status'] = $_POST['status'];
                $this->Dashboard_model->update_data_table($data,'id',$_POST['user_id'],'users');   
                $user_error_msg =  $data['first_name'].' '.$data['last_name'].' updated successfully.';
            }else{
                $data['first_name'] = $_POST['first_name'];
                $data['email'] = $_POST['email'];
                $data['company_id'] = $_POST['company_id'];
                $data['last_name'] = $_POST['last_name'];
                $data['password'] = $_POST['password'];
                $data['role'] = $_POST['role'];
                $data['status'] = $_POST['status'];
                $this->Dashboard_model->ins_data_table($data,'users'); 
                $user_error_msg =  $data['first_name'].' '.$data['last_name'].' inserted successfully.';
            }      

            $myarray['list'] =  $this->Dashboard_model->select_all_userList('',$_POST['company_id']);
            $myarray['user_error_msg'] = $user_error_msg;
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inserted.', );
            $this->response($list, 404);
        }
    }

    function get_user_id_post(){ 
                 
        if($this->post())
        {           
            $data['user_id'] = $_POST['user_id'];            
            $data['company_id'] = $_POST['company_id']; 
            $myarray =  $this->Dashboard_model->select_all_userList( $data['user_id'],$data['company_id']);
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inseted.', );
            $this->response($list, 404);
        }
    }

    function add_update_biz_impact_post(){ 

        if($this->post())
        {
            if($_POST['biz_id']){

                $data['business_impact'] = $_POST['business_impact'];
                $data['measure'] = $_POST['measure'];
                $data['company_id'] = $_POST['company_id']; 
                $data['description'] = $_POST['description'];
                $data['ordering'] = $_POST['ordering'];              
                $data['status'] = $_POST['status'];
                $this->Dashboard_model->update_data_table($data,'id',$_POST['biz_id'],'master_biz_impact');   
                $biz_error_msg =  $data['business_impact'].' updated successfully.';

            }else{
                $data['business_impact'] = $_POST['business_impact'];
                $data['measure'] = $_POST['measure'];
                $data['company_id'] = $_POST['company_id']; 
                $data['description'] = $_POST['description'];
                $data['ordering'] = $_POST['ordering'];              
                $data['status'] = $_POST['status'];

                $this->Dashboard_model->ins_data_table($data,'master_biz_impact');   
                $biz_error_msg =  $data['business_impact'].' inserted successfully.';
            }      

            $myarray['list'] =  $this->Dashboard_model->select_all_biz_impactList('',$_POST['company_id']);
            $myarray['biz_error_msg'] = $biz_error_msg;
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inserted.', );
            $this->response($list, 404);
        }
    }

     function get_biz_id_post(){ 
                 
        if($this->post())
        {           
            $data['biz_id'] = $_POST['biz_id'];            
            $data['company_id'] = $_POST['company_id']; 

            $myarray =  $this->Dashboard_model->select_all_biz_impactList( $data['biz_id'],$data['company_id']);
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inseted.', );
            $this->response($list, 404);
        }
    }

     function add_update_company_level_post(){ 

        if($this->post())
        {
            if($_POST['level_id']){

               $data['level'] = $_POST['level'];                 
                $data['company_id'] = $_POST['company_id']; 
                $data['description'] = $_POST['description'];
                $data['ordering'] = $_POST['ordering'];              
                $data['status'] = $_POST['status'];
                $this->Dashboard_model->update_data_table($data,'id',$_POST['level_id'],'master_levels');
                $level_error_msg =  $data['level'].' updated successfully.';

            }else{
                $data['level'] = $_POST['level'];                
                $data['company_id'] = $_POST['company_id']; 
                $data['description'] = $_POST['description'];
                $data['ordering'] = $_POST['ordering'];              
                $data['status'] = $_POST['status'];

                $this->Dashboard_model->ins_data_table($data,'master_levels');   
                $level_error_msg =  $data['level'].' inserted successfully.';
            }      

            $myarray['list'] =  $this->Dashboard_model->select_all_company_level('',$_POST['company_id']);
            $myarray['level_error_msg'] = $level_error_msg;
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inserted.', );
            $this->response($list, 404);
        }
    }

     function get_level_id_post(){ 
                 
        if($this->post())
        {           
            $data['level_id'] = $_POST['level_id'];            
            $data['company_id'] = $_POST['company_id']; 

            $myarray =  $this->Dashboard_model->select_all_company_level( $data['level_id'],$data['company_id']);
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inserted.', );
            $this->response($list, 404);
        }
    }

    function add_update_outcome_post(){ 

        if($this->post())
        {
            if($_POST['outcome_id']){

                $data['outcomes'] = $_POST['outcomes'];                
                $data['company_id'] = $_POST['company_id']; 
                $data['business_impact_id'] = $_POST['business_impact_id'];
                $data['stage_id'] = $_POST['stage_id'];
                $data['level_id'] = $_POST['level_id'];
                $data['description'] = $_POST['description'];                                
                $data['status'] = $_POST['status'];
                $this->Dashboard_model->update_data_table($data,'id',$_POST['outcome_id'],'tran_outcomes');
                $outcome_error_msg =  $data['outcomes'].' updated successfully.';

            }else{
                
                $data['outcomes'] = $_POST['outcomes'];               
                $data['company_id'] =$_POST['company_id'];
                $data['business_impact_id'] = $_POST['business_impact_id'];
                $data['stage_id'] = $_POST['stage_id'];
                $data['level_id'] = $_POST['level_id'];
                $data['description'] = $_POST['description'];                         
                $data['status'] = $_POST['status'];
                $insert_id = $this->Dashboard_model->ins_data_table($data,'tran_outcomes');   
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

                $outcome_error_msg =  $data['outcomes'].' inserted successfully.';
            }      

            $myarray['list'] =  $this->Dashboard_model->select_all_outcomeList('',$_POST['company_id']);
            $myarray['outcome_error_msg'] = $outcome_error_msg;
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inserted.', );
            $this->response($list, 404);
        }
    }

    function get_outcome_id_post(){ 
                 
        if($this->post())
        {           
            $data['outcome_id'] = $_POST['outcome_id'];            
            $data['company_id'] = $_POST['company_id']; 

            $myarray =  $this->Dashboard_model->select_all_outcomeList( $data['outcome_id'],$data['company_id']);
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inserted.', );
            $this->response($list, 404);
        }
    }

    function select_all_history_by_outcome_id_post(){ 
                 
        if($this->post())
        {           
            $data['outcome_id'] = $_POST['outcome_id'];   
            $myarray =  $this->Dashboard_model->select_all_history_by_outcome_id($data['outcome_id']);
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inserted.', );
            $this->response($list, 404);
        }
    }

    function select_all_color_history_by_outcome_id_post(){ 
                 
        if($this->post())
        {           
            $data['outcome_id'] = $_POST['outcome_id'];   
            $myarray =  $this->Dashboard_model->select_all_color_history_by_outcome_id($data['outcome_id']);
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inserted.', );
            $this->response($list, 404);
        }
    }

    function select_all_comment_by_outcome_id_post(){ 
                 
        if($this->post())
        {           
            $data['outcome_id'] = $_POST['outcome_id'];   
            $myarray =  $this->Dashboard_model->select_all_comment_by_outcome_id($data['outcome_id']);
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inserted.', );
            $this->response($list, 404);
        }
    }
	
	function select_all_login_logout_history_post(){ 
                 
        if($this->post())
        {           
            //$data['outcome_id'] = $_POST['outcome_id'];   
            $myarray =  $this->Dashboard_model->select_all_login_logout_history();
            $this->response($myarray, 200); // 200 being the HTTP response code
        }
        else
        {
            $list = array('message' => 'record not inserted.', );
            $this->response($list, 404);
        }
    }


   //   function get_all_users_by_companyid_get(){               
        
   //          $myarray =  $this->Dashboard_model->select_all_userList('',$_SESSION['company_id']);
   //          $shaing_details_data = array("data" => $myarray);
   //          $this->response($shaing_details_data, 200); // 200 being the HTTP response code
           
   // }

}

?>