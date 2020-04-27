<?php  
header("Access-Control-Allow-Origin: *"); 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class ProgressReport extends REST_Controller {

  public function __construct() {

    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->database();
    $this->load->model('Dashboard_model');

  }

   

  function get_progress_report_post(){

   $company_id =  $this->post('company_id');
   $end_date =  $this->post('date');
   $business_impact_id = $this->post('business_impact_id');      
   $active_only = $this->post('active_only'); 
   $active_color_only = $this->post('active_color_only'); 
   $stage_id = $this->post('stage_id');
   $colorView = $this->post('colorView');     

   $company_level = $this->Dashboard_model->select_level_by_company($company_id);
   $message = $this->Dashboard_model->select_message_by_type('Warning');           
   $all_stages = $this->Dashboard_model->select_all_data_table('master_stages');
   $all_status = $this->Dashboard_model->select_all_data_table('master_status');
   $all_color = $this->Dashboard_model->select_all_color();
   $html_dataset ="";

   $html_dataset ='<div class="row" style="margin-top: 15px;">
                  <div class="col-sm-12">

                     <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF">
                         <tr>
                         <td width="4%" class="side_bottom" style="background-color:#FFF;">
                         <div class="text_div blank1">
                         <p>&nbsp; </p>
                         </div>
                         </td>';
                          foreach ($all_status as $key => $status) {
                           $html_dataset .='<td width="24%" style="border:1px solid #fff;">
                              <div class="grey">'.$status['name'].'</div>
                           </td>';
                           }
                         $html_dataset .='</tr>
                     </table>
                </div>
              </div>


               <div class="row">
               <div class="col-sm-12"> 

               <table width="100%" border="1" cellpadding="0" cellspacing="0" align="center">';
               foreach ($company_level as $key => $level) {
                        
                        $html_dataset .='<tr>
                         <td width="4%" class="side_bottom">
                         <div class="text_div">
                         <p> '.$level['level'].'</p>
                         </div>
                         </td>';
                         foreach ($all_status as $key1 => $status) { 

                         $outcomes = $this->Dashboard_model->select_all_transaction_by_company($level['id'],$level['company_id'],$status['id'],$business_impact_id,$end_date,$active_only,$stage_id,$active_color_only); 

                                  $html_dataset .='<td class="td_height">
                                             <div class="bot_inner2">';
                                              foreach ($outcomes as $key2 => $value) {  

                                                $current_color = $this->Dashboard_model->select_tran_color_by_outcome($value['id']);
                                                  

                                                 if($colorView ==1){
                                                  $btn_bg_color = $current_color[0]['class'];
                                                 }else{
                                                  $btn_bg_color = $value['color'];
                                                 }

                                                $html_dataset .='<div  class="blue_botton '.$btn_bg_color.'" data-toggle="modal" data-target="#exampleModalLong'.$value['id'].'"> 
                                                    <div class=" popup blue_botton_text">'.$value['outcomes'].'</div>
                                                 </div>';

        // ==================================== MOdal Start ================================//
  //                                 <label style="text-transform: uppercase;"> '.$value['outcomes'].'-BO:'.$value['business_impact'].'/STAGE:'.$value['stage'].'/LEVEL:'.$value['level'].'</level>

                                $html_dataset.='<div class="modal fade bd-example-modal-lg" id="exampleModalLong'.$value['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                   <div class="modal-dialog modal-lg">
                                   <div class="modal-content">
                                   <div class="modal-header" style="border-bottom: none;padding: 15px 15px 0px;">

                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                   </button>
                                   <label style="text-transform: uppercase;"> '.$value['outcomes'].' - '.$value['level'].'</level>
                                   </div>
                                   <form>
                                   <div class="modal-body" style="height:600px;">
                                   <ul class="nav nav-tabs">';
                                   if($value['outcome_status'] == 1){ 

                                  $html_dataset.=' <li class="active"><a data-toggle="tab" href="#home'.$value['id'].'">Change Status</a></li>
                                   <li><a data-toggle="tab" href="#menu3'.$value['id'].'">Change Color</a></li>
                                   <li><a data-toggle="tab" href="#menu4'.$value['id'].'">Change Score</a></li>
                                   <li><a data-toggle="tab" href="#menu2'.$value['id'].'">Comments</a></li> 
                                   <li><a data-toggle="tab" href="#menu1'.$value['id'].'">History</a></li>      
                                   
                                  
                                   </ul>';
                                 }else{
                                  $html_dataset.='<li class="active"><a data-toggle="tab" href="#menu1'.$value['id'].'">History</a></li>      
                                      <li><a data-toggle="tab" href="#menu2'.$value['id'].'">Comments</a></li> ';
                                 }


                                   $html_dataset.='</ul><div class="tab-content">';
                                   if($value['outcome_status'] == 1){ 
                                    $html_dataset.='<div id="home'.$value['id'].'" class="tab-pane fade in active">';
                                      }else{
                                     $html_dataset.='<div id="home'.$value['id'].'" class="tab-pane fade">';
                                   }

                                    $html_dataset.='<div class="alert alert-danger" id="success-alert'.$value['id'].'" style="display: none;">
                                   <button type="button" class="close" data-dismiss="alert">x</button>
                                   <strong>Warning! </strong> Current status and selected status are same choose different status.
                                   </div>

                                   <div class="alert alert-danger" id="status_alert'.$value['id'].'" style="display: none;">  
                                   <button type="button" class="close" data-dismiss="alert">x</button>  
                                   <strong>Warning! </strong> Please select status. 
                                   </div>
                                   
                                   <input type="hidden" id="tran_status_id'.$value['id'].'" value="'.$value['tran_status_id'].'">
                                   <input type="hidden" id="previour_status_id'.$value['id'].'" value="'.$value['status_id'].'">

                                   <input type="hidden" id="previous_startdate'.$value['id'].'" value="'.$value['start_date'].'">



                                  <h5 style="    margin-top: 5px;"> Current Status: '.$value['name'].' ('.date("m/d/Y",strtotime($value["start_date"])).'   -   <span id="previous_dt'.$value['id'].'">';

                                  if($value["start_date"] == date('Y-m-d')){
                                    $html_dataset.= date('m/d/Y');
                                  }else{
                                    $html_dataset.= date('m/d/Y',strtotime("-1 days"));
                                  }
                                    

                                   $html_dataset.='</span>)  </h5>

                                   <div class="form-group">                    
                                   <select class="form-control" id="status_id'.$value['id'].'">
                                   <option value="">Select Status</option>';
                                   foreach ($all_status as $key => $value1) { 
                                     $html_dataset.='<option value="'.$value1['id'].'">'.$value1['name'].'</option> '; 
                                   } 
                                   $html_dataset.='</select>
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
                                     $html_dataset.=' <tr>
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

                                    $html_dataset.=' <tr>
                                    <td>'.$list['name'].'</td>
                                    <td>'.$start_date1.'</td>
                                    <td>'.$end_date1.'</td>
                                    <td>'.$list['note'].'</td>
                                    <td>'.$list['add_by'].'</td>

                                    </tr>';
                                  } 

                                  $html_dataset.='</tbody></table></div></div></div>';
                                    if($value['outcome_status'] == 1){ 
                                        $html_dataset.='<div id="menu1'.$value['id'].'" class="tab-pane fade">';
                                    }else{
                                       $html_dataset.='<div id="menu1'.$value['id'].'" class="tab-pane fade in active">';
                                     }

                                   $html_dataset.='<div style="height:520px; overflow-y:scroll;">
                                   <div class="table-responsive">          
                                   <table class="table">

                                   <thead>
                                   <tr>
                                   <th>Type</th>
                                   <th>Note</th>
                                   <th width="25%">Added date</th>
                                   <th width="15%">Added By</th>  
                                   </tr>
                                   </thead>
                                   <tbody>';
                                   $history = $this->Dashboard_model->select_all_comment_action_by_outcome_id($value['id']);

                                   if(empty($history)){
                                     $html_dataset.=' <tr>
                                     <td >'.$message.'</td>              
                                     </tr>';
                                   }
                                  // echo "<pre>";print_r($history);
                                   foreach ($history as $key => $list) {
                                    $start_date1='';
                                     if($list['start_date'] != NULL){
                                      $start_date1 =date('m/d/Y', strtotime($list['start_date']));
                                    }else{
                                      $start_date1 ='';
                                    }
$end_date1 ='';
                                    if($list['end_date'] != NULL){
                                      $end_date1 =date('m/d/Y', strtotime($list['end_date']));
                                      $date_str=$start_date1." - ".$end_date1;
                                    }else{
                                      $end_date1 ='';
                                      $date_str=$start_date1;
                                    } 
                                   // echo "<br>".$value['outcomes']." : $date_str : ".$start_date1." -- ".$end_date1;
                                    $added_date='';
                                      if($list['added_date'] != NULL){
                                        $added_date=date('m/d/Y H:i:s', strtotime($list['added_date']));
                                        }else{
                                        $added_date='';
                                        }
                                       if($list['addBy'] == NULL){
                                        $list['addBy']='';
                                        }
                                 
                                    if($list['row_type']=="Comment"){
                                       $html_dataset.=' <tr>
                                      <td>'.$list['row_type'].'</td>
                                      <td>'.$list['note'].'</td>
                                      <td>'.$added_date.'</td>
                                      <td>'.$list['addBy'].'</td>
                                      </tr>';
                                    }
                                    if($list['row_type']=="Status"){
                                       $html_dataset.=' <tr>
                                      <td>'.$list['NAME'].' ('.$date_str.')</td>
                                      <td>'.$list['note'].'</td>
                                      <td>'.$added_date.'</td>
                                      <td>'.$list['addBy'].'</td>
                                      </tr>';
                                    }
                                    if($list['row_type']=="Color"){
                                      //echo "<pre>";print_r($list);
                                      if($list['NAME']=="GREEN"){
                                        $oval_cl = 'oval_green';
                                      }else if($list['NAME']=='RED'){
                                         $oval_cl= 'oval_red';
                                      }else if($list['NAME']=='YELLOW'){
                                         $oval_cl = 'oval_yellow';
                                      }else if($list['NAME']=='WHITE'){
                                         $oval_cl = 'oval_white';
                                      }
                                      // echo "<pre>$oval_cl";print_r($list);
                                      $html_dataset.=' <tr>
                                      <td><div><div style="height: 20px; width: 40px;float: left;" class="'.$oval_cl.'"></div> <div style="float: left; padding-left: 5px;">  ('.$date_str.')</div></div></td>
                                      <td> '.$list['note'].' </td>
                                      <td>'.$added_date.'</td>
                                      <td>'.$list['addBy'].'</td>
                                      </tr>';
                                    }
                                  } 
                                  
                                  

                                  
                                  $html_dataset.=' </tbody>
                                  </table>
                                  </div>
                                  </div>

                                  </div>

                                  <div id="menu2'.$value['id'].'" class="tab-pane fade">
                                  <div >
                                  <div class="table-responsive" style="height:350px; overflow-y:scroll;">          
                                  <table class="table">
                                  <thead>
                                  <tr>
                                  <th>Comment</th>
                                  <th width="20%"> Date</th>                
                                  <th>Added By</th>

                                  </tr>
                                  </thead>
                                  <tbody id="comment_list'.$value['id'].'">';
                                  $comment = $this->Dashboard_model->select_all_comment_by_outcome_id($value['id']);
                                      //echo "<pre>";print_r( $comment);
                                  if(empty($comment)){
                                   $html_dataset.=' <tr>
                                   <td >'.$message.'</td>              
                                   </tr>';

                                 } 
                                 foreach ($comment as $key => $comment_list) {

                                  if($comment_list['note']){

                                    if($comment_list['added_date'] != NULL){
                                      $add_date =date('n/d/Y H:i:s', strtotime($comment_list['added_date']));
                                    }else{
                                      $add_date ='';
                                    } 

                                    $html_dataset.=' <tr>
                                    <td>'.$comment_list['note'].'</td>                 
                                    <td>'.$add_date.'</td>               
                                    <td>'.$comment_list['addBy'].'</td>              
                                    </tr>';

                                  }
                                  
                                } 

                                $html_dataset.=' </tbody>
                                </table>
                                </div></div>
                                <div class="form-group" style="margin-top:10px;">       
                                <textarea class="form-control" id="comment'.$value['id'].'" placeholder="Enter Comment" style="    height: 70px;"></textarea>
                                </div>

                                <div class="modal-footer">            
                                <button type="button" class="btn btn-primary" onclick="add_comment('."'".$value['id']."'".','.$value['tran_status_id'].');">Save changes</button>
                                </div>
                                </div>

                                <div id="menu3'.$value['id'].'" class="tab-pane fade">

                               <input type="hidden" id="previour_color_id'.$value['id'].'" value="'.$current_color[0]['class_id'].'">
                                <input type="hidden" id="tran_color_id'.$value['id'].'" value="'.$current_color[0]['id'].'">

                                 <input type="hidden" id="previous_colordate'.$value['id'].'" value="'.$current_color[0]["start_date"].'">

                                <div class="alert alert-danger" id="success-alertt'.$value['id'].'" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>Warning! </strong> Current Color and selected color are same choose different status.
                                </div> 


                                 <div class="alert alert-danger" id="color_alert'.$value['id'].'" style="display: none;">  
                                   <button type="button" class="close" data-dismiss="alert">x</button>  
                                   <strong>Warning! </strong> Please select color. 
                                   </div>

                                <h5 style=" margin-top: 5px;"> Current Color: '.$current_color[0]['name'].' ('.date("m/d/Y",strtotime($current_color[0]["start_date"])).'   -   <span id="previous_color'.$value['id'].'">';

                                 if($current_color[0]["start_date"] == date('Y-m-d')){
                                    $html_dataset.= date('m/d/Y');
                                  }else{
                                    $html_dataset.= date('m/d/Y',strtotime("-1 days"));
                                  } 

                                   $html_dataset.='</span>)  </h5>
                                
                                <div class="form-group">                    
                                <select class="form-control" id="color_id'.$value['id'].'">
                                <option value="">Select Color</option>';

                                foreach ($all_color as $key => $value2) { 
                                 $html_dataset.='<option value="'.$value2['id'].'">'.$value2['name'].'</option> '; 
                               } 
                               $html_dataset.='</select>
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
                                     $html_dataset.=' <tr>
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

                                    $html_dataset.=' <tr>
                                    <td><div class="'.$oval_cl.'"></div></td>
                                    <td>'.$start_date1.'</td>
                                    <td>'.$end_date1.'</td>
                                    <td>'.$list1['note'].'</td>
                                    <td>'.$list1['add_by'].'</td>

                                    </tr>';
                                  } 
                                  $html_dataset.=' </tbody>
                                  </table>
                                  </div>
                                  </div>

                               </div> 

                               <div id="menu4'.$value['id'].'" class="tab-pane fade">

                               <div style="height:520px; overflow-y:scroll;">
                               <table class="table" >
                               <tr>'.$value['description'].' </tr>
                                <thead>
                                  <tr>
                                    <th width="15%">Capabilities</th>
                                    <th style="text-align:center;">Acceptance Criteria</th>
                                    <th width="15%">Standard Weight</th>
                                    <th style="text-align:center;">%</th>
                                    <th >Score</th>
                                  </tr>
                                </thead>
                                <tbody>';
                                  $capability = $this->Dashboard_model->get_capability_by_outcome($value['id'],$business_impact_id);

                                  if(empty($capability)){
                                     $html_dataset.=' <tr>
                                     <td >'.$message.'</td>              
                                     </tr>';
                                   }

                                   foreach ($capability as $key => $val) { 
                                    $html_dataset.='<tr>
                                        <td>'.$val['capability'].'</td>
                                        <td>'.$val['acceptance'].'</td>
                                        <td align="center" >'.$val['std_weight'].'%</td>
                                        <td align="center">
                                            <input type="text" style="width: 60%;" value="'.$val['current_percentage'].'"  onchange="get_score(this.value,'.$val['id'].','.$val['std_weight'].');" >%</td>
                                        <td align="center" id="score'.$val['id'].'">'.$val['score'].'%</td>
                                      </tr> '; 
                                   }       
                                  
                                 $html_dataset.=' </tbody>
                              </table> 
                              </div>  
                               </div>   


                               </div>        
                               </div>
                               </form>
                               </div>
                               </div>
                               </div>'; 
                               $html_dataset.='<script type="text/javascript">  

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
     // ======================================= Modal End ========================================//

                                              }

                              $html_dataset .='<div style="clear:both;"></div>
                                               </div>
                                           </td>';
                            }                       

      $html_dataset .='</tr>';
                 }
      $html_dataset .='</table>
         </div>
         </div>';
 echo $html_dataset;
 }



  function select_all_outcomeList_by_level_id_post(){
        $company_id =  $this->post('company_id');
        $level_id =  $this->post('level_id'); 
        $biz_outcome_id =  $this->post('biz_outcome_id'); 
        $message = $this->Dashboard_model->select_message_by_type('Warning');  
        $all_status = $this->Dashboard_model->select_all_data_table('master_status'); 
        $all_color = $this->Dashboard_model->select_all_color();
        $outcomesList = $this->Dashboard_model->select_all_outcomeList_by_level_id($company_id,$level_id,$biz_outcome_id);
        $html_dataset = '';
         if(empty($outcomesList)){
             $html_dataset.=' <tr>
             <td colspan="6" align="center">'.$message.'</td>              
             </tr>';
           }

        
        foreach ($outcomesList as $key => $value) {

            if($value['start_date'] == date('Y-m-d')){
              $start_date=date('m/d/Y', strtotime($value['start_date']));
            }else{
               $start_date=date('m/d/Y', strtotime('-1 day', strtotime($value['start_date'])));
            }

            if($value['color_date'] == date('Y-m-d')){
              $color_date=date('m/d/Y', strtotime($value['color_date']));
            }else{
               $color_date=date('m/d/Y', strtotime('-1 day', strtotime($value['color_date'])));
            } 
               
           $html_dataset .=' <tr>

           <td><div class="blue_botton '.$value['box_color'].'" style="width:150px;"><div class="blue_botton_text">    <div class="popup"   >'.$value['outcomes'].'       </div>       </div>       </div></td>

           <td><div style="width: 165px;"><b>'.$value['level'].'</b><br>Status:'.$value['status_name'].'<br>('. date('m/d/Y', strtotime($value['start_date'])).' - <span id="pre_dt'.$value['id'].'">'.$start_date.'</span>)<br>Color:'.$value['color_name'].'<br>('.date('m/d/Y', strtotime($value['color_date'])).' - <span id="pre_col__dt'.$value['id'].'">'.$color_date.'</span>) </div></td>

           <td><input type="hidden" id="previous_startdate'.$value['id'].'" value="'.$value['start_date'].'"><input type="hidden" id="previous_colordate'.$value['id'].'" value="'.$value['color_date'].'"><input style="width:100px;" type="text" class="form-control" onblur="setprevious_dt('.$value['id'].',this.value)"  id="start_date'.$value['id'].'"></td>

           <td><textarea style="width:240px;"  class="form-control"  id="note'.$value['id'].'">'.$value['note'].'</textarea><br> <a style="cursor:pointer;color: #73879C;" onclick="getHistory('.$value['id'].',\''.$value['outcomes'].'\',\''.$value['business_impact'].'\',\''.$value['stage'].'\',\''.$value['level'].'\')">Show History</a></td>

           <td><input type="hidden" id="tran_status_id'.$value['id'].'" value="'.$value['tran_status_id'].'"><select class="form-control" id="outcome_status_id'.$value['id'].'" onchange="change_status('.$value['id'].',\'' .$value['status_name']. '\',\'' .$value['outcomes']. '\')">';

            foreach ($all_status as $key => $status1) {  
               $html_dataset .='<option value="'.$status1['id'].'"';

               if($status1['id']==$value['status_id']){
                 $html_dataset .='selected';
               } 
              $html_dataset .=' >'.$status1['name'].'</option> ';
            }
            $html_dataset .='</select></td>

           <td><input type="hidden" id="tran_color_id'.$value['id'].'" value="'.$value['tran_color_id'].'"><select class="form-control" id="outcome_color_id'.$value['id'].'" onchange="change_color('.$value['id'].',\'' .$value['color_name']. '\',\'' .$value['outcomes']. '\')">';

            foreach ($all_color as $key => $color) {  
               $html_dataset .='<option value="'.$color['id'].'" ';

                if($color['id']==$value['class_id']){
                 $html_dataset .='selected';
               } 
              $html_dataset .=' >'.$color['name'].'</option> ';
            }
              $html_dataset .='</select></td></tr> 

              <script type="text/javascript">  
              $("#start_date'.$value['id'].'").datetimepicker({
              format: "MM/DD/YYYY",
              defaultDate: new Date()
              })
              .on("dp.change", function (e) { 
                
                var dateObj = new Date(e.date);   
                dateObj.setDate(dateObj.getDate() - 1);  
                $("#pre_dt'.$value['id'].'").html(getFormattedDate(dateObj));
                $("#pre_col__dt'.$value['id'].'").html(getFormattedDate(dateObj)); 
                }); </script>';  
          
        }

        echo $html_dataset;exit;  
   }  

}

?>