<?php //print_r( $membership_by_month);
$total_edit_flag=1;
//echo "<pre>";print_r( $_SESSION);
if($_SESSION['role']=="analyst"){
$total_edit_flag=0;

}
?>
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
              <h3 class="text1">Manage Score</h3>
            </div>
          </div>
          
 
  
  <div class="row" style="margin-top: 15px;">
  <div class=" col-lg-12 col-md-12 col-sm-12">
 
  <div class=" col-lg-2 col-md-4  col-sm-4" >
<select id="level_id" name="level_id" class="form-control" onchange="level_change(<?php echo $company_id?>,<?php echo $total_edit_flag?>);">
  <option value="">Select Level</option>
  <?php foreach($company_level as $level){?>
  <option value="<?php echo $level['id'];?>"><?php echo $level['level'];?></option>
<?php }?>
</select>
</div>
 <div class=" col-lg-2 col-md-4  col-sm-4" >
        <input type="text" class="form-control " id="data_date"  placeholder="Date" onblur="level_change(<?php echo $company_id?>,<?php echo $total_edit_flag?>);" />

</div>
<div class=" col-lg-2 col-md-4  col-sm-4"  id="save_data_button_id" style="display: none;">
       <button type="button" class="btn btn-primary" onclick="save_data(<?php echo $company_id?>);">Save </button>

</div>
<div class=" col-lg-4 col-md-4  col-sm-4" >
<div class="alert alert-success" id="save_success" style="display: none;">
                                   <button type="button" class="close" data-dismiss="alert">x</button>
                                   <strong>Message! </strong> Saved Successfully.
                                   </div>
</div>
</div>
<input type="hidden" id="level_result">



<!-- 1st row--> 

  <div class="col-sm-12 col-md-12" style="margin-top: 15px;"> 

    <table class="table  table-striped table-bordered table-hover dataTable no-footer" id="level_score_table_id" role="grid">
      <thead>
    <tr>
      <td width="20%" align="center"><h4>Agile Outcomes</h4></td>
      <td width="20%" align="center"><h4>Total</h4></td>
      <td width="20%" align="center"><h4>Score</h4></td>
      <td width="20%" align="center"><h4>Comment</h4></td>
      <td width="20%" align="center"><h4>%</h4></td>
    </tr>
  </thead>
    <tbody id="level_score_table_body_id">

   <!-- <tr>
     <td><div class="blue_botton blue2">
       <div class="blue_botton_text">    
       <div class="popup" data-toggle="modal" data-target="#exampleModalLong12" onclick="myFunction('12')" style="width:150px;">
       Agile Leadership
       </div>
       </div>
       </div></td> 
        <td><input type="text" class="form-control " name="total"></td>
        <td><input type="text" class="form-control " name="score"></td>
        <td style="text-align:center"><span id="present"></span></td>
      </tr>-->
      </tbody>
  </table>
 
 </div>
 

<!--  bottom-->




<input type="hidden" id="end_date">
<input type="hidden" id="stage_id">
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
<script type="text/javascript">

function level_change(company_id,total_edit_flag){
 // alert(total_edit_flag);
  var level_id=$("#level_id").val();
  var data_date=$("#data_date").val();
//$("#level_score_table_body_id").empty();
//$("#level_score_table_id").DataTable().clear(); 
$('#level_score_table_id').dataTable().fnClearTable();
$('#level_score_table_id').dataTable().fnDraw();
$('#level_score_table_id').dataTable().fnDestroy();
$('#level_score_table_id').dataTable();
//$('#level_score_table_id').dataTable().destroy();
//$('#level_score_table_id tbody').empty();
$("#save_data_button_id").hide();
if(level_id){
  var outcome_id_array="";
   // alert(33);
$.ajax({
           type: "POST",
           url: '<?php echo base_url();?>index.php/ptat_api/dashboard_api/get_level_data_for_spider/',
           data: { company_id: company_id,level_id: level_id,data_date: data_date } ,
           async: false ,
           })
           .success(function (data, textStatus, xhr){
            //$("#result_div_id").html(data);
            // alert("11"+data['maxid']);
            //}
            //alert(1);
            $("#level_score_table_id").DataTable().clear(); 
            //alert(2);

            for (i = 0; i < data.length; i++){
              var total=data[i].total;
              var score=data[i].score;
              var comment=data[i].comment;
              var score_persent="";
              var total_readonly_str="";
              var score_readonly_str="";
              if(total==null)
                total="";
              if(score==null)
                score="";
              if(comment==null)
                comment="";
              if(score>0){

                 score_persent=Math.round(score/total*100);
              }
              if(total_edit_flag){
                total_readonly_str=' readonly="" ';
                if(total==""){
                score_readonly_str=' readonly="" ';

                }
              }
  var table_body_str='<tr><td align="center"><div class="blue_botton blue2" style="width:150px;"><div class="blue_botton_text">    <div class="popup" data-toggle="modal" data-target="#exampleModalLong12" >'+data[i].outcomes+'       </div>       </div>       </div></td>         <td><input type="text" class="form-control " '+total_readonly_str+' name="total_'+data[i].id+'" id="total_'+data[i].id+'" value="'+total+'"></td>        <td><input type="text" class="form-control " name="score_'+data[i].id+'" id="score_'+data[i].id+'" onchange="score_value_change('+data[i].id+');"  value="'+score+'" '+score_readonly_str+'></td>        <td align="center"><textarea id="comment_'+data[i].id+'"  name="comment_'+data[i].id+'" >'+comment+'</textarea></td> <td align="center"><span  text-alert="center" id="present_'+data[i].id+'"> '+score_persent+'</span></td>      </tr>';
            //outcome_id_array.push(data[i].id);
outcome_id_array+=data[i].id+",";

$('#level_score_table_id').dataTable().fnAddData( [
                  '<div class="blue_botton blue2" style="width:150px;"><div class="blue_botton_text">    <div class="popup" data-toggle="modal" data-target="#exampleModalLong12" >'+data[i].outcomes+'       </div>       </div>       </div>',                
                  '<input type="text" class="form-control " '+total_readonly_str+' name="total_'+data[i].id+'" id="total_'+data[i].id+'" value="'+total+'">' ,
                  '<input type="text" class="form-control " name="score_'+data[i].id+'" id="score_'+data[i].id+'" onchange="score_value_change('+data[i].id+');"  value="'+score+'" '+score_readonly_str+'>',                  
                  '<textarea id="comment_'+data[i].id+'"  name="comment_'+data[i].id+'" >'+comment+'</textarea>',
                  '<span  text-alert="center" id="present_'+data[i].id+'"> '+score_persent+'</span>'
                ]);
        //$("#level_score_table_body_id").append(table_body_str);
      }
                  //alert(3);
      if(i>0){
        $("#save_data_button_id").show();
      }

      outcome_id_array = outcome_id_array.replace(/,\s*$/, "");
      $("#level_result").val(outcome_id_array);

      //alert(outcome_id_array);
  var table_body_str='<tr><td></td>         <td><button type="button" class="btn btn-primary" onclick="save_data(<?php echo $company_id?>);">Save </button></td>        <td></td>        <td></td>      </tr>';
  //alert(2);
       // $("#level_score_table_body_id").append(table_body_str);
        //alert(1);
        //$('#level_score_table_id').DataTable();
//alert(2);
           })      
           .fail(function (jqXHR, textStatus, errorThrown){
            // alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
                        $("#level_score_table_id").DataTable().clear(); 
 
         }); 

}

}
$(document).ready(function() {
   $('#level_score_table_id').DataTable({
     "pageLength": 50
    });
   

}); 
function save_data(company_id){
  var level_outcoms=$("#level_result").val();
  var data_date=$("#data_date").val();
  //alert(level_outcoms);
      level_outcoms_array=level_outcoms.split(",");
  //alert(level_outcoms_array.length);


      for (i = 0; i < level_outcoms_array.length; i++){
        var outcome_id=level_outcoms_array[i];
        var total=$("#total_"+outcome_id).val();
        var score=$("#score_"+outcome_id).val();
        var comment=$("#comment_"+outcome_id).val();
       // alert(outcome_id);
    $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>index.php/ptat_api/dashboard_api/insert_update_level_data_for_spider/',
           data: { company_id: company_id,data_date: data_date,outcome_id: outcome_id,total: total,score: score,comment: comment } ,
           async: false ,
           })
           .success(function (data, textStatus, xhr){

           })      
           .fail(function (jqXHR, textStatus, errorThrown){
             alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
             
         }); 
      }
        $("#save_success").fadeTo(3000, 500).slideUp(500, function() {
        $("#save_success").slideUp(500);
      });

}
function score_value_change(outcomes_id){
    //alert(outcomes_id);
    var total_val=parseInt($("#total_"+outcomes_id).val());
    var score_val=parseInt($("#score_"+outcomes_id).val());
    if(total_val==''){
      alert("Please enter total value.")
    }else if(total_val<score_val){
      alert("Score not grater then total.")
            $("#score_"+outcomes_id).val('');

      $("#score_"+outcomes_id).focus();

    }else if(score_val!=''){
      var present=Math.round(score_val/total_val*100);
      $("#present_"+outcomes_id).text(present+'%');

    }
//alert(total_val);
//alert(score_val);
}
$("#data_date").datetimepicker({
        format: "MM/DD/YYYY",
        defaultDate: new Date()
      })
//$('#level_score_table_id').DataTable();
</script>
</body>
</html>