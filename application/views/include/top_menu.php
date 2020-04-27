
<div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle" style="width: 30%;">
               <span style="float: left;"> <a id="menu_toggle"><i style="color: #000;" class="fa fa-bars"></i></a>
                <?php if($_SESSION['company_logo']){ ?>
                  <img height="45" src="<?php echo base_path;?>company_logo/<?php echo $_SESSION['company_logo']; ?>" style="    margin-top: -12px;">
                <?php }else{ ?>
                  <img width="50" height="50" src="<?php echo base_path;?>design/build/images/testlogo.png" style="margin-top: -12px;">
                <?php } ?>
                
              </span>
                
              </div>


              <ul class="nav navbar-nav navbar-right">

                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION['Name']; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo site_url;?>member/logout/"><i class="fa fa-sign-out pull-right"></i> Logout</a></li>
                  </ul>
                </li>
                <!-- <li class="">
                <img src="<?php echo base_path;?>design/build/images/<?php echo $_SESSION['company_logo']; ?>">
                </li> -->

                <?php if($_SESSION['role']== 'analyst') { 
                  $attributes = array( 'id' => 'upload_company_id');        
                      echo form_open_multipart(site_url.'Dashboard/upload_company_id', $attributes);
                      ?>
                      <input type="hidden" name="path_info" value="<?php echo $_SERVER['PATH_INFO']; ?>">
                <li style="margin: 12px 30px 0px 0px;">
                  <div class="form-group"> 
                    <select  class="form-control " name="company_id" style="background-color: #ccc; cursor: pointer;" onchange="get_company_id()">
                      
                      <?php $all_company = $this->Dashboard_model->select_all_company(); 
                      foreach ($all_company as $key => $value) { ?>
                        <option value="<?php echo $value['id']; ?>" <?php if($value['id'] == $_SESSION['company_id']){ echo 'selected'; } ?>><?php echo $value['company_name']; ?></option>
                      <?php } ?>
                    </select>   
                 </div>                
                </li>
              </form>
              <?php } ?>

              </ul>
            </nav>
          </div>
        </div>

        <script type="text/javascript">
          function get_company_id(){
            $('#upload_company_id').submit();
          }
        </script>