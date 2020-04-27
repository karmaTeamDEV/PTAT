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
<!-- <style type="text/css">
  .verticaltext {
    transform: rotate(-90deg);
    transform-origin: right, top;
    -ms-transform: rotate(-90deg);
    -ms-transform-origin:right, top;
    -webkit-transform: rotate(-90deg);
    -webkit-transform-origin:right, top;

    position: absolute; bottom: 0%; left: 0%;
    color: #fff;
    background-color: red;
    padding: 10px;
}
</style> -->
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
              <h3 class="text1">Manage Business Impact</h3>

                <?php if(isset($_SESSION['error_message'])){ ?>                 
                  <div class="alert alert-danger alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                  </div>
                <?php } ?>

              <?php 
               $attributes = array( 'name' => 'add_user');        
               echo form_open(site_url.'Dashboard/biz_impactList', $attributes);                     
              ?>
              <input type="hidden" name="biz_id" value="<?php echo $biz_impactList[0]['id'] ?>">

              <div class="col-lg-8 input_field_sections">
                <h5>Business Impact <span style="color: #cc0000">*</span></h5>
                <input required type="text" class="form-control" name="business_impact" value="<?php echo $biz_impactList[0]['business_impact'] ?>"  />
              </div>
              
               <div class="col-lg-4 input_field_sections">
                <h5>Company <span style="color: #cc0000">*</span></h5>
                <select class="form-control" name="company_id" >
                  <?php foreach ($all_company as $key => $company) { ?>                    
                      <option value="<?php echo $company['id']; ?>"  <?php if($company['id']==$biz_impactList[0]['company_id']){
                        echo 'selected';
                      } ?>><?php echo $company['company_name']; ?></option>  
                 <?php } ?>               
               </select>
              </div>
               <div class="col-lg-8 input_field_sections">
                <h5>Measure <span style="color: #cc0000">*</span></h5>
                <input required type="text" class="form-control" name="measure" value="<?php echo $biz_impactList[0]['measure'] ?>"  />
              </div>
 
             
               <div class="col-lg-4 input_field_sections">
                <h5>Status <span style="color: #cc0000">*</span></h5>
               <select class="form-control" name="status" required>
                 <option value="0" <?php if("0"==$biz_impactList[0]['status']){ echo 'selected'; } ?>>Active</option>
                 <option value="1" <?php if("1"==$biz_impactList[0]['status']){ echo 'selected'; } ?>>In-Active</option>
               </select>
              </div>


               <div class="col-lg-8 input_field_sections">
                <h5>Description <span style="color: #cc0000">*</span></h5>
                <textarea required type="text" class="form-control" name="description"><?php echo $biz_impactList[0]['description'] ?></textarea>
              </div> 
                <div class="col-lg-4 input_field_sections">
                <h5>Ordering </h5>
               <select class="form-control" name="ordering" >
                 <option value="1" <?php if("1"==$biz_impactList[0]['ordering']){ echo 'selected'; } ?>>1</option>
                 <option value="2" <?php if("2"==$biz_impactList[0]['ordering']){ echo 'selected'; } ?>>2</option>
                 <option value="3" <?php if("3"==$biz_impactList[0]['ordering']){ echo 'selected'; } ?>>3</option>
                 <option value="4" <?php if("4"==$biz_impactList[0]['ordering']){ echo 'selected'; } ?>>4</option>
                 <option value="5" <?php if("5"==$biz_impactList[0]['ordering']){ echo 'selected'; } ?>>5</option>
                 <option value="6" <?php if("6"==$biz_impactList[0]['ordering']){ echo 'selected'; } ?>>6</option>
                 <option value="7" <?php if("7"==$biz_impactList[0]['ordering']){ echo 'selected'; } ?>>7</option>
                 <option value="8" <?php if("8"==$biz_impactList[0]['ordering']){ echo 'selected'; } ?>>8</option>
                 <option value="9" <?php if("9"==$biz_impactList[0]['ordering']){ echo 'selected'; } ?>>9</option>
                 <option value="10" <?php if("10"==$biz_impactList[0]['ordering']){ echo 'selected'; } ?>>10</option>
               </select>
              </div>
 
 
              <div style="clear:both;"></div></br>

              <div class="col-lg-4 input_field_sections" style="float: right;text-align: right;">
                <button type="submit" class="btn btn-primary">Save</button>
              </div> 

            </div> 
          </div>

          <div class="row" style="margin-top: 25px;">

            <div class="col-sm-12">

              <table class="table  table-striped table-bordered table-hover dataTable no-footer" id="tbl_user" role="grid">
                <thead>
                  <tr role="row">
                    <th></th>
                    <th class="sorting_asc wid-20" tabindex="0" rowspan="1" colspan="1">Business Impact</th>
                    <th class="sorting wid-25" tabindex="0" rowspan="1" colspan="1">Measure</th>   
                    <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Company</th>                    
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
                          
                          <td ><a title="Edit" href="<?php echo site_url; ?>Dashboard/biz_impactList/<?php echo $value['id']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                          <td><?=$value['business_impact']?></td>
                          <td><?=$value['measure']?></td>                          
                          <td><?=$value['company_name']?></td>                                              
                          <td><?=$value['ordering']?></td>                         
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
</body>
</html>