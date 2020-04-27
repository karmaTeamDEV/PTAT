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
  .errorcls{
    border: 1px solid red !important;
    background-color: #fff6f6;
  } 
   
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


            <h3 class="text1">Manage Company</h3>
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#home" onclick="reset_all_field(1);">Manage Users</a></li>
              <li><a data-toggle="tab" href="#menu1" onclick="reset_all_field(2);">Manage Business Outcomes</a></li>
              <li><a data-toggle="tab" href="#menu2" onclick="reset_all_field(3);">Manage Levels</a></li>
              <li><a data-toggle="tab" href="#menu3" onclick="reset_all_field(4);">Manage Agile Outcomes</a></li> 

            </ul>

            <div class="tab-content">
              <div id="home" class="tab-pane fade in active">
                <div class="row">
                 <div class="col-sm-12 col-md-12">
                  <h3 class="text1"></h3>


                  <div class="alert alert-danger alert-dismissible fade in" style="display: none;" id="user_error_msg" >
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>                  
                  </div>


                  <?php 
                  $attributes = array( 'name' => 'addUpdateUser');        
                  echo form_open(site_url.'Dashboard/userList', $attributes);                     
                  ?>
                  <input type="hidden"  id="user_id" >

                  <div class="col-md-4 col-sm-4 input_field_sections">
                   <!--  <h5>First Name <span style="color: #cc0000">*</span></h5> -->
                   <input  type="text" class="form-control"  id="first_name"   placeholder="First Name" onkeyup="rmerrorcl('first_name');"  />
                 </div>
                 <div class="col-md-4 col-sm-4 input_field_sections">
                   <!--  <h5>Email <span style="color: #cc0000">*</span></h5> -->
                   <input  type="text" class="form-control"   id="email"    placeholder="Email" onkeyup="rmerrorcl('email');"  />
                 </div>
                 <div class="col-md-4 col-sm-4 input_field_sections">
                   <!--  <h5>Role <span style="color: #cc0000">*</span></h5> -->
                   <select class="form-control"   id="role" onchange="rmerrorcl('role');">
                    <option value="">Select Role</option>
                    <option value="admin" >Admin</option> 
                    <option value="trainer" >Trainer</option>     
                    <option value="analyst" >Analyst</option>                     
                  </select>
                </div>              

                <div class="col-md-4 col-sm-4 input_field_sections" style="margin-top: 7px;">
                 <!--  <h5>Last Name <span style="color: #cc0000">*</span></h5> -->
                 <input  type="text" class="form-control"  id="last_name" onkeyup="rmerrorcl('last_name');"  placeholder="Last Name" />
               </div> 

               <div class="col-md-4 col-sm-4 input_field_sections" style="margin-top: 7px;">
                <!-- <h5>Password <span style="color: #cc0000">*</span></h5> -->
                <input  type="password" class="form-control"  id="password" onkeyup="rmerrorcl('password');"     placeholder="Password" />
              </div>           

              <div class="col-md-4 col-sm-4 input_field_sections" style="margin-top: 7px;">
                <!-- <h5>Status <span style="color: #cc0000">*</span></h5> -->
                <select class="form-control"  id="user_status"  >
                 <option value="0" >Active</option>
                 <option value="1" >In-Active</option>
               </select>
             </div>

             <div style="clear:both;"></div></br>
              
             <div class="col-md-4 col-sm-4 input_field_sections" style="float: right;text-align: right;">
              <button type="reset" class="btn btn-primary" onclick="reset_userfield();" >Reset</button> 
              <button type="button" class="btn btn-primary" id="btn_add_update_user" onclick="add_update_user();" style="margin-right: 0px;">Save</button> 
            </div> 

          </form>

        </div> 
      </div>

      

        <div class="col-sm-12 col-md-12" id="mydiv" style="margin-top: 10px;">

          <table class="table  table-striped table-bordered table-hover dataTable no-footer" id="usertbl" role="grid">
            <thead>
              <tr role="row">
                <th></th>
                <th class="sorting_asc wid-20" tabindex="0" rowspan="1" colspan="1">Name</th>                      
                <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Email</th>
                <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Password</th>                
                <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Role</th>
                <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($all_userList))
              {
                foreach ($all_userList as $value)
                  { ?>
                    <tr>
                      <td ><a title="Edit" onclick="select_user_data('<?php echo $value['id']; ?>');" style="cursor: pointer;" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                      <td><?=$value['first_name'].' '.$value['last_name']?></td>
                      <td><?=$value['email']?></td>
                      <td><?=$value['password']?></td>                                           
                      <td><?=$value['role']?></td>                         
                      <td><?php if($value['status']==0){ echo 'Active';}else{ echo 'In-Active'; }?></td>
                    </tr> 
                    <?php 
                  }
                }?>
              </tbody>
            </table>
          </div>
         

      </div> <!-- Panel-1 end -->
      <div id="menu1" class="tab-pane fade">
        <div class="row">

          <div class="col-sm-12 col-md-12">
           <h3 class="text1"></h3>

           <div class="alert alert-danger alert-dismissible fade in" style="display: none;" id="biz_error_msg">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>               
          </div>           

          <?php 
          $attributes = array( 'name' => 'add_user');        
          echo form_open(site_url.'Dashboard/biz_impactList', $attributes);                     
          ?>
          <input type="hidden"  id="biz_id" >

          <div class="col-md-4 col-sm-4 input_field_sections">
           <!--  <h5>Business Impact <span style="color: #cc0000">*</span></h5> -->
           <input  type="text" class="form-control"  id="business_impact" onkeyup="rmerrorcl('business_impact');"   placeholder="Business Outcome" />
         </div>
         <div class="col-md-4 col-sm-4 input_field_sections">
           <!--  <h5>Measure <span style="color: #cc0000">*</span></h5> -->
           <input  type="text" class="form-control"  id="measure" onkeyup="rmerrorcl('measure');"   placeholder="Measure"  />
         </div>

         <div class="col-md-4 col-sm-4 input_field_sections">
           <!--  <h5>Ordering </h5> -->
           <select class="form-control"  id="biz_ordering" >
             <option value="0">Select Ordering</option>
             <?php for ($i=1; $i < 21; $i++) {  ?>
             <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>  
             <?php } ?> 
           </select>
         </div>

         <div class="col-md-8 col-sm-8 input_field_sections" style="margin-top: 7px;">
           <!--  <h5>Description <span style="color: #cc0000">*</span></h5> -->
           <textarea  type="text" class="form-control" id="biz_description" placeholder="Description"></textarea>
         </div>  

         <div class="col-md-4 col-sm-4 input_field_sections" style="margin-top: 7px;">
          <!--   <h5>Status <span style="color: #cc0000">*</span></h5> -->
          <select class="form-control"  id="biz_status" >
           <option value="0" >Active</option>
           <option value="1">In-Active</option>
         </select>
       </div>  


       <div style="clear:both;"></div></br>

       <div class="col-md-4 col-sm-4 input_field_sections" style="float: right;text-align: right;">
        <button type="reset" class="btn btn-primary" onclick="reset_bizfield();" >Reset</button> 
        <button type="button" class="btn btn-primary" id="btn_add_update_biz_impact" onclick="add_update_biz_impact();" style="margin-right: 0px;">Save</button>
      </div> 

    </div> 
  </div>

  

    <div class="col-sm-12 col-md-12" style="margin-top: 10px;">

      <table class="table  table-striped table-bordered table-hover dataTable no-footer" id="biztbl" role="grid">
        <thead>
          <tr role="row">
            <th></th>
            <th class="sorting_asc wid-20" tabindex="0" rowspan="1" colspan="1">Business Outcomes</th>
            <th class="sorting wid-25" tabindex="0" rowspan="1" colspan="1">Measure</th>                             
            <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Ordering</th> 
            <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Status</th>                  

          </tr>
        </thead>
        <tbody>
          <?php if(!empty($all_biz_impactList))
          {
            foreach ($all_biz_impactList as $value)
              { ?>
                <tr>

                  <td ><a title="Edit" onclick="select_biz_data('<?php echo $value['id']; ?>');" href="javascript:void();"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                  <td><?=$value['business_impact']?></td>
                  <td><?=$value['measure']?></td>             
                  <td><?=$value['ordering']?></td>                         
                  <td><?php if($value['status']==0){ echo 'Active';}else{ echo 'In-Active'; }?></td>

                </tr> 
                <?php 
              }
            }?>
          </tbody>
        </table>

      </div>
     

  </div> <!-- Panel-2 end -->
  <div id="menu2" class="tab-pane fade">
   <div class="row">

    <div class="col-sm-12 col-md-12">
      <h3 class="text1"></h3>


      <div class="alert alert-danger alert-dismissible fade in" style="display: none;" id="level_error_msg">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>           
      </div>


      <?php 
      $attributes = array( 'name' => 'add_user');        
      echo form_open(site_url.'Dashboard/company_levels', $attributes);                     
      ?>
      <input type="hidden" id="level_id" >

      <div class="col-md-4 col-sm-4 input_field_sections">
       <!--  <h5>Company Level <span style="color: #cc0000">*</span></h5> -->
       <input  type="text" class="form-control" id="level" placeholder="Level" onkeyup="rmerrorcl('level');"  />
     </div>

     <div class="col-md-4 col-sm-4 input_field_sections">
      <!-- <h5>Ordering </h5> -->
      <select class="form-control" id="level_ordering" >
        <option value="0">Select Ordering</option>
        <?php for ($i=1; $i < 21; $i++) {  ?>
             <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>  
             <?php } ?> 
      </select>
    </div>

    <div class="col-md-4 col-sm-4 input_field_sections">
      <!-- <h5>Status <span style="color: #cc0000">*</span></h5> -->
      <select class="form-control" id="level_status" >
       <option value="0"  >Active</option>
       <option value="1"  >In-Active</option>
     </select>
   </div>

   <div class="col-md-12 col-sm-12 input_field_sections" style="margin-top: 7px;">
    <!-- <h5>Description <span style="color: #cc0000">*</span></h5> -->
    <textarea required type="text" class="form-control" id="level_description" placeholder="Description"></textarea>
  </div>  

  <div style="clear:both;"></div></br>

  <div class="col-md-4 col-sm-4 input_field_sections" style="float: right;text-align: right;">
    <button type="reset" class="btn btn-primary" onclick="reset_levelfield();">Reset</button> 
    <button type="button" class="btn btn-primary" id="btn_add_update_company_level" onclick="add_update_company_level();" style="margin-right: 0px;">Save</button>
  </div> 

</div> 
</div>

 

  <div class="col-sm-12 col-md-12" style="margin-top: 10px;">

    <table class="table  table-striped table-bordered table-hover dataTable no-footer" id="leveltbl"
    role="grid">
    <thead>
      <tr role="row">
        <th></th>
        <th class="sorting_asc wid-20" tabindex="0" rowspan="1" colspan="1">Levels</th>
        <th class="sorting wid-25" tabindex="0" rowspan="1" colspan="1">Description</th>                           
        <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Ordering</th> 
        <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Status</th>                  

      </tr>
    </thead>
    <tbody>
      <?php if(!empty($all_company_level))
      {
        foreach ($all_company_level as $value)
          { ?>
            <tr>

              <td ><a title="Edit" onclick="select_company_level_data('<?php echo $value['id']; ?>');" href="javascript:void();"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
              <td><?=$value['level']?></td>
              <td><?=$value['description']?></td>  
              <td><?=$value['ordering']?></td>                         
              <td><?php if($value['status']==0){ echo 'Active';}else{ echo 'In-Active'; }?></td>

            </tr> 
            <?php 
          }
        }?>
      </tbody>
    </table>

  </div>
 

</div> <!-- Panel-3 end -->
<div id="menu3" class="tab-pane fade">
 <div class="row">

  <div class="col-sm-12 col-md-12">
   <h3 class="text1"></h3>


   <div class="alert alert-danger alert-dismissible fade in" style="display: none;" id="outcome_error_msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>     
  </div>
  

  <?php 
  $attributes = array( 'name' => 'add_user');        
  echo form_open(site_url.'Dashboard/manage_outcome', $attributes);                     
  ?>
  <input type="hidden" id="outcome_id">

  <div class="col-md-3 col-sm-3 input_field_sections">
    <!-- <h5>Business Impact <span style="color: #cc0000">*</span></h5> -->
    <select class="form-control" id="business_impact_id" onchange="rmerrorcl('business_impact_id');" >
      <option value="">Select Business Outcomes</option>
      <?php foreach ($biz_impact as $key => $impact) { ?>                    
        <option value="<?php echo $impact['id']; ?>"><?php echo $impact['business_impact']; ?></option>  
      <?php } ?>               
    </select>                
  </div> 
  <div class="col-md-3 col-sm-3 input_field_sections">
    <!-- <h5>Stage <span style="color: #cc0000">*</span></h5> -->
    <select class="form-control" id="stage_id" onchange="rmerrorcl('stage_id');">
      <option value="">Select Stage</option>
      <?php foreach ($all_stages as $key => $stages) { ?>                    
        <option value="<?php echo $stages['id']; ?>" ><?php echo $stages['stage']; ?></option>  
      <?php } ?>               
    </select>                
  </div> 
  <div class="col-md-3 col-sm-3 input_field_sections">
   <!--  <h5>Company Level <span style="color: #cc0000">*</span></h5> -->
   <select class="form-control" id="outcome_level_id" onchange="rmerrorcl('outcome_level_id');">
     <option value="">Select Level</option>
     <?php foreach ($company_level as $key => $level) { ?>                    
      <option value="<?php echo $level['id']; ?>" ><?php echo $level['level']; ?></option>  
    <?php } ?>               
  </select>                
</div> 



<div class="col-md-3 col-sm-3 input_field_sections">
 <!--  <h5>Start Date <span style="color: #cc0000">*</span></h5> -->
 <input type="text" class="form-control" id="start_date"  placeholder="Start Date"  onkeyup="rmerrorcl('start_date');"/>

 <input type="text" class="form-control" id="update_start_date" readonly  placeholder="Start Date" style="display: none;" />
</div> 

<div class="col-md-3 col-sm-3 input_field_sections" style="margin-top: 7px;">
 <!--  <h5>Outcome <span style="color: #cc0000">*</span></h5> -->
 <input  type="text" class="form-control" id="outcomes"   placeholder="Agile Outcome" onkeyup="rmerrorcl('outcomes');"/>
</div>

<div class="col-md-3 col-sm-3 input_field_sections" style="margin-top: 7px;">
 <!--  <h5>Outcome Status <span style="color: #cc0000">*</span></h5> --> 
 <input  type="text" class="form-control" id="update_outcome_status_id" readonly style="display: none;" placeholder="Outcome Status"  />

 <select class="form-control" id="outcome_status_id" onchange="rmerrorcl('outcome_status_id');">   
   <option value="">Select Outcome Status</option>
   <?php  foreach ($all_status as $key => $status1) { ?>                    
    <option value="<?php echo $status1['id']; ?>"   ><?php echo $status1['name']; ?></option>  
  <?php }  ?>
</select>
</div> 

<div class="col-md-3 col-sm-3 input_field_sections" style="margin-top: 7px;"> 
 <input  type="text" class="form-control" id="update_color_id" readonly style="display: none;" placeholder="Outcome Color" />

 <select class="form-control" id="color_id" onchange="rmerrorcl('color_id');">    
  <option value="">Select Outcome Color</option>
  <?php foreach ($all_color as $key => $color) { ?>                    
    <option value="<?php echo $color['id']; ?>"   ><?php echo $color['name']; ?></option>  
  <?php } ?>
</select>
</div> 

<div class="col-md-3 col-sm-3 input_field_sections" style="margin-top: 7px;"> 
 <select class="form-control" id="outcome_status" >
   <option value="0">Active</option>
   <option value="1">In-Active</option>
 </select>
</div> 

<div class="col-md-12 col-sm-12 input_field_sections" style="margin-top: 7px;">
 <!--  <h5>Description <span style="color: #cc0000">*</span></h5> -->
 <textarea  type="text" class="form-control" id="outcome_description" placeholder="Description"></textarea>
</div>  

<div style="clear:both;"></div></br>
<div class="col-md-4 col-sm-4 input_field_sections" style="float: right;text-align: right;">
  <button type="reset" class="btn btn-primary" onclick="reset_outcomefield();">Reset</button> 
  <button type="button" class="btn btn-primary" id="btn_add_update_outcome" onclick="add_update_outcome();" style="margin-right: 0px;">Save</button>
</div> 

</div> 
</div>

 

  <div class="col-sm-12 col-md-12" style="margin-top: 10px;">

    <table class="table  table-striped table-bordered table-hover dataTable no-footer" id="outcometbl" role="grid">
      <thead>
        <tr role="row">
          <th></th>
          <th class="sorting_asc wid-20" tabindex="0" rowspan="1" colspan="1">Agile Outcomes</th>
          <th class="sorting wid-25" tabindex="0" rowspan="1" colspan="1">Business Outcomes</th>   
          <th class="sorting wid-25" tabindex="0" rowspan="1" colspan="1">Stage</th> 
          <th class="sorting wid-25" tabindex="0" rowspan="1" colspan="1">Levels</th>               
          <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Start Date</th>
          <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Outcome Status</th>
          <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Color</th> 
          <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Status</th>                  

        </tr>
      </thead>
      <tbody>
        <?php if(!empty($all_impactList))
        {
          foreach ($all_impactList as $value)
            { ?>
              <tr>

                <td ><a title="Edit" style="cursor: pointer;" onclick="select_outcome_data('<?php echo $value['id']; ?>');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                <td><?=$value['outcomes']?></td>
                <td><?=$value['business_impact']?></td>                          
                <td><?=$value['stage']?></td> 
                <td><?=$value['level']?></td>                                         
                <td><?php if($value['start_date']){echo date('m/d/Y',strtotime($value['start_date']));}?></td>  
                <td><?=$value['name']?></td>
                <td><?=$value['color']?></td>           
                <td><?php if($value['status']==0){ echo 'Active';}else{ echo 'In-Active'; }?></td>

              </tr> 
              <?php 
            }
          } ?>
        </tbody>
      </table>

    </div>
  

</div> <!-- Panel-4 end -->

</div>



</div>
</div>
</div>
</div>
</div>
</div>
<!-- /page content -->
<?php include('include/footer.php'); ?>
<script type="text/javascript">

   
$(document).ready(function() {
   $('#usertbl').DataTable({
     "pageLength": 10
    });
   $('#biztbl').DataTable({
     "pageLength": 10
   }); 
   $('#leveltbl').DataTable({
     "pageLength": 10
   }); 
   $('#outcometbl').DataTable({
     "pageLength": 10
   });  
   $('#start_date').datetimepicker({
    format: 'MM/DD/YYYY',
    defaultDate: new Date()
  });

}); 
 

 function add_update_user(){ 
    
    var company_id = '<?php echo $company_id; ?>';
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var email = $('#email').val();    
    var password = $('#password').val();
    var role = $('#role').val();
    var user_status = $('#user_status').val();
    var user_id = $('#user_id').val();
    //alert(first_name.length);
    if(first_name.length == 0 && last_name.length == 0 && email.length == 0 && password.length == 0 && role.length == 0){      
        $('#first_name').addClass('errorcls');
        $('#first_name').focus();
        $('#last_name').addClass('errorcls');
        //$('#last_name').focus();
        $('#email').addClass('errorcls');
       // $('#email').focus();
        $('#password').addClass('errorcls');
       // $('#password').focus();
        $('#role').addClass('errorcls');
        //$('#role').focus();
        return false;
    }else{

        if(first_name.length == 0){      
          $('#first_name').addClass('errorcls');
          $('#first_name').focus();
          return false;
        }

        if(last_name.length == 0){      
          $('#last_name').addClass('errorcls');
          $('#last_name').focus();
          return false;
        }
        if(email.length == 0){      
          $('#email').addClass('errorcls');
          $('#email').focus();
          return false;
        }
        if(password.length == 0){      
          $('#password').addClass('errorcls');
          $('#password').focus();
          return false;
        }
        if(role.length == 0){      
          $('#role').addClass('errorcls');
          $('#role').focus();
          return false;
        }

    }
    
    $("#btn_add_update_user").attr("disabled", true);
    $.ajax({
     type: "POST",
     url: '<?php echo base_url();?>index.php/ptat_api/Api/add_update_user/',
     data: { company_id: company_id,first_name: first_name,last_name: last_name,email: email,password: password,role:role,status:user_status,user_id:user_id} ,
     async: false ,
   })
  .success(function (data, textStatus, xhr){ 
      $('#user_error_msg').html(data['user_error_msg']);
      $('#user_error_msg').show();
      setTimeout(function() { $("#user_error_msg").slideUp(1000); }, 3500);
      $('#first_name').val('');
      $('#last_name').val('');
      $('#email').val('');    
      $('#password').val('');
      $('#role').val('');
      $('#user_id').val('');
      $('#user_status').val('0');  
      $("#btn_add_update_user").attr("disabled", false); 
 
    ////////////////////Reload datatable start//////////////////////
     

    $("#usertbl").DataTable().clear();     
     for(var i = 0; i < data['list'].length+1; i++) {            
          $('#usertbl').dataTable().fnAddData( [
            '<a title="Edit" onclick="select_user_data('+data['list'][i]['id']+');" style="cursor: pointer;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>',                
            data['list'][i]['first_name']+" "+ data['list'][i]['last_name'] ,
            data['list'][i]['email'],
            data['list'][i]['password'],
            data['list'][i]['role'],
            data['list'][i]['user_status']
          ]);
      }
    
    ////////////////////Reload datatable end//////////////////////   
 
        
  })      
  .fail(function (jqXHR, textStatus, errorThrown){
   alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
 });  

}

function select_user_data(user_id){

    $('tr').click(function () {
      $('table tr').removeClass('bgr');
      $(this).addClass('bgr'); 
    });

    $( "#first_name").removeClass("errorcls");
    $( "#last_name").removeClass("errorcls");
    $( "#email").removeClass("errorcls");
    $( "#password").removeClass("errorcls");
    $( "#role").removeClass("errorcls");
 
     var company_id = '<?php echo $company_id; ?>';
     $.ajax({
       type: "POST",
       url: '<?php echo base_url();?>index.php/ptat_api/Api/get_user_id/',
       data: { company_id: company_id,user_id: user_id} ,
       async: false ,
     })
     .success(function (data, textStatus, xhr){ 

        $('#first_name').val(data[0].first_name);
        $('#last_name').val(data[0].last_name);
        $('#email').val(data[0].email);    
        $('#password').val(data[0].password);
        $('#role').val(data[0].role);
        $('#user_status').val(data[0].status);
        $('#user_id').val(user_id);
        $('html,body').animate({ scrollTop: $(".x_panel").offset().top},'slow');
    })      
     .fail(function (jqXHR, textStatus, errorThrown){
       alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
     });

}

function add_update_biz_impact(){

    var company_id = '<?php echo $company_id; ?>';
    var business_impact = $('#business_impact').val();
    var measure = $('#measure').val();
    var biz_ordering = $('#biz_ordering').val();    
    var biz_description = $('#biz_description').val();
    var biz_status = $('#biz_status').val();    
    var biz_id = $('#biz_id').val();

    if(business_impact.length == 0 && measure.length == 0){      
        $('#business_impact').addClass('errorcls');
        $('#business_impact').focus();
        $('#measure').addClass('errorcls');
        //$('#measure').focus();        
        return false;
    }else{

        if(business_impact.length == 0){      
          $('#business_impact').addClass('errorcls');
          $('#business_impact').focus();
          return false;
        }
        if(measure.length == 0){      
          $('#measure').addClass('errorcls');
          $('#measure').focus();
          return false;
        } 
    }

    $("#btn_add_update_biz_impact").attr("disabled", true);
    $.ajax({
     type: "POST",
     url: '<?php echo base_url();?>index.php/ptat_api/Api/add_update_biz_impact/',
     data: { company_id: company_id,business_impact: business_impact,measure: measure,ordering: biz_ordering,description: biz_description,status:biz_status,biz_id:biz_id} ,
     async: false ,
   })
  .success(function (data, textStatus, xhr){  
      $('#biz_error_msg').html(data['biz_error_msg']);
      $('#biz_error_msg').show();
      setTimeout(function() { $("#biz_error_msg").slideUp(1000); }, 3500);
      $('#business_impact').val('');
      $('#measure').val('');
      $('#biz_ordering').val(0);    
      $('#biz_description').val('');           
      $('#biz_status').val('0');
      $('#biz_id').val('');
      $("#btn_add_update_biz_impact").attr("disabled", false);

    ////////////////////Reload datatable start//////////////////////
     $("#biztbl").DataTable().clear();     
     for(var i = 0; i < data['list'].length+1; i++) {            
          $('#biztbl').dataTable().fnAddData( [
            '<a title="Edit" onclick="select_biz_data('+data['list'][i]['id']+');" style="cursor: pointer;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>',                
            data['list'][i]['business_impact'] ,
            data['list'][i]['measure'],            
            data['list'][i]['ordering'],
            data['list'][i]['biz_status']
          ]);
      }
    ////////////////////Reload datatable end//////////////////////
          
        })      
  .fail(function (jqXHR, textStatus, errorThrown){
   alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
 }); 

}

function select_biz_data(biz_id){

    $('tr').click(function () {
      $('table tr').removeClass('bgr');
      $(this).addClass('bgr'); 
    });
    $( "#business_impact").removeClass("errorcls");
    $( "#measure").removeClass("errorcls");
   var company_id = '<?php echo $company_id; ?>';
   $.ajax({
     type: "POST",
     url: '<?php echo base_url();?>index.php/ptat_api/Api/get_biz_id/',
     data: { company_id: company_id,biz_id: biz_id} ,
     async: false ,
   })
   .success(function (data, textStatus, xhr){ 
      $('#business_impact').val(data[0].business_impact);
      $('#measure').val(data[0].measure);
      $('#biz_ordering').val(data[0].ordering);    
      $('#biz_description').val(data[0].description);
      $('#role').val(data[0].role);
      $('#biz_status').val(data[0].status);
      $('#biz_id').val(biz_id);
      $('html,body').animate({ scrollTop: $(".x_panel").offset().top},'slow');
  })      
   .fail(function (jqXHR, textStatus, errorThrown){
     alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
   });

}

function add_update_company_level(){

    var company_id = '<?php echo $company_id; ?>';
    var level = $('#level').val();     
    var level_ordering = $('#level_ordering').val();    
    var level_description = $('#level_description').val();
    var level_status = $('#level_status').val();    
    var level_id = $('#level_id').val();

     if(level.length == 0){      
          $('#level').addClass('errorcls');
          $('#level').focus();
          return false;
     }
     $("#btn_add_update_company_level").attr("disabled", true);

    $.ajax({
     type: "POST",
     url: '<?php echo base_url();?>index.php/ptat_api/Api/add_update_company_level/',
     data: { company_id: company_id,level: level,ordering: level_ordering,description: level_description,status:level_status,level_id:level_id} ,
     async: false ,
   })
    .success(function (data, textStatus, xhr){   
          $('#level_error_msg').html(data['level_error_msg']);
          $('#level_error_msg').show();
          setTimeout(function() { $("#level_error_msg").slideUp(1000); }, 3500);
          $('#level').val('');            
          $('#level_ordering').val(0);    
          $('#level_description').val('');           
          $('#level_status').val('0');
          $('#level_id').val('');
          $("#btn_add_update_company_level").attr("disabled", false);

          ////////////////////Reload datatable start//////////////////////
          $("#leveltbl").DataTable().clear();     
           for(var i = 0; i < data['list'].length+1; i++) {            
                $('#leveltbl').dataTable().fnAddData( [
                  '<a title="Edit" onclick="select_company_level_data('+data['list'][i]['id']+');" style="cursor: pointer;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>',                
                  data['list'][i]['level'] ,
                  data['list'][i]['description'],                  
                  data['list'][i]['ordering'],
                  data['list'][i]['level_status']
                ]);
            }
          ////////////////////Reload datatable end//////////////////////       

        })      
  .fail(function (jqXHR, textStatus, errorThrown){
   alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
 }); 

} 

function select_company_level_data(level_id){

     $('tr').click(function () {
      $('table tr').removeClass('bgr');
      $(this).addClass('bgr'); 
    });

     $( "#level").removeClass("errorcls");
     var company_id = '<?php echo $company_id; ?>';
     $.ajax({
       type: "POST",
       url: '<?php echo base_url();?>index.php/ptat_api/Api/get_level_id/',
       data: { company_id: company_id,level_id: level_id} ,
       async: false ,
     })
     .success(function (data, textStatus, xhr){ 
        $('#level').val(data[0].level);         
        $('#level_ordering').val(data[0].ordering);    
        $('#level_description').val(data[0].description);        
        $('#level_status').val(data[0].status);
        $('#level_id').val(level_id);
        $('html,body').animate({ scrollTop: $(".x_panel").offset().top},'slow');
    })      
     .fail(function (jqXHR, textStatus, errorThrown){
       alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
     });

}

function add_update_outcome(){

      var company_id = '<?php echo $company_id; ?>';
      var business_impact_id = $('#business_impact_id').val();     
      var stage_id = $('#stage_id').val();  
      var outcome_description = $('#outcome_description').val(); 
      var outcome_status = $('#outcome_status').val(); 
      var outcome_level_id = $('#outcome_level_id').val();
      var start_date = $('#start_date').val();    
      var outcomes = $('#outcomes').val();
      var outcome_status_id = $('#outcome_status_id').val();
      var color_id = $('#color_id').val();
      var outcome_id = $('#outcome_id').val();

      if(business_impact_id.length == 0 && stage_id.length == 0 && outcome_level_id.length == 0 && outcomes.length == 0 && outcome_status_id.length == 0 && color_id.length == 0){   

        $('#business_impact_id').addClass('errorcls');
        $('#business_impact_id').focus();
        $('#stage_id').addClass('errorcls');         
        $('#outcome_level_id').addClass('errorcls');        
        $('#outcomes').addClass('errorcls');        
        $('#outcome_status_id').addClass('errorcls');  
        $('#color_id').addClass('errorcls');           
        return false;
    }else{

        if(business_impact_id.length == 0){      
          $('#business_impact_id').addClass('errorcls');
          $('#business_impact_id').focus();
          return false;
        }

        if(stage_id.length == 0){      
          $('#stage_id').addClass('errorcls');
          $('#stage_id').focus();
          return false;
        }
        if(outcome_level_id.length == 0){      
          $('#outcome_level_id').addClass('errorcls');
          $('#outcome_level_id').focus();
          return false;
        }
        if(outcomes.length == 0){      
          $('#outcomes').addClass('errorcls');
          $('#outcomes').focus();
          return false;
        }

        if(outcome_id == ''){
          if(color_id.length == 0){      
            $('#color_id').addClass('errorcls');
            $('#color_id').focus();
            return false;
          }
          if(outcome_status_id.length == 0){      
            $('#outcome_status_id').addClass('errorcls');
            $('#outcome_status_id').focus();
            return false;
          }
          if(start_date.length == 0){      
            $('#start_date').addClass('errorcls');
            $('#start_date').focus();
            return false;
          }
        }     

    }
      $("#btn_add_update_outcome").attr("disabled", true);
      $.ajax({
       type: "POST",
       url: '<?php echo base_url();?>index.php/ptat_api/Api/add_update_outcome/',
       data: { company_id: company_id,business_impact_id: business_impact_id,stage_id: stage_id,description: outcome_description,status:outcome_status,level_id:outcome_level_id,start_date:start_date,status_id:outcome_status_id,color_id:color_id,outcomes:outcomes,outcome_id:outcome_id} ,
       async: false ,
     })
      .success(function (data, textStatus, xhr){  
          $('#outcome_error_msg').html(data['outcome_error_msg']);
          $('#outcome_error_msg').show();
          setTimeout(function() { $("#outcome_error_msg").slideUp(1000); }, 3500);
           $('#outcome_status_id').show();
          $('#update_outcome_status_id').hide();
          $('#color_id').show();
          $('#update_color_id').hide();        
          $('#start_date').show();
          $('#update_start_date').hide();

          $('#business_impact_id').val('');            
          $('#stage_id').val('');    
          $('#outcome_description').val('');           
          $('#outcome_status').val('0');
          $('#outcome_level_id').val('');
          $('#outcomes').val('');
          $('#outcome_status_id').val('');
          $('#color_id').val('');   
          $('#outcome_id').val(''); 
          $("#btn_add_update_outcome").attr("disabled", false);            
           ////////////////////Reload datatable start//////////////////////
          $("#outcometbl").DataTable().clear();     
           for(var i = 0; i < data['list'].length+1; i++) {            
                $('#outcometbl').dataTable().fnAddData( [
                  '<a title="Edit" onclick="select_outcome_data('+data['list'][i]['id']+');" style="cursor: pointer;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>',                
                  data['list'][i]['outcomes'] ,
                  data['list'][i]['business_impact'],                  
                  data['list'][i]['stage'],
                  data['list'][i]['level'],
                  dt_convert(data['list'][i]['start_date']),
                  data['list'][i]['name'],
                  data['list'][i]['color'],
                  data['list'][i]['outcome_status']
                ]);
            }
          ////////////////////Reload datatable end//////////////////////
          
        })      
  .fail(function (jqXHR, textStatus, errorThrown){
   alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
 }); 


} 

function select_outcome_data(outcome_id){
    //alert(outcome_id);

      $('tr').click(function () {
        $('table tr').removeClass('bgr');
        $(this).addClass('bgr'); 
      });

      $( "#business_impact_id").removeClass("errorcls");
      $( "#stage_id").removeClass("errorcls");
      $( "#outcomes").removeClass("errorcls");
      $( "#outcome_level_id").removeClass("errorcls");
      $( "#outcome_status_id").removeClass("errorcls");
      $( "#color_id").removeClass("errorcls");
      $( "#start_date").removeClass("errorcls");

     var company_id = '<?php echo $company_id; ?>';
     $.ajax({
       type: "POST",
       url: '<?php echo base_url();?>index.php/ptat_api/Api/get_outcome_id/',
       data: { company_id: company_id,outcome_id: outcome_id} ,
       async: false ,
     })
     .success(function (data, textStatus, xhr){ 
        $('#business_impact_id').val(data[0].business_impact_id);         
        $('#stage_id').val(data[0].stage_id);    
        $('#outcome_description').val(data[0].description);        
        $('#outcome_status').val(data[0].status);
        $('#outcome_level_id').val(data[0].level_id);
        $('#outcomes').val(data[0].outcomes);
        $('#outcome_status_id').hide();
        $('#update_outcome_status_id').show();
        $('#update_outcome_status_id').val(data[0].name);
        $('#color_id').hide();
        $('#update_color_id').show();
        $('#update_color_id').val(data[0].color);
        $('#start_date').hide();
        $('#update_start_date').show();
        if(data[0].start_date){
          $('#update_start_date').val(dt_convert(data[0].start_date));
        }
        $('#outcome_id').val(outcome_id);
        $('html,body').animate({ scrollTop: $(".x_panel").offset().top},'slow');
    })      
     .fail(function (jqXHR, textStatus, errorThrown){
       alert("The following error occurred: "+jqXHR.status+",   "+textStatus+",   "+errorThrown+"");
     });

} 

function reset_all_field(tab){
    //alert(tab);
     $('table tr').removeClass('bgr');
    if(tab==1){
      $('#first_name').val('');
      $('#last_name').val('');
      $('#email').val('');    
      $('#password').val('');
      $('#role').val('');
      $('#user_status').val('0');  
      $('#user_id').val('');

    $( "#first_name").removeClass("errorcls");
    $( "#last_name").removeClass("errorcls");
    $( "#email").removeClass("errorcls");
    $( "#password").removeClass("errorcls");
    $( "#role").removeClass("errorcls");

    }else if(tab==2){
      $('#business_impact').val('');
      $('#measure').val('');
      $('#biz_ordering').val('0');    
      $('#biz_description').val('');           
      $('#biz_status').val('0');
      $('#biz_id').val('');

    $( "#business_impact").removeClass("errorcls");
    $( "#measure").removeClass("errorcls");

    }else if(tab==3){
      $('#level').val('');            
      $('#level_ordering').val('0');    
      $('#level_description').val('');           
      $('#level_status').val('0');
      $('#level_id').val('');

      $( "#level").removeClass("errorcls");

    }else if(tab==4){
      $('#business_impact_id').val('');            
      $('#stage_id').val('');    
      $('#outcome_description').val('');           
      $('#outcome_status').val('0');
      $('#outcome_level_id').val('');
      $('#outcomes').val('');
      $('#outcome_status_id').val('');
      $('#color_id').val('');
      $('#outcome_id').val('');

      $( "#business_impact_id").removeClass("errorcls");
      $( "#stage_id").removeClass("errorcls");
      $( "#outcome_status").removeClass("errorcls");
      $( "#outcome_level_id").removeClass("errorcls");
      $( "#outcome_status_id").removeClass("errorcls");
      $( "#outcomes").removeClass("errorcls");
      $( "#color_id").removeClass("errorcls");
      $( "#start_date").removeClass("errorcls");

      $('#outcome_status_id').show();
      $('#update_outcome_status_id').hide();
      $('#color_id').show();
      $('#update_color_id').hide();        
      $('#start_date').show();
      $('#update_start_date').hide();
       

    }
  }

function rmerrorcl(field){  

  if($("#"+field ).val() == ''){
    $( "#"+field ).addClass("errorcls");
  } else{
    $( "#"+field ).removeClass("errorcls");
  }      
}

function reset_userfield(){
    $( "#first_name").removeClass("errorcls");
    $( "#last_name").removeClass("errorcls");
    $( "#email").removeClass("errorcls");
    $( "#password").removeClass("errorcls");
    $( "#role").removeClass("errorcls");
    $( "#user_id").val("");
}
function reset_bizfield(){
    $( "#business_impact").removeClass("errorcls");
    $( "#measure").removeClass("errorcls");    
    $( "#biz_id").val("");
}
function reset_levelfield(){
    $( "#level").removeClass("errorcls");
    $( "#level_id").val("");
}
function reset_outcomefield(){
    $( "#business_impact_id").removeClass("errorcls");
    $( "#stage_id").removeClass("errorcls");
    $( "#outcomes").removeClass("errorcls");
    $( "#outcome_level_id").removeClass("errorcls");
    $( "#outcome_status_id").removeClass("errorcls");
    $( "#color_id").removeClass("errorcls");
    $( "#start_date").removeClass("errorcls");
    $( "#outcome_id").val("");    

    $('#outcome_status_id').show();
    $('#update_outcome_status_id').hide();
    $('#color_id').show();
    $('#update_color_id').hide();        
    $('#start_date').show();
    $('#update_start_date').hide();
}

</script>
</body>
</html>