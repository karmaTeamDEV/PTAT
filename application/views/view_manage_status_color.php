
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Path To Agility</title>
  <link href="<?php echo base_path;?>design/build/css/mystyle.css" rel="stylesheet">
  <?php include('include/css_include.php'); ?>
  <?php //include('include/chart_module.php'); ?>

</head>
<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php include('include/left_menu.php'); ?>
      <!-- top navigation -->
      <?php include('include/top_menu.php'); ?>
      <!-- /top navigation -->
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel" style="padding-bottom:0px;padding-top:0px;">

           <div class="row">
            <div class="col-sm-12 col-md-12" >
              <h3 class="text1">Manage Outcome Status/Color</h3>
            </div>
          </div>
          


          <div class="row" style="margin-top: 15px;">
            <div class=" col-lg-12 col-md-12 col-sm-12">

           

               <div class=" col-lg-4 col-md-4  col-sm-4" >
                <select  id="biz_outcome_id" class="form-control" onchange="get_all_outcome('<?php echo $company_id?>');">
                  <option value="">SELECT BUSINESS OUTCOME</option>
                  <?php foreach($all_biz_impactList as $biz){?>
                    <option value="<?php echo $biz['id'];?>"><?php echo $biz['business_impact'];?></option>
                  <?php }?>
                </select>
              </div>

              <div class=" col-lg-3 col-md-3  col-sm-3" >
                <select id="level_id" class="form-control" onchange="get_all_outcome('<?php echo $company_id?>');">
                  <option value="">SELECT LEVEL</option>
                  <?php foreach($company_level as $level){?>
                    <option value="<?php echo $level['id'];?>"><?php echo $level['level'];?></option>
                  <?php }?>
                </select>
              </div>


 
         </div> 
        
         
         <!-- 1st row--> 

         <div class="col-sm-12 col-md-12" style="margin-top: 15px;"> 
          <div id="loader" style="display: none;"><img style=" position: absolute;left: 34%; top: -20%; width: 15%;" src="<?php echo base_url().'design/build/images/loader.gif'; ?>"></div>
          <div class="alert alert-danger" id="save_success" style="display: none; ">
               <button type="button" class="close" data-dismiss="alert">x</button>
               <strong id="msg"></strong> 
           </div>

          <table class="table  table-striped table-bordered table-hover dataTable no-footer" id="level_score_table_id" role="grid">
            <thead>
              <tr>
                <td><h4>Agile Outcome</h4></td>                 
                <td align="center"><h4> Current Status</h4></td>
                <td align="center"><h4>Start Date</h4></td>
                <td align="center"><h4>Note</h4></td>
                <td align="center"><h4>Status</h4></td>
                <td align="center"><h4>Color</h4></td>
                
              </tr>
            </thead>
            <tbody id="level_score_table_body_id"> 

              <tr>
             <td colspan="6" align="center"><?php echo $message; ?></td>              
             </tr> 
           </tbody>
          </table>

        </div>
 
 

</div>
</div>
</div>
</div>
</div>
</div>


<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- dialog body -->
            <div class="modal-body" id="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div id="headertxt"></div>
            </div>
            <!-- dialog buttons -->
            <div class="modal-footer">
              <ul class="nav nav-tabs">
                 <li class="active"><a data-toggle="tab" href="#menu1">History</a></li>  
                 <li><a data-toggle="tab" href="#menu2">Comments</a></li>                 
              </ul>

              <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active">
                  <div style="height:520px; overflow-y:scroll;"> 
                    <div class="table-responsive">  
                      <table class="table">  <thead> 
                        <tr>  <th>Status</th> <th>Start Date</th> <th>End Date</th>  <th>Note</th>   <th>Added By</th>  </tr> 
                        <tr><td colspan="5" align="center"><b>Status History</b></td></tr></thead> 
                         <tbody id="history_id">  </tbody> 
                         <tr><td colspan="5" align="center"><b>Color History</b></td></tr>
                         <tbody id="color_id">  </tbody>
                       </table> </div> </div>  
                </div>
                <div id="menu2" class="tab-pane fade">
                   <div class="table-responsive" style="height:500px; overflow-y:scroll;"> 
                    <table class="table">
                      <thead><tr><th>Comment</th><th>Date and Time</th>
                        <th width="20%">  Added By</th></tr></thead>
                        <tbody id="comment_id"></tbody>
                      </table></div>
                </div>
              </div>

            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<!-- footer content -->
<?php include('include/footer.php'); ?>
<!-- /footer content -->
<script type="text/javascript" src="<?php echo base_path;?>design/build/js/bootbox.js"></script>
<script type="text/javascript">

  function get_all_outcome(company_id){
 
     var biz_outcome_id = $('#biz_outcome_id').val();
     var level_id = $('#level_id').val();
     $.ajax({
       type: "POST",
       url: '<?php echo base_url();?>index.php/ptat_api/ProgressReport/select_all_outcomeList_by_level_id/',
       data: { company_id: company_id,level_id: level_id,biz_outcome_id: biz_outcome_id} ,
       async: false ,
     })
     .success(function (data, textStatus, xhr){
 
      $('#level_score_table_body_id').html(data);
           
                   
    })      
     .fail(function (jqXHR, textStatus, errorThrown){
     // $("#level_score_table_id").DataTable().clear(); 
       alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
     }); 
 } 

function setprevious_dt(id,date){ 
   var dateObj = new Date(date);   
   dateObj.setDate(dateObj.getDate() - 1); 
   $("#pre_dt"+id).html(getFormattedDate(dateObj));
   $("#pre_col__dt"+id).html(getFormattedDate(dateObj));
   
}

// $(document).ready(function() {
//  $('#level_score_table_id').DataTable({
//    "pageLength": 50
//  });  
// }); 


function change_status(tran_outcome_id,status_name,outcomes){

   var start_date = $('#start_date'+tran_outcome_id).val();    
   var status_id = $('#outcome_status_id'+tran_outcome_id).val(); 
   var tran_status_id = $('#tran_status_id'+tran_outcome_id).val(); 
   var note = $('#note'+tran_outcome_id).val();  
   var change_status = $( "#outcome_status_id"+tran_outcome_id+" option:selected" ).text(); 
   var previous_startdate = $('#previous_startdate'+tran_outcome_id).val();
 
      $.ajax({
       type: "POST",
       url: '<?php echo site_url;?>ptat_api/Api/change_status',
       data: { <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',tran_outcome_id: tran_outcome_id,tran_status_id:tran_status_id,status_id:status_id,note:note,start_date:start_date,previous_startdate:previous_startdate} ,
       async: false ,
       })
       .success(function (data, textStatus, xhr){  
         //alert(data);

        if(data){
          $('#tran_status_id'+tran_outcome_id).val(data); 
          $('#save_success').show();
          $('#msg').html('Status changed from "'+status_name+'" to "'+change_status+'" for "'+outcomes+'"');
          $("#save_success").fadeTo(6000, 500).slideUp("slow", function() {
            $("#save_success").slideUp("slow");
          });

        }
          
       })          
       .fail(function (jqXHR, textStatus, errorThrown){
           alert("Record Not found.");
      });
} 

function change_color(tran_outcome_id,color_name,outcomes){

    var color_date = $('#start_date'+tran_outcome_id).val();    
    var tran_color_id = $('#tran_color_id'+tran_outcome_id).val(); 
    var color_note = $('#note'+tran_outcome_id).val(); 
    var color_id = $('#outcome_color_id'+tran_outcome_id).val();
    var change_color = $( "#outcome_color_id"+tran_outcome_id+" option:selected" ).text();  
    var previous_colordate = $('#previous_colordate'+tran_outcome_id).val();
 
      $.ajax({
       type: "POST",
       url: '<?php echo site_url;?>ptat_api/Api/change_color',
       data: { <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',tran_outcome_id: tran_outcome_id,tran_color_id:tran_color_id,color_id:color_id,color_date:color_date,color_note:color_note,previous_colordate:previous_colordate} ,
       async: false ,
       })
       .success(function (data, textStatus, xhr){  
         
         if(data){
          $('#tran_color_id'+tran_outcome_id).val(data); 
          $('#save_success').show();
          $('#msg').html('Color changed from "'+color_name+'" to "'+change_color+'" for "'+outcomes+'"');
          $("#save_success").fadeTo(6000, 500).slideUp("slow", function() {
            $("#save_success").slideUp("slow");
          });

        }
           
       })          
       .fail(function (jqXHR, textStatus, errorThrown){
           alert("Record Not found.");
      });
}

function select_all_history_by_outcome_id(outcome_id){
//console.log(outcome_id);
  $.ajax({
       type: "POST",
       url: '<?php echo site_url;?>ptat_api/Api/select_all_history_by_outcome_id',
       data: { <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',outcome_id: outcome_id} ,
       async: false ,
       })
       .success(function (datalist, textStatus, xhr){  
          $("#history_id").empty();   
         if(datalist.length == 0){
             $("#history_id").append('<tr><td colspan="3" align="center">No record found. </td></tr>');
         }
                                
         for (j = 0; j < datalist.length; j++)
            {
              if(datalist[j]['start_date'] != null){
                var start_date1 =dt_convert(datalist[j]['start_date']);
              }else{
                var start_date1 ='';
              }

              if(datalist[j]['end_date'] != null){
                var end_date1 =dt_convert(datalist[j]['end_date']);
              }else{
                var end_date1 ='';
              }

              if(datalist[j]['add_by'] == null){
                var addby = '';
              } else{
                var addby = datalist[j]['add_by'];
              }

              $("#history_id").append("<tr><td align='left'>"+datalist[j]['name']+"</td><td align='left'>"+start_date1+"</td><td align='left'>"+end_date1+"</td><td align='left'>"+datalist[j]['note']+"</td><td align='left'>"+addby+"</td></tr>");
                      
            } 
       })          
       .fail(function (jqXHR, textStatus, errorThrown){
           alert("Record Not found.");
      });

}

function select_all_color_history_by_outcome_id(outcome_id){
//console.log(outcome_id);
  $.ajax({
       type: "POST",
       url: '<?php echo site_url;?>ptat_api/Api/select_all_color_history_by_outcome_id',
       data: { <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',outcome_id: outcome_id} ,
       async: false ,
       })
       .success(function (datalist, textStatus, xhr){
       $("#color_id").empty();  
         if(datalist.length == 0){
             $("#color_id").append('<tr><td colspan="3" align="center">No record found. </td></tr>');
         }
                                     
         for (j = 0; j < datalist.length; j++)
            {
              if(datalist[j]['start_date'] != null){
                var start_date1 =dt_convert(datalist[j]['start_date']);
              }else{
                var start_date1 ='';
              }

              if(datalist[j]['end_date'] != null){
                var end_date1 =dt_convert(datalist[j]['end_date']);
              }else{
                var end_date1 ='';
              }

              if(datalist[j]['add_by'] == null){
                var addby = '';
              } else{
                var addby = datalist[j]['add_by'];
              }

              if(datalist[j]['name']=='GREEN'){
                var oval_cl = 'oval_green';
              }else if(datalist[j]['name']=='RED'){
                 var oval_cl= 'oval_red';
              }else if(datalist[j]['name']=='YELLOW'){
                 var oval_cl = 'oval_yellow';
              }else if(datalist[j]['name']=='WHITE'){
                 var oval_cl = 'oval_white';
              }

              $("#color_id").append("<tr><td align='left'><div class='"+oval_cl+"''></div> </td><td align='left'>"+start_date1+"</td><td align='left'>"+end_date1+"</td><td align='left'>"+datalist[j]['note']+"</td><td align='left'>"+addby+"</td></tr>");
                      
            } 
       })          
       .fail(function (jqXHR, textStatus, errorThrown){
           alert("Record Not found.");
      });

}

function select_all_comment_by_outcome_id(outcome_id){
//console.log(outcome_id);
  $.ajax({
       type: "POST",
       url: '<?php echo site_url;?>ptat_api/Api/select_all_comment_by_outcome_id',
       data: { <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',outcome_id: outcome_id} ,
       async: false ,
       })
       .success(function (datalist, textStatus, xhr){  
       $("#comment_id").empty();  
         if(datalist.length == 0){
             $("#comment_id").append('<tr><td colspan="3" align="center">No record found. </td></tr>');
         }
                                     
         for (j = 0; j < datalist.length; j++)
            {
              if(datalist[j]['note']){

                if(datalist[j]['added_date'] != null){
                  var added_date =datetimeFormat(datalist[j]['added_date']);
                }else{
                  var added_date ='';
                }

                 if(datalist[j]['addBy'] == 0){
                    var addBy = '';
                  } else{
                    var addBy = datalist[j]['addBy'];
                  }    

                $("#comment_id").append("<tr><td align='left'>"+datalist[j]['note']+" </td><td align='left'>"+added_date+"</td><td align='left'>"+addBy+"</td></tr>");
                }       
                      
            } 
       })          
       .fail(function (jqXHR, textStatus, errorThrown){
           alert("Record Not found.");
      });

}

function getHistory(outcome_id,outcomes,business_impact,stage,level){
  //alert(outcome_id); 
    $("#myModal").modal('show');  
    $('#headertxt').html('<label style="text-transform: uppercase;"> '+outcomes +'-BO:'+ business_impact +'/STAGE:'+ stage +'/LEVEL:'+level +'</level>');   // dismiss the dialog
   select_all_history_by_outcome_id(outcome_id);
   select_all_color_history_by_outcome_id(outcome_id);
   select_all_comment_by_outcome_id(outcome_id);

}
 
</script>

</body>
</html>