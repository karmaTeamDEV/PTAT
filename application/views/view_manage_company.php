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

            <div class="col-md-12 col-sm-12">
              <h3 class="text1">Manage Company</h3>

                <?php if(isset($_SESSION['error_message'])){ ?>                 
                  <div class="alert alert-danger alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                  </div>
                <?php } ?>

              <?php 
               $attributes = array( 'name' => 'add_company');        
               echo form_open_multipart(site_url.'Dashboard/manage_company', $attributes);                     
              ?>
              <input type="hidden" name="company_id" value="<?php echo $company[0]['id'] ?>">

              <div class="col-sm-4 col-md-4 input_field_sections">
                 
                <input required type="text" class="form-control" name="company_name" value="<?php echo $company[0]['company_name'] ?>"  placeholder="Company Name"/>
              </div>
               <div class="col-sm-8 col-md-8  input_field_sections" >                 
                <input required type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $company[0]['address']; ?>"/>
              </div>

              <div class="col-md-4 col-sm-4 input_field_sections" style="margin-top: 7px;">                
               <textarea class="form-control" name="description" placeholder="Description"><?php echo $company[0]['description']; ?></textarea>
              </div>

               <div class="col-sm-4 col-md-4  input_field_sections" style="margin-top: 7px;">
                  <input  type="file" class="form-control" name="logo" placeholder="Company Logo" value="<?php echo $company[0]['logo']; ?>"/>
                  Image size should be (50 x 50) px
              </div> 

                <div class="col-sm-4 col-md-4 input_field_sections" style="margin-top: 7px;">                 
               <select class="form-control" name="status" required>
                 <option value="0" <?php if("0"==$company[0]['status']){ echo 'selected'; } ?>>Active</option>
                 <option value="1" <?php if("1"==$company[0]['status']){ echo 'selected'; } ?>>In-Active</option>
               </select>
              </div>  
              
 
              <div style="clear:both;"></div></br>
              <div class="col-sm-4 col-md-4 input_field_sections" style="float: right;text-align: right;">
                <button type="submit" class="btn btn-primary">Save</button>
              </div> 

            </form>

            </div> 
          </div>

        

            <div class="col-sm-12 col-md-12" style="margin-top: 10px;">

              <table class="table  table-striped table-bordered table-hover dataTable no-footer " id="companytbl"   role="grid">
                <thead>
                  <tr role="row">
                    <th></th>
                    <th class="sorting_asc wid-20" tabindex="0" rowspan="1" colspan="1">Company Name</th>                      
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Address</th>
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Logo</th>                    
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Description</th>
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Status</th>
                    

                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($allcompany))
                  {
                    foreach ($allcompany as $value)
                      { 
 

                        ?>
                        <tr>
                          <td ><a title="Edit" href="<?php echo site_url; ?>Dashboard/manage_company/<?php echo $value['id']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                          <td><?=$value['company_name']?></td>
                          <td><?php echo $value['address'] ;?></td>
                          <td> <?php if($value['logo']){ ?>
                             <img alt="Company Logo" width="50" height="50" src="<?php echo base_url(); ?>company_logo/<?php echo $value['logo']; ?>">
                          <?php }else{ ?>
                             <img alt="Company Logo" width="50" height="50" src="<?php echo base_url(); ?>design/build/images/testlogo.png">
                          <?php  } ?>
                           </td>  
                           <td><?php echo $value['description'];?></td>
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
<!-- /page content -->
<!-- footer content -->
<?php include('include/footer.php'); ?>
<!-- /footer content -->
<script type="text/javascript"> 
   $(document).ready(function() {
    $('#companytbl').DataTable({
       "pageLength": 10
       }); 
  }); 

</script>

</body>
</html>