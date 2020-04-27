<?php //print_r( $membership_by_month);?>
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
<style type="text/css">
  
</style>
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
            <div class="col-sm-12" >
               <?php if(empty($biz_impact)){  
                echo '<a style="float:right; margin-top: 6px;" class="btn btn-primary" href="'.base_url().'index.php/Dashboard/process_data">Process Data</a>' ; }?>
              <h3 class="text1"><?php echo $title; ?></h3>
              
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
            <div class="bot_space">
             

              <?php foreach ($biz_impact as $key => $biz) { 
                // if($biz['id'] == $business_impact_id){
                //   $class = 'btn_yellow';
                // }else{
                //   $class = 'btn_gray';
                // }
                ?>
                   
              <div id="biz_btn<?php echo $biz['id']; ?>" class="bot1 btn_gray" onclick="get_report_by_biz_impact('<?php echo $biz['id']; ?>');"><?php echo $biz['business_impact']; ?></div>
              <?php } ?>
            </div>
          </div>
          </div>

   <div id="load"></div>
    
<!-- Replace whole html part start-->  
<div id="result_div_id"></div>
<!-- Replace whole html part end-->  


<!--  bottom-->
<?php if(!empty($biz_impact)){ ?>

<div class="row" style="padding-top:20px;">
  <div class="col-sm-1"></div>
   <div class="col-sm-1" style="line-height: 34px;">AS OF</div>
  <div class="col-sm-1" onclick="date_icon_click(<?php echo $company_id;?>,'<?php echo $previous_next_next_month; ?>',<?php echo $business_impact_id?>,0,0,'<?php echo $colorView?>');">
   <div>
     <div class="circle" id="<?php echo $previous_next_next_month; ?>"></div>
     <div><?php echo date('n/j/y', strtotime($previous_next_next_month)); ?></div>
   </div>
 </div>
 <div class="col-sm-1" onclick="date_icon_click(<?php echo $company_id;?>,'<?php echo $previous_next_month; ?>',<?php echo $business_impact_id?>,0,0,'<?php echo $colorView?>');">
   <div class="circle" id="<?php echo $previous_next_month; ?>"></div>
   <div><?php echo date('n/j/y', strtotime($previous_next_month)); ?></div>
 </div>
 <div class="col-sm-1" onclick="date_icon_click(<?php echo $company_id;?>,'<?php echo $previous_month; ?>',<?php echo $business_impact_id?>,0,0,'<?php echo $colorView?>');">
   <div class="circle" id="<?php echo $previous_month; ?>"></div>
   <div><?php echo date('n/j/y', strtotime($previous_month)); ?></div>
 </div>
 <div class="col-sm-1" onclick="date_icon_click(<?php echo $company_id;?>,'<?php echo $current_month; ?>',<?php echo $business_impact_id?>,0,0,'<?php echo $colorView?>');">
   <div  class="circle current_cl" id="<?php echo $current_month; ?>"></div>
   <div><?php echo date('n/j/y', strtotime($current_month)); ?></div>
 </div>
 <div class="col-sm-4">
  <!-- <div class="pink_bot">
    &lt;&lt; Date of the most Current data is visible ("as of")*
  </div> --></div>
  <div class="col-sm-2">&nbsp;</div>
</div>

<div class="row">
  <div class="col-sm-1">&nbsp;</div>

  <?php foreach ($all_stages as $key => $stages) {
      if($stages['id'] ==1){
        $class = 'bor_red';
      }else{
        $class = '';
      }
   ?>
    <div class="col-sm-2" style="padding:4px;">

     <div class="lower_bottom <?php echo $stages['color']; ?> box_botton_border"   onclick="date_icon_click(<?php echo $company_id;?>,'','',0,'<?php echo $stages['id']; ?>','<?php echo $colorView?>');" id="stage_button_div_id<?php echo $stages['id']; ?>"><?php echo $stages['stage']; ?></div>

   </div>
 <?php } ?>

 
</div>

<?php } ?>

<input type="hidden" id="business_impact_id">
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
  //alert(1);
$( document ).ready(function() {
  // Handler for .ready() called.
  //alert(1);
  //  document.getElementById('contents').style.visibility="visible";
$('#load').show(); 
  date_icon_click(<?php echo $company_id;?>,'',<?php echo $business_impact_id?>,1,0,'<?php echo $colorView?>');
  //alert(2);
});
 
  function date_icon_click(company_id,date,business_impact_id,active_only,stage_id,colorView){
    

   if(date){
    $("#end_date").val(date);
    $('.circle').removeClass("current_cl");
    $('#'+date).addClass("current_cl");
   }
   if(business_impact_id){
          //var business_impact_id1=$("#business_impact_id").val();
          var business_impact_id_str=$("#business_impact_id").val();
          //alert(business_impact_id_str);
          var business_impact_array = business_impact_id_str.split(","); 
          var a = business_impact_array.indexOf(business_impact_id);

//console.log(business_impact_array);
          //alert(a);
          if(a>=0){
              business_impact_array = jQuery.grep(business_impact_array, function(value) {
                return value != business_impact_id;
              });
          }else{
              business_impact_array.push(business_impact_id);
          }
          business_impact_id_str=business_impact_array.toString();/**/
          business_impact_id_str=business_impact_id_str.replace(/^,/, '');//remove first charcter if comma
          $("#business_impact_id").val(business_impact_id_str);
   }
    date=$("#end_date").val();
    business_impact_id=$("#business_impact_id").val();
    //business_impact_id_str1=$("#business_impact_id").val();
    business_impact_array=business_impact_id.split(",");
    //alert(business_impact_array);
    $('.bot1').removeClass("btn_yellow");
    for (i = 0; i < business_impact_array.length; ++i) {
      //console.log('biz_btn'+business_impact_array[i]);
       $('#biz_btn'+business_impact_array[i]).addClass("btn_yellow");     
    }


   if(stage_id){
      var stage_id_str=$("#stage_id").val();
      var stage_id_array = stage_id_str.split(","); 
      var b = stage_id_array.indexOf(stage_id);
      if(b>=0){
          stage_id_array = jQuery.grep(stage_id_array, function(value) {
            return value != stage_id;
          });
      }else{
          stage_id_array.push(stage_id);
      }
      stage_id_str1=stage_id_array.toString();/**/
     // alert(stage_id);
      stage_id_str1=stage_id_str1.replace(/^,/, '');//remove first charcter if comma
      $("#stage_id").val(stage_id_str1);
       // alert(stage_id_array.length);
        stage_id_array=stage_id_str1.split(",");

     $('.lower_bottom').removeClass("box_botton_border");
    for (i = 0; i < stage_id_array.length; ++i) {
       $('#stage_button_div_id'+stage_id_array[i]).addClass("box_botton_border");     
    }
   }

    stage_id=$("#stage_id").val();
    //alert(stage_id);

   $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>index.php/ptat_api/ProgressReport/get_progress_report/',
           data: { company_id: company_id,date: date,business_impact_id: business_impact_id,active_only: active_only,stage_id: stage_id,colorView:colorView} ,
           async: false ,
           })
           .success(function (data, textStatus, xhr){
           // $("#result_div_id").html("");
            $("#result_div_id").html(data);
            // alert("11"+data['maxid']);
            //}
            $('#load').hide(); 
           })      
           .fail(function (jqXHR, textStatus, errorThrown){
             alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
             
         });  
  }
  function get_report_by_biz_impact(biz_impact_id){
    //alert(biz_impact_id);
    //$('.bot1').removeClass("btn_gray");
    //$('#biz_btn'+biz_impact_id).addClass("btn_gray");
    date_icon_click(<?php echo $company_id;?>,'',biz_impact_id,1,0,'<?php echo $colorView?>');
  }

function change_status(tran_outcome_id){
  //alert(1);
    var tran_status_id = $('#tran_status_id'+tran_outcome_id).val();
    var status_id = $('#status_id'+tran_outcome_id).val();
    var note = $('#note'+tran_outcome_id).val();
    var previour_status_id = $('#previour_status_id'+tran_outcome_id).val();
    var start_date = $('#date'+tran_outcome_id).val();
    var previous_startdate = $('#previous_startdate'+tran_outcome_id).val();
 //alert(previous_startdate);
//   alert(tran_status_id);
//   alert(status_id);
// //   alert(note);
//    alert(previour_status_id);

    if(status_id == previour_status_id){
      $("#success-alert"+tran_outcome_id).fadeTo(3000, 500).slideUp(500, function() {
        $("#success-alert"+tran_outcome_id).slideUp(500);
      });
      //alert(' Current status and selected status are same.choose different status.');     
      return false;
    } 


    if(status_id == ''){
       $("#status_alert"+tran_outcome_id).fadeTo(3000, 500).slideUp(500, function() {
        $("#status_alert"+tran_outcome_id).slideUp(500);
      });
       return false;
    }
  

      $.ajax({
       type: "POST",
       url: '<?php echo site_url;?>ptat_api/Api/change_status',
       data: { <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',tran_outcome_id: tran_outcome_id,tran_status_id:tran_status_id,status_id:status_id,note:note,previour_status_id:previour_status_id,start_date:start_date,previous_startdate:previous_startdate} ,
       async: false ,
       })
       .success(function (data, textStatus, xhr){  
       // alert(data);

          if(data){
            $('.popuptext').removeClass("show");
            $('#exampleModalLong'+tran_outcome_id).modal('hide');            
            //$("#myDiv").load(location.href + " #myDiv");
            $("div").removeClass("modal-backdrop");
            date_icon_click(<?php echo $company_id;?>,'','',1,0,'<?php echo $colorView?>');
          }
       })          
       .fail(function (jqXHR, textStatus, errorThrown){
           alert("Member Details Not found.");
      });
}

function add_comment(outcome_id,tran_status_id){
  //alert(outcome_id+','+tran_status_id);
var comment = $('#comment'+outcome_id).val();
  $.ajax({
       type: "POST",
       url: '<?php echo site_url;?>ptat_api/Api/add_comment',
       data: { <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',outcome_id: outcome_id,tran_status_id:tran_status_id,comment:comment} ,
       async: false ,
       })
       .success(function (data, textStatus, xhr){  
        //console.log(data);

          if(data){
            $('.popuptext').removeClass("show");
            $("#comment_list"+outcome_id).empty();

             
            for (i = 0; i < data.length; i++)
            {
              if(data[i]['note']){
                 //var format_date = datetimeFormat(data[i]['added_date']);
                 var format_date = set_time_zone_print(datetimeFormat(data[i]['added_date']), 'UTC+05:30');               
                 $("#comment_list"+outcome_id).append("<tr><td>"+data[i]['note']+"</td><td>"+format_date+"</td><td>"+data[i]['addBy']+"</td></tr>");
              }             
            }

            $('#comment'+outcome_id).val('');
            //$('#exampleModalLong'+outcome_id).modal('hide');            
            //$("#myDiv").load(location.href + " #myDiv");
            //$("div").removeClass("modal-backdrop");
            //date_icon_click(<?php echo $company_id;?>,'','',1);
          }
       })          
       .fail(function (jqXHR, textStatus, errorThrown){
           alert("Member Details Not found.");
      });
}




function change_color(tran_outcome_id){
  //alert(1);
    var tran_color_id = $('#tran_color_id'+tran_outcome_id).val();    
    var previour_color_id = $('#previour_color_id'+tran_outcome_id).val();
    var color_id = $('#color_id'+tran_outcome_id).val();
    var color_date = $('#color_date'+tran_outcome_id).val();
    var color_note = $('#color_note'+tran_outcome_id).val();
    var previous_colordate = $('#previous_colordate'+tran_outcome_id).val();
 //alert(previous_colordate);

     if(color_id == previour_color_id){
      $("#success-alertt"+tran_outcome_id).fadeTo(3000, 500).slideUp(500, function() {
        $("#success-alertt"+tran_outcome_id).slideUp(500);
      });
      //alert(' Current status and selected status are same.choose different status.');     
      return false;
    } 

     if(color_id == ''){
       $("#color_alert"+tran_outcome_id).fadeTo(3000, 500).slideUp(500, function() {
        $("#color_alert"+tran_outcome_id).slideUp(500);
      });
       return false;
    }
  
  

      $.ajax({
       type: "POST",
       url: '<?php echo site_url;?>ptat_api/Api/change_color',
       data: { <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',tran_outcome_id: tran_outcome_id,tran_color_id:tran_color_id,color_id:color_id,color_date:color_date,color_note:color_note,previous_colordate:previous_colordate} ,
       async: false ,
       })
       .success(function (data, textStatus, xhr){  
       // alert(data);

          if(data){
            $('.popuptext').removeClass("show");
            $('#exampleModalLong'+tran_outcome_id).modal('hide');            
            //$("#myDiv").load(location.href + " #myDiv");
            $("div").removeClass("modal-backdrop");
            date_icon_click(<?php echo $company_id;?>,'','',1,0,'<?php echo $colorView?>');
          }
       })          
       .fail(function (jqXHR, textStatus, errorThrown){
           alert("Member Details Not found.");
      });
}


function get_score(cur_percentage,id,std_weight){
    //alert(cur_percentage+','+id+','+std_weight);
    var score = Math.round(cur_percentage*std_weight/100);
   // alert(score);
    $.ajax({
       type: "POST",
       url: '<?php echo site_url;?>ptat_api/Api/calculate_score',
       data: { <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',id: id,score:score,cur_percentage:cur_percentage} ,
       async: false ,
       })
       .success(function (data, textStatus, xhr){  
        // alert(data);
         $('#score'+id).html(score+'%');
       })          
       .fail(function (jqXHR, textStatus, errorThrown){
           alert("Record not found.");
      });
    
}


</script>
</body>
</html>