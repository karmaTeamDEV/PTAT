<!DOCTYPE html>
<html lang="en">
  <head>
    
<style>
.main-content{
  width: 50%;
  border-radius: 20px;
  box-shadow: 0 5px 5px rgba(0,0,0,.4);
  margin: 6em auto;
  display: flex;
}
.company__info{
  background-color: #0e9ca6;
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: #fff;
}
.fa-android{
  font-size:3em;
}
@media screen and (max-width: 640px) {
  .main-content{width: 90%;}
  .company__info{
    display: none;
  }
  .login_form{
    border-top-left-radius:20px;
    border-bottom-left-radius:20px;
  }
}
@media screen and (min-width: 642px) and (max-width:1024px){
  .main-content{width:70%;}
}
.row > h2{
  color:#0e9ca6;
}
.login_form{
  background-color: #fff;
  border-top-right-radius:20px;
  border-bottom-right-radius:20px;
  border-top:1px solid #ccc;
  border-right:1px solid #ccc;
}
form{
  padding: 0 2em;
}
.form__input{
  width: 100%;
  border:0px solid transparent;
  border-radius: 0;
  border-bottom: 1px solid #aaa;
  padding: 1em .5em .5em;
  padding-left: 2em;
  outline:none;
  margin:1.5em auto;
  transition: all .5s ease;
}
.form__input:focus{
  border-bottom-color: #008080;
  box-shadow: 0 0 5px rgba(0,80,80,.4); 
  border-radius: 4px;
}
.btn{
  transition: all .5s ease;
  width: 70%;
  border-radius: 30px;
  color:#fff;
  font-weight: 600;
  background-color: #0e9ca6;
  border: 1px solid #0e9ca6;
  margin-top: 1.5em;
  margin-bottom: 1em;
  border-radius:20px!important;
}
.btn:hover, .btn:focus{
  background-color: #008080;
  color:#fff!important;
  border-radius:20px!important;
}
</style>
    <title>Path To Agility</title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_path;?>design/build/images/favicon.png">
    <!-- Bootstrap -->
    <link href="<?php echo base_path;?>design/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_path;?>design/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body style="background:url(<?php echo base_path;?>design/build/images/background.jpg);background-color:#FFF;
  background-position:top center;background-repeat:no-repeat;background-attachment:fixed;background-size: cover;">
    <div align="center">
    <div class="container-fluid">
    <div class="row main-content bg-success text-center" style="margin-top:150px;">
      <div class="col-md-4 text-center company__info">
        <span class="company__logo"><h2><img src="<?php echo base_path;?>design/build/images/logo.png"/></h2></span>
        <h2 class="company_title">Path to Agility</h2>
      </div>
      <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
        <div class="container-fluid">
          <div class="row">
            <h2>Log In</h2>
            <div style="color: red;"><?php if($_SESSION['err_msg']){echo $_SESSION['err_msg']; unset($_SESSION['err_msg']); } ?></div>
          </div>
          <div class="row">
           <?php
            $attributes = array( 'name' => 'MemberLogin', 'role' => 'form');        
            echo form_open(site_url.'member/login', $attributes);
            ?>
              <div class="row">
                <input type="text" id="user_id" required="" name="user_id" class="form__input" placeholder="Username">
              </div>
              <div class="row">
                <!-- <span class="fa fa-lock"></span> -->
                <input type="password" id="password" required="" name="password" class="form__input" placeholder="Password">
              </div>
             <!--  <div class="row">
                <input type="checkbox" name="remember_me" id="remember_me" class="">
                <label for="remember_me">Remember Me!</label>
              </div> -->
              <div class="row">
                <input type="submit" name="LogIN"  value="Login" class="btn">
              </div>
            </form>
          </div>
          <div class="row">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <!-- <p>Don't have an account? <a href="#">Register Here</a></p> -->
          </div>
        </div>
      </div>
    </div>
        </div>
  </div>
  <!-- Footer -->
  <div class="container-fluid text-center footer">
    <p style="color:#000;">Best viewed in latest version of Chrome | &copy; <?php echo date("Y");?>.</p>
  </div>
  </body>
</html>
