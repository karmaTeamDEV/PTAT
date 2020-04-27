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
              <h3 class="text1">Login Logout History</h3> 

            </div> 
          </div>

          <div class="row" style="margin-top: 25px;">

            <div class="col-sm-12">

              <table class="table  table-striped table-bordered table-hover dataTable no-footer" id="tbl_user" role="grid">
                <thead>
                  <tr role="row">
                     
                    <th class="sorting_asc wid-20" tabindex="0" rowspan="1" colspan="1">Username</th>
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Company</th>
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">IP Address</th>
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">TimeZone</th>
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Login Time</th> 
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Logout Time</th>
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Duration</th>
                    

                  </tr>
                </thead>
                <tbody id="all_login_logout_history"><!-- 
                  <?php if(!empty($all_login_logout_history))
                  {
                    foreach ($all_login_logout_history as $value)
                      { ?>
                        <tr>
                          
                          <td><?=$value['username'];?></td>
                          <td><?=$value['company_name']?></td>
                          <td><?=$value['ip_address']?></td>
                          <td><?=$value['timezone']?></td>         
                          <td><?=$value['start_time']?></td>   
                          <td><?=$value['end_time']?></td>   
                          <td></td>                         
                          

                        </tr> 
                        <?php 
                      }
                    }?> -->
                  </tbody>
                </table>

              </div>
            </div>



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
 $('#tbl_user').DataTable({
     "pageLength": 50
 });

select_login_logout_history();
 function select_login_logout_history(){
//console.log(outcome_id);
  $.ajax({
       type: "POST",
       url: '<?php echo site_url;?>ptat_api/Api/select_all_login_logout_history',
       data: { <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'} ,
       async: false ,
       })
       .success(function (datalist, textStatus, xhr){  
       $("#all_login_logout_history").empty();  
         if(datalist.length == 0){
             $("#all_login_logout_history").append('<tr><td colspan="3" align="center">No record found. </td></tr>');
         }
                                     
         for (j = 0; j < datalist.length; j++)
            { 

              if(datalist[j]['start_time']){
                var start_time =  set_time_zone_print(datetimeFormat(datalist[j]['start_time']), 'UTC+05:30');
              }else{
                var start_time = '';
              }

              if(datalist[j]['end_time']){
                 var end_time = set_time_zone_print(datetimeFormat(datalist[j]['end_time']), 'UTC+05:30');
                 var timeDiff =timeDiffCalc(new Date(start_time), new Date(end_time));
                 
              }else{
                var end_time = '';
                 var timeDiff ='';
              } 

              $("#all_login_logout_history").append("<tr><td  >"+datalist[j]['username']+" </td><td  >"+datalist[j]['company_name']+" </td><td  >"+datalist[j]['ip_address']+" </td><td  >"+datalist[j]['timezone']+" </td><td  >"+start_time+" </td><td align='left'>"+end_time+"</td><td> "+timeDiff+"</td></tr>");
                }       
                      
            
       })          
       .fail(function (jqXHR, textStatus, errorThrown){
           alert("Record Not found.");
      });

}

   
</script>

</body>
</html>