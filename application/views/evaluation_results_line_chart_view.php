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
              <h3 class="text1">Line Chart</h3>
            </div>
          </div>
          
 
  
  <div class="row" style="margin-top: 15px;">
  <div class="col-sm-12">
    <?php
    $attributes = array( 'name' => 'line_chart', 'id' => 'line_chart', 'role' => 'form');      
    echo form_open(base_url().'index.php/progress_report_chart/evaluation_results_line_chart', $attributes);
    ?>

  <!--<div class=" col-sm-2" >
<select id="level_id" name="level_id" class="form-control" onchange="$('#line_chart').submit();">
  <option value="">Select Level</option>
  <?php foreach($company_level as $level){?>
  <option <?php if($level_id==$level['id']){?> selected="selected" <?php }?> value="<?php echo $level['id'];?>" ><?php echo $level['level'];?></option>
<?php }?>
</select>
</div>-->
 </form>
  </div>
</div>
<input type="hidden" id="level_result">



<!-- 1st row--> 
<div class="row" style="margin-top: 15px;">
  <div class="col-sm-12"> 

 <div id="line_chart_div_id">
   
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
<?php //if($level_id){?>
 Highcharts.chart('line_chart_div_id', {
    chart: {
        type: 'line'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [<?php echo $level_str;?>]
    },
    yAxis: {
        title: {
            text: 'Score'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    credits: { enabled: false },

    series: [<?php echo $serise_str;?>]
});
<?php //}?>

</script>
</body>
</html>