				<div class="content">
					<div class="container-fluid">
					
					
					<div class="row"> 

<font size="5" color="red">
<?PHP echo  $this->session->flashdata('errmsg')? $this->session->flashdata('errmsg'):'';?></font>
<font size="5" color="green">
<?PHP echo  $this->session->flashdata('susmsg')? $this->session->flashdata('susmsg'):'';?></font>

			<div class="col-md-12">
			  
				<div class="tabbable-panel">
					<div crontimeclass="tabbable-line">
					<label>Base Path:<font size=6><b><?php echo $this->config->item('base_path');?></b></font></label>
						<form class="form" id="passwordchange" style="margin-top:4%;"  action='<?=base_url();?>admin/settings?token=<?php echo $this->session->userdata('token'); ?>' method='post'>
			Upload Path <input style="color:#3b7fff" type="text" placeholder="Path" name='upload_path' value='<?php echo $crontime['upload_path'];?>'>
			
			Cron Time  (IN HH:mm 24 hr formate)<input style="color:#3b7fff" type="text" placeholder="Enter Cron time MM:SS" name='crontime' value='<?php echo $crontime['cron_time'];?>'> 
			<button type="submit" style='background:#0088ce;color:white'>Update</button>
		</form>
					</div>
				</div>

			
				
			</div>

					</div>
					
					
															
						
						

						
						
						
					</div>
				</div>
			   