<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Finacplus Admin</title>
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
    <link href='<?php echo base_url();?>assets/css/css.css' rel='stylesheet' type='text/css'>
	    <link href="<?php echo base_url();?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
		 <script src="<?php echo base_url();?>assets/js/d3.v3.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/c3.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-image="<?php echo base_url();?>assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <a href="#" class="simple-text">
                    <img src="<?php echo base_url();?>assets/img/finacplus-logo.png" width='200px' >
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li   <?php if($active=='dashboard'){ echo 'class="active"'; } ?>>
                        <a href="<?php echo base_url();?>admin/dashboard?token=<?=$this->session->userdata("token"); ?> ">
                            
                            <p>Dashboard</p>
                        </a>
						
                    </li>
                  <li <?php 
				  if($active=='form'){ echo 'class="active"'; } ?>>
                        <a href="<?php echo base_url();?>admin/forms?token=<?=$this->session->userdata("token"); ?> ">
                            
                            <p>Forms</p>
                        </a>
						
                    </li>
					<li <?php if($active=='log'){ echo 'class="active"'; } ?>>
                        <a href="<?php echo base_url();?>admin/logs?token=<?=$this->session->userdata("token"); ?> ">
                            
                            <p>History</p>
                        </a>
						
                    </li>
                    <!-- <li>
                        <a href="./graph.html">
                            <i class="material-icons">content_paste</i>
                            <p>Graph</p>
                        </a>
                    </li>
                    
						<li>
                        <a href="">
                            <i class="material-icons text-gray">notifications</i>
                            <p>Notifications</p>
                        </a>
                    </li> 
                   -->
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Dashboard </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                           <!-- <li class="dropdown">
                               <a href="#" class="dropdown-toggle" >
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">0</span>
                                    <p class="hidden-lg hidden-md">Notifications</p>
                                </a> 
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Mike John responded to your email</a>
                                    </li>
                                    <li>
                                        <a href="#">You have 5 new tasks</a>
                                    </li>
                                    <li>
                                        <a href="#">You're now friend with Andrew</a>
                                    </li>
                                    <li>
                                        <a href="#">Another Notification</a>
                                    </li>
                                    <li>
                                        <a href="#">Another One</a>
                                    </li>
                                </ul>
                            </li> -->
                            <li>
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
								<i><?=$this->session->userdata('login');?></i>
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
								 <ul class="dropdown-menu">
								 <li>
                                        <a href="<?= base_url();?>admin/settings?token=<?=$this->session->userdata('token');?>">Settings</a>
                                    </li>
								 <li>
                                        <a href="<?= base_url();?>admin/changepassword?token=<?=$this->session->userdata('token');?>">Chnage Password</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url();?>admin/logout">Logout</a>
                                    </li>
									</ul>
								
                            </li>
                        </ul>
                        <!--<form class="navbar-form navbar-right" role="search">
                            <div class="form-group  is-empty">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </form> -->
                    </div>
                </div>
            </nav>
           <?php $this->load->view($page);?>
        </div>
    </div>
<div class="modal-backdrop fade" id="cfms_loading"><img class="cfmsLoading" src="<?php echo base_url();?>assets/img/loading.gif" /></div>

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
<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>





<!-- Material Dashboard javascript methods -->
<script src="<?php echo base_url();?>assets/js/material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url();?>assets/js/demo.js"></script>
<script type="text/javascript">
    
	
	 $(document).ready(function() {
    $('#example').DataTable();
	
	
} );

document.onreadystatechange = function () {
  var state = document.readyState
  
  $("#cfms_loading").addClass("in");
  
  if (state == 'complete') {
	  //$("#cfms_loading").removeClass("in");
       setTimeout(function(){
        $("#cfms_loading").removeClass("in");
      },1000); 
  }
}
</script>
<style>
#cfms_loading{display:none}
#cfms_loading.in{display:block;}
.cfmsLoading{position:absolute;left:50%; top:50%; z-index:9999}
.error{color:red !important}
</style>

<script>
 $("#companyadd").validate({
    // Specify validation rules
    rules: {
     cik: "required",
      cname: "required",
      
    },
    messages: {
      cik: "Please enter your Cik ",
      cname: "Please enter Company Name",
      
    },
    
  });
  
  $("#urlc").validate({
    // Specify validation rules
    rules: {
     url: "required"
      
    },
    messages: {
      
      url: "Please enter Url"
      
    },
    
  });
  
  $("#passwordchange").validate({
    // Specify validation rules
    rules: {
     confpassword: "required",
      password: "required"
	  
    },
    messages: {
      confpassword: "Please enter Conform Password",
      password: "Please enter New  Password",
      
    },
    
  });
  </script>

</html>