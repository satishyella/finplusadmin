<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Admin</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url();?>assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url();?>assets/css/demo.css" rel="stylesheet" />
	
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
	    <link href="<?php echo base_url();?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
		<style>
		.error {
  color: #d9534f;
  
}
		</style>
</head>

 

<body>
   	<div class="container">
    <div class="row">
      
      
      
      <div class="col-lg-12">
      	
      	
      			<div class="col-lg-10 col-lg-offset-1 login_db">  
      			
      			<div class="row">
      			<div class="col-lg-6 l-left">
      				
      				<div class="l_logo"><img src="<?php echo base_url();?>assets/img/finacplus-logo.png" >  </div>
      				
      			</div>
      			
      			<div class="col-lg-6 l-right"> 
				<font size="5" color="red">
<?PHP echo  $this->session->flashdata('errmsg')? $this->session->flashdata('errmsg'):'';?></font>
		
     	
		<form id='login-form' class="form" style="margin-top:25%;"  action='<?=base_url();?>admin/login' method='post'>
			<input type="text" placeholder="Username" name='user'>
			<input type="password" placeholder="Password" name='password'></br>
			<button type="submit" id="login-button">Login</button>
		</form>
				
				<a href="#"  style='color: #eeeeee;' data-toggle="modal" data-target=".bs-example-modal-sm" data-backdrop="static" data-keyboard="false">Forgot Password</a>
				</div>   
      			
      			</div>  
      			
      			</div>
      	
      	
      </div>
      
      
       
	</div>
       </div>
	   
	   
	   
	   
	   
	   
	  <div class="modal fade bs-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg cantAccess" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e1e1e1  ;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalLabel" >Forgot Password</h4>
        </div>
        <div class="modal-body">
          <div class="modal-body">
				<form class="form-horizontal" role="form" action='<?php echo base_url();?>admin/forgotpassword' method='post'>
					<div class="form-group">
						<span class="control-label col-sm-4 sa-formpopup">Email</span>
						<div class="col-sm-4">
							<input type="text" name="email" style="border: 1px solid rgba(0, 85, 179, 1); " class="form-control sa-bordnone sa-width250" placeholder="Enter Email id" >
						</div>
					</div>	
					  <button type='submit' style="color: #eeeeee;
background-color: #0055b3;">Submit</button>
				</form>
			</div>
         
         
        
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>   
	   
	   
	   
	   
        
          
</body>
<!--   Core JS Files   -->
<script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/material.min.js" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="<?php echo base_url();?>assets/js/chartist.min.js"></script>
<!--  Dynamic Elements plugin -->
<script src="<?php echo base_url();?>assets/js/arrive.min.js"></script>
<!--  PerfectScrollbar Library -->
<script src="<?php echo base_url();?>assets/js/perfect-scrollbar.jquery.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo base_url();?>assets/js/bootstrap-notify.js"></script>
<!--  Google Maps Plugin    -->

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>





<!-- Material Dashboard javascript methods -->
<script src="<?php echo base_url();?>assets/js/material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url();?>assets/js/demo.js"></script>

<script>
 $("#login-form").validate({
    // Specify validation rules
    rules: {
     user: "required",
      password: "required",
      
    },
    messages: {
      user: "Please enter your User Nmae",
      password: "Please enter your Password",
      
    },
    
  });
  </script>


</html>