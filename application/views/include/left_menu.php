        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="#" class="site_title" >
              <img src="<?php echo base_path;?>design/build/images/logo.png" style="width:35px;margin-top:-20px;">
              <span>Path to Agility </span></a>
            </div>
            <div class="clearfix"></div>
            <!-- menu profile quick info -->
            <div class="profile clearfix">               
            </div>
            <!-- /menu profile quick info -->
            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
               <!-- <h3>Population</h3>-->               
               <ul class="nav side-menu">

                <li ><a href="<?php echo site_url;?>Dashboard/dashboard_view_new"><i class="fa fa-tachometer" ></i>Dashboard View </a>
                </li>

                <li><a href="<?php echo site_url;?>Dashboard/progress_report_new"><i class="fa fa-tasks"></i>Progress Report </a>
                </li>

                <li><a href="<?php echo site_url;?>Dashboard/spider_chart_data_manage"><i class="fa fa-database"></i>Manage Score</a>
                </li>

                <li><a href="javascript:void();"><i class="fa fa-area-chart" ></i> Analytics <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">                      
                      <li><a href="<?php echo site_url;?>progress_report_chart/evaluation_results_line_chart"><i class="fa fa-line-chart">
                        
                      </i>Line</a></li>
                       <li><a href="<?php echo site_url;?>Dashboard/spider_chart"><i class="fa fa-pie-chart"></i>Spider</a></li>
                    </ul> 
                 </li>

                 <?php if($_SESSION['role']=='admin' || $_SESSION['role']=='analyst'){ ?>

                  <li><a href="<?php echo site_url;?>Dashboard/manage_master_data">
                    <i class="fa fa-briefcase"></i>Manage Company</a>
                  </li> 

                  <li><a href="<?php echo site_url;?>Dashboard/manage_all_status">
                    <i class="fa fa-clipboard"></i>Manage Status/Color</a>
                  </li> 
                 
                <?php } ?>

                 <?php if($_SESSION['role']=='analyst'){ ?>

                  <li><a href="<?php echo site_url;?>Dashboard/manage_company">
                    <i class="fa fa-building-o"></i>Create Company</a>
                  </li>

                  <?php } ?>

               </ul> 
             </div>

           </div>
           <!-- /sidebar menu -->
         </div>
       </div>
