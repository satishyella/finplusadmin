				<div class="content">
					<div class="container-fluid">
					
					
					<div class="row"> 

<font size="5" color="red">
<?PHP echo  $this->session->flashdata('errmsg')? $this->session->flashdata('errmsg'):'';?></font>
<font size="5" color="green">
<?PHP echo  $this->session->flashdata('susmsg')? $this->session->flashdata('susmsg'):'';?></font>

			<div class="col-md-12">
			  
				<div class="tabbable-panel">
					<div class="tabbable-line">
						<form class="form" id="passwordchange" style="margin-top:4%;"  action='<?=base_url();?>admin/changepassword?token=<?php echo $this->session->userdata('token'); ?>' method='post'>
			New Password <input type="password" placeholder="New Password" name='password'>
			Conform Password <input type="password" placeholder="Conform Password" name='confpassword'>
			<button type="submit" style='background:#0088ce;color:white'>Login</button>
		</form>
					</div>
				</div>

			
				
			</div>

					</div>
					
					
															
						
						

						
						
						
					</div>
				</div>
			   