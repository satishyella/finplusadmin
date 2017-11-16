 <div class="content">
                <div class="container-fluid">
                                      					
					<div class="row">
					<?php 
		if($this->session->flashdata('err_msg')) { 
			echo "<div class='alert alert-danger'>".$this->session->flashdata('err_msg')." <button type='button' class='close' data-dismiss='alert'>x</button></div>";
		}
		if($this->session->flashdata('suc_msg')) { 
			echo "<div class='alert alert-success'>".$this->session->flashdata('suc_msg')." <button type='button' class='close' data-dismiss='alert'>x</button></div>"; 
		}
	?>
					
					
<font size="5" color="red">
<?PHP echo  $this->session->flashdata('errmsg')? $this->session->flashdata('errmsg'):'';?></font>
<font size="5" color="green">
<?PHP echo  $this->session->flashdata('susmsg')? $this->session->flashdata('susmsg'):'';?></font>
					 
					<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
          <th>#</th>
          
          <th>Form Name</th>
          
		  <th>Status</th>
		  
            </tr>
        </thead>
        
        <tbody>
		<?php  $sno=0; 
		foreach ($forms as $formdetails){ $sno++?>
		 <tr>
                <td><?=$sno?></td>
                
                <td><?=$formdetails['form_name']?></td>
                <td><?php if($formdetails['status']){ echo '<a href='.site_url().'admin/act_inact_form/'.$formdetails['sno'].'/0/'.$this->session->userdata("token").'>Active</a>';} else { echo '<a href='.site_url().'admin/act_inact_form/'.$formdetails['sno'].'/1/'.$this->session->userdata("token").'>In-active</a>'; } ?></td>
                
            </tr>
		<?php } ?>
           
			
			
        </tbody>
		
    </table>
					
					
					</div>
					
					 <div class="modal fade bs-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg cantAccess" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e1e1e1  ;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalLabel" >Add Company</h4>
        </div>
        <div class="modal-body">
          <div class="modal-body">
				<form class="form-horizontal" id="companyadd" role="form" action='<?php echo base_url();?>admin/addcompany' method='post'>
					<div class="form-group">
						<span class="control-label col-sm-4 sa-formpopup">Cik</span>
						<div class="col-sm-4">
							<input type="text" name="cik" style="border: 1px solid rgba(0, 85, 179, 1); " class="form-control sa-bordnone sa-width250" placeholder="Enter Cik" >
						</div>
					</div>
                    <div class="form-group">
						<span class="control-label col-sm-4 sa-formpopup">Firmid</span>
						<div class="col-sm-4">
							<input type="text" name="firmid" style="border: 1px solid rgba(0, 85, 179, 1); " class="form-control sa-bordnone sa-width250" placeholder="Enter frmid" >
						</div>
					</div>	
<div class="form-group">
						<span class="control-label col-sm-4 sa-formpopup">Company Nmae</span>
						<div class="col-sm-4">
							<input type="text" name="cname" style="border: 1px solid rgba(0, 85, 179, 1); " class="form-control sa-bordnone sa-width250" placeholder="Enter Company Name" >
						</div>
					</div>	
<div class="form-group">
						<span class="control-label col-sm-4 sa-formpopup">Comments</span>
						<div class="col-sm-4">
							<input type="text" name="comments" style="border: 1px solid rgba(0, 85, 179, 1); " class="form-control sa-bordnone sa-width250" placeholder="Enter Comments" >
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
					
           </div>
					</div>