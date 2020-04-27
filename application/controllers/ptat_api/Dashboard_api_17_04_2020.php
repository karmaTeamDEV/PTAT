<?php  
header("Access-Control-Allow-Origin: *"); 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Dashboard_api extends REST_Controller {

  public function __construct() {

    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->database();
    $this->load->model('Dashboard_model');

  }

  public function index()
  {

  }

  function get_process_report_result_post(){
   $company_id =  $this->post('company_id');
   $end_date =  $this->post('date');
   $business_impact_id = $this->post('business_impact_id');      
   $active_only = $this->post('active_only'); 
   $active_color_only = $this->post('active_color_only'); 
   $stage_id = $this->post('stage_id');     

   $company_level = $this->Dashboard_model->select_level_by_company($company_id);
   $message = $this->Dashboard_model->select_message_by_type('Warning');
    //echo "<pre>";print_r($data);exit; 
   $all_stages = $this->Dashboard_model->select_all_data_table('master_stages');
   $all_status = $this->Dashboard_model->select_all_data_table('master_status');
   $all_color = $this->Dashboard_model->select_all_color();
   $html_var="";
   foreach ($company_level as $key => $level) {
    $html_var.='<div class="row">
    <div class="col-sm-12">
    <div class="part1">
    <div class="side_bot_space">
    <div class="side_bot">
    <div class="a3">'.$level['level'].'</div> 
    </div>
    </div>
    </div>



    <div class="part2">
    <div class="line">';
    foreach ($all_status as $key => $status) {  

     $html_var.='<div class="portion">
     <div class="bot_inner2">';
     $backlog = $this->Dashboard_model->select_all_transaction_by_company($level['id'],$level['company_id'],$status['id'],$business_impact_id,$end_date,$active_only,$stage_id,$active_color_only);
//echo $this->db->last_query()."<br>";
//echo "<pre>";print_r($backlog);
     foreach ($backlog as $key => $value) { 

       $current_color = $this->Dashboard_model->select_tran_color_by_outcome($value['id']);

       $html_var.='<div class="blue_botton '.$value['color'].'">
       <div class="blue_botton_text">';
        if($value['outcome_status'] == 1){
        $html_var.='<div class="popup" data-toggle="modal" data-target="#exampleModalLong'.$value['id'].'" >'.$value['outcomes'].'</div>';
        }else{
           $html_var.='<div style="border-bottom: 2px solid gray;" class="popup" data-toggle="modal" data-target="#exampleModalLong'.$value['id'].'" >'.$value['outcomes'].'</div>';
        }

        $html_var.='</div>
       </div>';

       $html_var.='<div class="modal fade bd-example-modal-lg" id="exampleModalLong'.$value['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
       <div class="modal-dialog modal-lg">
       <div class="modal-content">
       <div class="modal-header" style="border-bottom: none;padding: 15px 15px 0px;">

       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=">
       <span aria-hidden="true">&times;</span>
       </button>
       <label style="text-transform: uppercase;"> '.$value['outcomes'].'-BO:'.$value['business_impact'].'/STAGE:'.$value['stage'].'/LEVEL:'.$value['level'].'</level>
       </div>
       <form>
       <div class="modal-body">
       <ul class="nav nav-tabs">';
       if($value['outcome_status'] == 1){ 

      $html_var.=' <li class="active"><a data-toggle="tab" href="#home'.$value['id'].'">Change Status</a></li>
       <li><a data-toggle="tab" href="#menu3'.$value['id'].'">Change Color</a></li>
       <li><a data-toggle="tab" href="#menu4'.$value['id'].'">Change Score</a></li>
       <li><a data-toggle="tab" href="#menu2'.$value['id'].'">Comments</a></li> 
       <li><a data-toggle="tab" href="#menu1'.$value['id'].'">History</a></li>      
       
      
       </ul>';
     }else{
      $html_var.='<li class="active"><a data-toggle="tab" href="#menu1'.$value['id'].'">Status History</a></li>      
          <li><a data-toggle="tab" href="#menu2'.$value['id'].'">Comments</a></li> ';
     }


       $html_var.='</ul><div class="tab-content">';
       if($value['outcome_status'] == 1){ 
        $html_var.='<div id="home'.$value['id'].'" class="tab-pane fade in active">';
          }else{
         $html_var.='<div id="home'.$value['id'].'" class="tab-pane fade">';
       }

        $html_var.='<div class="alert alert-danger" id="success-alert'.$value['id'].'" style="display: none;">
       <button type="button" class="close" data-dismiss="alert">x</button>
       <strong>Warning! </strong> Current status and selected status are same.choose different status.
       </div>
       <input type="hidden" id="tran_status_id'.$value['id'].'" value="'.$value['tran_status_id'].'">
       <input type="hidden" id="previour_status_id'.$value['id'].'" value="'.$value['status_id'].'">



       <h5 style="    margin-top: 5px;"> Current Status: '.$value['name'].' ('.date("m/d/Y",strtotime($value["start_date"])).'   -   <span id="previous_dt'.$value['id'].'">'.date('m/d/Y',strtotime("-1 days")).'</span>)  </h5>

       <div class="form-group">                    
       <select class="form-control" id="status_id'.$value['id'].'">
       <option value="">Select Status</option>';
       foreach ($all_status as $key => $value1) { 
         $html_var.='<option value="'.$value1['id'].'">'.$value1['name'].'</option> '; 
       } 
       $html_var.='</select>
       </div>


       <div class="form-group">        
       <input type="text" class="form-control " id="date'.$value['id'].'"  placeholder="Start Date" );"/>
       </div>

       <div class="form-group">       
       <textarea class="form-control" id="note'.$value['id'].'" placeholder="Enter Note"></textarea>
       </div>


       <div class="modal-footer">      
       <button type="button" class="btn btn-primary" onclick="change_status('."'".$value['id']."'".');">Save changes</button>
       </div>

       <div style="height:280px; overflow-y:scroll;">
       <div class="table-responsive">          
       <table class="table">

       <thead>
       
       <tr>
       <th>Status</th>
       <th>Start Date</th>
       <th>End Date</th>
       <th>Note</th>
       <th>Added By</th>

       </tr>
       </thead>
       <tbody>';
       $history = $this->Dashboard_model->select_all_history_by_outcome_id($value['id']);

       if(empty($history)){
         $html_var.=' <tr>
         <td >'.$message.'</td>              
         </tr>';
       }

       foreach ($history as $key => $list) {
         if($list['start_date'] != NULL){
          $start_date1 =date('m/d/Y', strtotime($list['start_date']));
        }else{
          $start_date1 ='';
        }

        if($list['end_date'] != NULL){
          $end_date1 =date('m/d/Y', strtotime($list['end_date']));
        }else{
          $end_date1 ='';
        } 

        $html_var.=' <tr>
        <td>'.$list['name'].'</td>
        <td>'.$start_date1.'</td>
        <td>'.$end_date1.'</td>
        <td>'.$list['note'].'</td>
        <td>'.$list['add_by'].'</td>

        </tr>';
      } 

      $html_var.='</tbody></table></div></div></div>';
        if($value['outcome_status'] == 1){ 
            $html_var.='<div id="menu1'.$value['id'].'" class="tab-pane fade">';
        }else{
           $html_var.='<div id="menu1'.$value['id'].'" class="tab-pane fade in active">';
         }

       $html_var.='<div style="height:280px; overflow-y:scroll;">
       <div class="table-responsive">          
       <table class="table">

       <thead>
       <tr><td colspan="5" align="center"><b>Status History</b></td></tr>
       <tr>
       <th>Status</th>
       <th>Start Date</th>
       <th>End Date</th>
       <th>Note</th>
       <th>Added By</th>

       </tr>
       </thead>
       <tbody>';
       $history = $this->Dashboard_model->select_all_history_by_outcome_id($value['id']);

       if(empty($history)){
         $html_var.=' <tr>
         <td >'.$message.'</td>              
         </tr>';
       }

       foreach ($history as $key => $list) {
         if($list['start_date'] != NULL){
          $start_date1 =date('m/d/Y', strtotime($list['start_date']));
        }else{
          $start_date1 ='';
        }

        if($list['end_date'] != NULL){
          $end_date1 =date('m/d/Y', strtotime($list['end_date']));
        }else{
          $end_date1 ='';
        } 

        $html_var.=' <tr>
        <td>'.$list['name'].'</td>
        <td>'.$start_date1.'</td>
        <td>'.$end_date1.'</td>
        <td>'.$list['note'].'</td>
        <td>'.$list['add_by'].'</td>

        </tr>';
      } 
      $html_var.=' <tr><td colspan="5" align="center"><b>Color History</b></td></tr>';
      $color_history = $this->Dashboard_model->select_all_color_history_by_outcome_id($value['id']);

       if(empty($color_history)){
         $html_var.=' <tr>
         <td >'.$message.'</td>              
         </tr>';
       } 

       foreach ($color_history as $key => $list1) {
         if($list1['start_date'] != NULL){
          $start_date1 =date('m/d/Y', strtotime($list1['start_date']));
        }else{
          $start_date1 ='';
        }

        if($list1['end_date'] != NULL){
          $end_date1 =date('m/d/Y', strtotime($list1['end_date']));
        }else{
          $end_date1 ='';
        } 

         if($list1['name']=='GREEN'){
          $oval_cl = 'oval_green';
        }else if($list1['name']=='RED'){
           $oval_cl = 'oval_red';
        }else if($list1['name']=='YELLOW'){
           $oval_cl = 'oval_yellow';
        }else if($list1['name']=='WHITE'){
           $oval_cl = 'oval_white';
        }

        $html_var.=' <tr>
        <td><div class="'.$oval_cl.'"></div></td>
        <td>'.$start_date1.'</td>
        <td>'.$end_date1.'</td>
        <td>'.$list1['note'].'</td>
        <td>'.$list1['add_by'].'</td>

        </tr>';
      } 
      $html_var.=' </tbody>
      </table>
      </div>
      </div>

      </div>

      <div id="menu2'.$value['id'].'" class="tab-pane fade">
      <div >
      <div class="table-responsive" style="height:200px; overflow-y:scroll;">          
      <table class="table">
      <thead>
      <tr>
      <th>Comment</th>
      <th> Date</th>                
      <th>Added By</th>

      </tr>
      </thead>
      <tbody id="comment_list'.$value['id'].'">';
      $comment = $this->Dashboard_model->select_all_comment_by_outcome_id($value['id']);
          //echo "<pre>";print_r( $comment);
      if(empty($comment)){
       $html_var.=' <tr>
       <td >'.$message.'</td>              
       </tr>';

     } 
     foreach ($comment as $key => $comment_list) {

       if($comment_list['added_date'] != NULL){
        $add_date =date('n/d/Y H:i:s', strtotime($comment_list['added_date']));
      }else{
        $add_date ='';
      } 


      $html_var.=' <tr>
      <td>'.$comment_list['note'].'</td>                 
      <td>'.$add_date.'</td>               
      <td>'.$comment_list['addBy'].'</td>              
      </tr>';
    } 



    $html_var.=' </tbody>
    </table>
    </div></div>
    <div class="form-group">       
    <textarea class="form-control" id="comment'.$value['id'].'" placeholder="Enter Comment"></textarea>
    </div>

    <div class="modal-footer">            
    <button type="button" class="btn btn-primary" onclick="add_comment('."'".$value['id']."'".','.$value['tran_status_id'].');">Save changes</button>
    </div>
    </div>

    <div id="menu3'.$value['id'].'" class="tab-pane fade">

   <input type="hidden" id="previour_color_id'.$value['id'].'" value="'.$current_color[0]['class_id'].'">
    <input type="hidden" id="tran_color_id'.$value['id'].'" value="'.$current_color[0]['id'].'">

    <div class="alert alert-danger" id="success-alertt'.$value['id'].'" style="display: none;">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Warning! </strong> Current Color and selected color are same.choose different status.
    </div> 

    <h5 style=" margin-top: 5px;"> Current Color: '.$current_color[0]['name'].' ('.date("m/d/Y",strtotime($current_color[0]["start_date"])).'   -   <span id="previous_color'.$value['id'].'">'.date('m/d/Y',strtotime("-1 days")).'</span>)  </h5>
    
    <div class="form-group">                    
    <select class="form-control" id="color_id'.$value['id'].'">
    <option value="">Select Color</option>';

    foreach ($all_color as $key => $value2) { 
     $html_var.='<option value="'.$value2['id'].'">'.$value2['name'].'</option> '; 
   } 
   $html_var.='</select>
   </div>


   <div class="form-group">        
   <input type="text" class="form-control " id="color_date'.$value['id'].'"  placeholder="Start Date" );"/>
   </div>

   <div class="form-group">       
   <textarea class="form-control" id="color_note'.$value['id'].'" placeholder="Enter Note"></textarea>
   </div>


   <div class="modal-footer">      
   <button type="button" class="btn btn-primary" onclick="change_color('."'".$value['id']."'".');">Save changes</button>
   </div> 


   <div style="height:280px; overflow-y:scroll;">
       <div class="table-responsive">          
       <table class="table">
       <thead>       
       <tr>
       <th>Status</th>
       <th>Start Date</th>
       <th>End Date</th>
       <th>Note</th>
       <th>Added By</th>
       </tr>
       </thead>
       <tbody>';
      
      $color_history = $this->Dashboard_model->select_all_color_history_by_outcome_id($value['id']);

       if(empty($color_history)){
         $html_var.=' <tr>
         <td >'.$message.'</td>              
         </tr>';
       } 

       foreach ($color_history as $key => $list1) {
         if($list1['start_date'] != NULL){
          $start_date1 =date('m/d/Y', strtotime($list1['start_date']));
        }else{
          $start_date1 ='';
        }

        if($list1['end_date'] != NULL){
          $end_date1 =date('m/d/Y', strtotime($list1['end_date']));
        }else{
          $end_date1 ='';
        } 

         if($list1['name']=='GREEN'){
          $oval_cl = 'oval_green';
        }else if($list1['name']=='RED'){
           $oval_cl = 'oval_red';
        }else if($list1['name']=='YELLOW'){
           $oval_cl = 'oval_yellow';
        }else if($list1['name']=='WHITE'){
           $oval_cl = 'oval_white';
        }

        $html_var.=' <tr>
        <td><div class="'.$oval_cl.'"></div></td>
        <td>'.$start_date1.'</td>
        <td>'.$end_date1.'</td>
        <td>'.$list1['note'].'</td>
        <td>'.$list1['add_by'].'</td>

        </tr>';
      } 
      $html_var.=' </tbody>
      </table>
      </div>
      </div>

   </div> 

   <div id="menu4'.$value['id'].'" class="tab-pane fade">


   <table class="table">
   <tr>'.$value['description'].' </tr>
    <thead>
      <tr>
        <th width="15%">Capabilities</th>
        <th style="text-align:center;">Acceptance Criteria</th>
        <th width="15%">Standard Weight</th>
        <th width="17%">Current Percentage</th>
        <th>Score</th>
      </tr>
    </thead>
    <tbody>';
      $capability = $this->Dashboard_model->get_capability_by_outcome($value['id'],$business_impact_id);

      if(empty($capability)){
         $html_var.=' <tr>
         <td >'.$message.'</td>              
         </tr>';
       }

       foreach ($capability as $key => $val) { 
        $html_var.='<tr>
            <td>'.$val['capability'].'</td>
            <td>'.$val['acceptance'].'</td>
            <td align="center" >'.$val['std_weight'].'%</td>
            <td align="center">
                <input type="text" style="width: 35%;" value="'.$val['current_percentage'].'"  onchange="get_score(this.value,'.$val['id'].','.$val['std_weight'].');" >%</td>
            <td id="score'.$val['id'].'">'.$val['score'].'%</td>
          </tr> '; 
       }       
      
     $html_var.=' </tbody>
  </table> 
   </div>   


   </div>        
   </div>
   </form>
   </div>
   </div>
   </div>'; 
   $html_var.='<script type="text/javascript">  

      $("#color_date'.$value['id'].'").datetimepicker({
    format: "MM/DD/YYYY",
    defaultDate: new Date()
    })
    .on("dp.change", function (e) { 
      
      var dateObj = new Date(e.date);   
      dateObj.setDate(dateObj.getDate() - 1);  
      $("#previous_color'.$value['id'].'").html(getFormattedDate(dateObj));
      });

      $("#date'.$value['id'].'").datetimepicker({
        format: "MM/DD/YYYY",
        defaultDate: new Date()
        })
        .on("dp.change", function (e) { 

          var dateObj = new Date(e.date);   
          dateObj.setDate(dateObj.getDate() - 1);  
          $("#previous_dt'.$value['id'].'").html(getFormattedDate(dateObj));
          });

          </script>';

        }  

        $html_var.='</div>
        </div>';
      }




      $html_var.='<div style="clear:both;"></div>
      </div>
      </div>
      </div>
      </div>';



    }
   echo $html_var; 


  }


  function get_dashboard_report_post(){
   $company_id =  $this->post('company_id');
   $end_date =  $this->post('date');
   $business_impact_id = $this->post('business_impact_id');      
   $active_only = $this->post('active_only'); 
   $active_color_only = $this->post('active_color_only'); 
   $stage_id = $this->post('stage_id');     
   
   $company_level = $this->Dashboard_model->select_level_by_company($company_id);
   $message = $this->Dashboard_model->select_message_by_type('Warning');
    //$biz_impact = $this->Dashboard_model->select_all_company_biz($company_id]);
    //echo "<pre>";print_r($data);exit; 
   $all_stages = $this->Dashboard_model->select_all_data_table('master_stages');
   $all_status = $this->Dashboard_model->select_all_data_table('master_status');
  
   $html_var="";
   foreach ($company_level as $key => $level) {
    $html_var.='<div class="row">
    <div class="col-sm-12">
    <div class="part1">
    <div class="side_bot_space">
    <div class="side_bot">
    <div class="a3">'.$level['level'].'</div> 
    </div>
    </div>
    </div>



    <div class="part2">
    <div class="line">';
    foreach ($all_status as $key => $status) {  

     $html_var.='<div class="portion">
     <div class="bot_inner2">';
     $backlog = $this->Dashboard_model->select_all_transaction_by_company($level['id'],$level['company_id'],$status['id'],$business_impact_id,$end_date,$active_only,$stage_id,$active_color_only);
//echo $this->db->last_query()."<br>";
//echo "<pre>";print_r($backlog);
     foreach ($backlog as $key => $value) { 
 
      $current_color = $this->Dashboard_model->select_tran_color_by_outcome($value['id']);
//echo "<pre>";print_r($current_color);

       $html_var.='<div class="blue_botton '.$current_color[0]['class'].'">
       <div class="blue_botton_text">    
       <div class="popup" data-toggle="modal" data-target="#exampleModalLong'.$value['id'].'" >'.$value['outcomes'].'
       
       </div>
       </div>
       </div>';

       $html_var.='<div class="modal fade" id="exampleModalLong'.$value['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
       <div class="modal-dialog" role="document">
       <div class="modal-content">
       <div class="modal-header" style="border-bottom: none;padding: 15px 15px 0px;">

       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=">
       <span aria-hidden="true">&times;</span>
       </button>
       <label style="text-transform: uppercase;">'.$value['outcomes'].'-BO:'.$value['business_impact'].'/STAGE:'.$value['stage'].'/LEVEL:'.$value['level'].'</level>
       </div>
       <form>
       <div class="modal-body">
       <ul class="nav nav-tabs">      
       <li class="active"><a data-toggle="tab" href="#menu1'.$value['id'].'">History</a></li>      
       <li><a data-toggle="tab" href="#menu2'.$value['id'].'">Comments</a></li>       
       </ul>
       

       <div class="tab-content">
      
       <div id="menu1'.$value['id'].'" class="tab-pane fade in active">
       <div style="height:280px; overflow-y:scroll;">
       <div class="table-responsive">          
       <table class="table">
       <thead>
        <tr><td colspan="5" align="center"><b>Status History</b></td></tr>
       <tr>
       <th>Status</th>
       <th>Start Date</th>
       <th>End Date</th>
       <th>Note</th>
       <th>Added By</th>
       
       </tr>
       </thead>
       <tbody>';
       $history = $this->Dashboard_model->select_all_history_by_outcome_id($value['id']);
        if(empty($history)){
         $html_var.=' <tr>
         <td >'.$message.'</td>              
         </tr>';
       }
       foreach ($history as $key => $list) {
         if($list['start_date'] != NULL){
          $start_date1 =date('m/d/Y', strtotime($list['start_date']));
        }else{
          $start_date1 ='';
        }

        if($list['end_date'] != NULL){
          $end_date1 =date('m/d/Y', strtotime($list['end_date']));
        }else{
          $end_date1 ='';
        } 

        $html_var.=' <tr>
        <td>'.$list['name'].'</td>
        <td>'.$start_date1.'</td>
        <td>'.$end_date1.'</td>
        <td>'.$list['note'].'</td>
        <td>'.$list['add_by'].'</td>

        </tr>';
      } 
      $html_var.=' <tr><td colspan="5" align="center"><b>Color History </b></td></tr>';
      $color_history = $this->Dashboard_model->select_all_color_history_by_outcome_id($value['id']);
      if(empty($color_history)){
         $html_var.=' <tr>
         <td >'.$message.'</td>              
         </tr>';
       }
       foreach ($color_history as $key => $list1) {
         if($list1['start_date'] != NULL){
          $start_date1 =date('m/d/Y', strtotime($list1['start_date']));
        }else{
          $start_date1 ='';
        }

        if($list1['end_date'] != NULL){
          $end_date1 =date('m/d/Y', strtotime($list1['end_date']));
        }else{
          $end_date1 ='';
        } 

        if($list1['name']=='GREEN'){
          $oval_cl = 'oval_green';
        }else if($list1['name']=='RED'){
           $oval_cl = 'oval_red';
        }else if($list1['name']=='YELLOW'){
           $oval_cl = 'oval_yellow';
        }else if($list1['name']=='WHITE'){
           $oval_cl = 'oval_white';
        }

        $html_var.=' <tr>
        <td><div class="'.$oval_cl.'"></div></td>
        <td>'.$start_date1.'</td>
        <td>'.$end_date1.'</td>
        <td>'.$list1['note'].'</td>
        <td>'.$list1['add_by'].'</td>

        </tr>';
      } 
      $html_var.=' </tbody>
      </table>
      </div>
      </div>
      
      </div>
      <div id="menu2'.$value['id'].'" class="tab-pane fade">
      <div >
      <div class="table-responsive" style="height:280px; overflow-y:scroll;">          
      <table class="table">
      <thead>
      <tr>
      <th>Comment</th>
      <th> Date</th>                
      <th>Added By</th>
      
      </tr>
      </thead>
      <tbody id="comment_list'.$value['id'].'">';
      $comment = $this->Dashboard_model->select_all_comment_by_outcome_id($value['id']);
          //echo "<pre>";print_r( $comment);
     if(empty($comment)){
       $html_var.=' <tr>
       <td >'.$message.'</td>              
       </tr>';

     } 
     foreach ($comment as $key => $comment_list) {

       if($comment_list['added_date'] != NULL){
        $add_date =date('n/d/Y H:i:s', strtotime($comment_list['added_date']));
      }else{
        $add_date ='';
      } 
      

      $html_var.=' <tr>
      <td>'.$comment_list['note'].'</td>                 
      <td>'.$add_date.'</td>               
      <td>'.$comment_list['addBy'].'</td>              
      </tr>';
    } 



    $html_var.=' </tbody>
    </table>
    </div></div>
    
    </div>


    

   
   </div>        
   </div>
   
   </form>
   </div>
   </div>
   </div>';  

        } 



        $html_var.='</div>
        </div>';
      }




      $html_var.='<div style="clear:both;"></div>
      </div>
      </div>
      </div>
      </div>';



    }
    echo $html_var; 

  }

        function insert_update_level_data_for_spider_post(){
                    $company_id =  $this->post('company_id');
                    $data_date =  date('Y-m-d',strtotime($this->post('data_date')));
                    $outcome_id =  $this->post('outcome_id');
                    $total =  $this->post('total');
                    $score =  $this->post('score');

 

                    $insert_id = $this->Dashboard_model->get_spider_data_by_company_date_outcome($company_id,$data_date,$outcome_id);
                    //
                    $data1['total']=$total;
                    $data1['score']= $score;


                    if($insert_id){
                      $insert_id = $this->Dashboard_model->update_data_table($data1, 'id', $insert_id, 'spider_chart_data');

                    }else{
                     $data1['company_id']=$company_id;
                     $data1['outcome_id']=$outcome_id;
                     $data1['data_date']=$data_date;
                    $insert_id = $this->Dashboard_model->ins_data_table($data1,'spider_chart_data');
                    }

                    //echo "<pre>";print_r($data1);exit;
                      $this->response($insert_id, 200); // 200 being the HTTP response code


        }
      





   function get_level_data_for_spider_post(){
            $company_id =  $this->post('company_id');
            $level_id =  $this->post('level_id');
            $data_date =  $this->post('data_date');

     $backlog = $this->Dashboard_model->select_all_transaction_by_level($company_id,$level_id,$data_date);
 
        if($backlog)
        {
            $this->response($backlog, 200); // 200 being the HTTP response code
        }
        else
        {
            $getEmpSalary = array('message' => 'Record not found', );
            $this->response($getEmpSalary, 404);
        }
         }
       function get_level_data_for_spider_chart_post(){
          $company_id =  $this->post('company_id');
          $level_id =  $this->post('level_id');
         // $data_date =  $this->post('data_date');
          $level_str="";
          $level_only = $this->Dashboard_model->select_all_transaction_by_level_only($company_id,$level_id);
          foreach($level_only as $level){
            $level_str.= "'".$level."',";
          }
          $level_str=rtrim($level_str, ',');

          $level_data = $this->Dashboard_model->select_all_transaction_by_level_with_data($company_id,$level_id);
          $level_data_array=array();
          foreach($level_data as $data){
            $level_data_array[$data['data_date']][$data['id']]=round($data['id']/$data['id']*100);
          }
            $final_level_data_array=array();

          foreach($level_data_array as $key->$level_data){

              $data_str="";
              foreach($level_data as $data) {
                  $data_str.= $data.",";
              }             
                 $data_str=rtrim($data_str, ',');
                 $temp_arr['key']=$key;
                 $temp_arr['data_str']=$data_str;
            array_push($final_level_data_array,$temp_arr);

          }
          $return_array['level_name']=$level_str;
          $return_array['data_str']=$final_level_data_array;

          
            $this->response($return_array, 200); // 200 being the HTTP response code
          
         }




}

?>