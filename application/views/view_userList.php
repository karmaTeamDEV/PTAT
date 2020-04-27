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
              <h3 class="text1">Manage Users</h3>

                <?php if(isset($_SESSION['error_message'])){ ?>                 
                  <div class="alert alert-danger alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                  </div>
                <?php } ?>

              <?php 
               $attributes = array( 'name' => 'add_user');        
               echo form_open(site_url.'Dashboard/userList', $attributes);                     
              ?>
              <input type="hidden" name="user_id" value="<?php echo $user[0]['id'] ?>">

              <div class="col-lg-4 input_field_sections">
                <h5>First Name <span style="color: #cc0000">*</span></h5>
                <input required type="text" class="form-control" name="first_name" value="<?php echo $user[0]['first_name'] ?>"  />
              </div>
              <div class="col-lg-4 input_field_sections">
                <h5>Email <span style="color: #cc0000">*</span></h5>
                <input required type="text" class="form-control" name="email" value="<?php echo $user[0]['email']; ?>"/>
              </div>
               <div class="col-lg-4 input_field_sections">
                <h5>Company <span style="color: #cc0000">*</span></h5>
                <select class="form-control" name="company_id" required >
                  <?php foreach ($all_company as $key => $company) { ?>                    
                      <option value="<?php echo $company['id']; ?>" <?php if($company['id']==$user[0]['company_id']){
                        echo 'selected';
                      } ?>><?php echo $company['company_name']; ?></option>  
                 <?php } ?>               
               </select>
              </div>
               <div class="col-lg-4 input_field_sections">
                <h5>Last Name <span style="color: #cc0000">*</span></h5>
                <input required type="text" class="form-control" name="last_name" value="<?php echo $user[0]['last_name'] ?>"/>
              </div> 

              <div class="col-lg-4 input_field_sections">
                <h5>Password <span style="color: #cc0000">*</span></h5>
                <input required type="password" class="form-control" name="password"   value="<?php echo $user[0]['password']; ?>"/>
              </div>

               <div class="col-lg-4 input_field_sections">
                <h5>Role <span style="color: #cc0000">*</span></h5>
                <select class="form-control" name="role" required>
                 <option value="admin" <?php if("admin"==$user[0]['role']){ echo 'selected'; } ?>>Admin</option> 
                 <option value="trainer" <?php if("trainer"==$user[0]['role']){ echo 'selected'; } ?>>Trainer</option>     
                 <option value="Analyst" <?php if("Analyst"==$user[0]['role']){ echo 'selected'; } ?>>Analyst</option>                     
               </select>
              </div>
             
              <div class="col-lg-4 input_field_sections">
                <h5>Status <span style="color: #cc0000">*</span></h5>
               <select class="form-control" name="status" required>
                 <option value="0" <?php if("0"==$user[0]['status']){ echo 'selected'; } ?>>Active</option>
                 <option value="1" <?php if("1"==$user[0]['status']){ echo 'selected'; } ?>>In-Active</option>
               </select>
              </div>
 
              <div style="clear:both;"></div></br>
              <div class="col-lg-4 input_field_sections" style="float: right;text-align: right;">
                <button type="submit" class="btn btn-primary">Save</button>
              </div> 

            </form>

            </div> 
          </div>

          <div class="row" style="margin-top: 25px;">

            <div class="col-sm-12">

              <table class="table  table-striped table-bordered table-hover dataTable no-footer" id="tbl_user" role="grid">
                <thead>
                  <tr role="row">
                    <th></th>
                    <th class="sorting_asc wid-20" tabindex="0" rowspan="1" colspan="1">Name</th>                      
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Email</th>
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Password</th>
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Company</th>
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
                          <td ><a title="Edit" href="<?php echo site_url; ?>Dashboard/userList/<?php echo $value['id']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                          <td><?=$value['first_name'].' '.$value['last_name']?></td>
                          <td><?=$value['email']?></td>
                          <td><?=$value['password']?></td>
                          <td><?=$value['company_name']?></td>                          
                          <td><?=$value['role']?></td>                         
                          <td><?php if($value['status']==0){ echo 'Active';}else{ echo 'In-Active'; }?></td>

                        </tr> 
                        <?php 
                      }
                    }?>
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
  $('#birthday').datetimepicker({
    format: 'MM/DD/YYYY'
  });

   
</script>

</body>
</html>