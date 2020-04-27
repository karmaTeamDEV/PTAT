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
            <div class="col-sm-12">
              <h3 class="text1">Spider Chart</h3>
            </div>
          </div>
          
 
  
  <div class="row" style="margin-top: 15px;">
  <div class="col-sm-12">
    <?php
    $attributes = array( 'name' => 'spider_chart', 'id' => 'spider_chart', 'role' => 'form');      
    echo form_open(base_url().'index.php/progress_report_chart/spider_chart', $attributes);
    ?>

  <div class=" col-sm-2" >
<select id="level_id" name="level_id" class="form-control" onchange="$('#spider_chart').submit();">
  <option value="">Select Level</option>
  <?php foreach($company_level as $level){?>
  <option <?php if($level_id==$level['id']){?> selected="selected" <?php }?> value="<?php echo $level['id'];?>" ><?php echo $level['level'];?></option>
<?php }?>
</select>
</div>
 </form>
  </div>
</div>
<input type="hidden" id="level_result">



<!-- 1st row--> 
<div class="row" style="margin-top: 15px;">
  <div class="col-sm-12"> 

 <div id="spider_chart_div_id">
   
 </div>
 
 </div>
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
<?php if($level_id){?>
  Highcharts.chart('spider_chart_div_id', {
    chart: {
        polar: true,
        type: 'line'
    },
    accessibility: {
        description: ''
    },
    title: {
        text: '',
        x: -80
    },
    pane: {
        size: '80%'
    },
    xAxis: {
        categories: [<?php echo $level_name;?>],
        tickmarkPlacement: 'on',
        lineWidth: 0
    },

    yAxis: {
        gridLineInterpolation: 'polygon',
        lineWidth: 0,
        min: 0
    },

    tooltip: {
        shared: true,
        pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.0f}</b><br/>'
    },

    /*legend: {
        align: 'right',
        verticalAlign: 'middle',
        layout: 'vertical'
    },*/

    series: [<?php echo $serise_str?>],

credits: { enabled: false },
    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    align: 'center',
                    verticalAlign: 'top',
                    layout: 'horizontal'
                },
                pane: {
                    size: '70%'
                }
            }
        }]
    }

});
<?php }?>
function level_change(company_id){
  //alert(level_id);
  var level_id=$("#level_id").val();
  var data_date=$("#data_date").val();
//$("#level_score_table_body_id").empty();
if(level_id){
$.ajax({
           type: "POST",
           url: '<?php echo base_url();?>index.php/ptat_api/dashboard_api/get_process_report_result/',
           data: { company_id: company_id,date: date,business_impact_id: business_impact_id,active_only: active_only,stage_id: stage_id } ,
           async: false ,
           })
           .success(function (data, textStatus, xhr){
           // $("#result_div_id").html("");
            $("#result_div_id").html(data);
            // alert("11"+data['maxid']);
            //}
           })      
           .fail(function (jqXHR, textStatus, errorThrown){
             alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
             
         });  



}

}
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
       // alert(outcome_id);
    $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>index.php/ptat_api/dashboard_api/insert_update_level_data_for_spider/',
           data: { company_id: company_id,data_date: data_date,outcome_id: outcome_id,total: total,score: score } ,
           async: false ,
           })
           .success(function (data, textStatus, xhr){

           })      
           .fail(function (jqXHR, textStatus, errorThrown){
             alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
             
         }); 
      }
}
function score_value_change(outcomes_id){
    //alert(outcomes_id);
    var total_val=$("#total_"+outcomes_id).val();
    var score_val=$("#score_"+outcomes_id).val();
    if(total_val==''){
      alert("Please enter total value.")
    }else if(total_val<score_val){
      alert("Score not grater then total.")
            $("#score_"+outcomes_id).val('');

      $("#score_"+outcomes_id).focus();

    }else if(score_val!=''){
      var present=score_val/total_val*100;
      $("#present_"+outcomes_id).text(present+'%');

    }
//alert(total_val);
//alert(score_val);
}
$("#data_date").datetimepicker({
        format: "MM/DD/YYYY",
        defaultDate: new Date()
      })
</script>
</body>
</html>