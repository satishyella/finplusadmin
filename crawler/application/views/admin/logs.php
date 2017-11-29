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
					
					<button><a href="#"   data-toggle="modal" data-target=".bs-example-modal-sm" data-backdrop="static" data-keyboard="false">Url Crawling</a></button>
					
<font size="5" color="red">
<?PHP echo  $this->session->flashdata('errmsg')? $this->session->flashdata('errmsg'):'';?></font>
<font size="5" color="green">
<?PHP echo  $this->session->flashdata('susmsg')? $this->session->flashdata('susmsg'):'';?></font>
					 
					<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
          <th>#</th>
          
          <th>InsiderDocumentID</th>
          
		  <th>Cik</th>
		  <th>issuerName</th>
		  <th>Document Path</th>
		  <th>Date</th>
          <th>Type</th>
		  <th>Status</th>
            </tr>
        </thead>
        
        <tbody>
		<?php  $sno=0; 
		
		foreach ($logs as $log){ $sno++?>
		 <tr>
                <td><?=$sno?></td>
                
                <td><?=$log['InsiderDocumentID']?></td>
                <td><?=$log['issuerCik']?></td>
                <td><?=$log['issuerName']?></td>
                <td><?=$log['Document_Path']?></td>
                <td><?=$log['periodOfReport']?></td>
                <td><?=$log['documentType']?></td>
                <td><?php if($log['curl_status']==1){ echo "Download and Parsed"; } else {
					echo '<a href='.site_url().'admin/urlcrawling?url='.$log['Document_Path'].'>Parsed Now</a>';
				}?></td>
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
          <h4 class="modal-title" id="exampleModalLabel" >Crawling</h4>
        </div>
        <div class="modal-body">
          <div class="modal-body">
				<form class="form-horizontal" id="urlc" role="form" action='<?php echo base_url();?>admin/urlcrawling' method='post'>
					<div class="form-group">
						<span class="control-label col-sm-2 sa-formpopup">Url</span>
						<div class="col-sm-10">
							<input type="text" name="url" style="border: 1px solid rgba(0, 85, 179, 1); " class="form-control sa-bordnone sa-width250" placeholder="Sample Url :https://www.sec.gov/Archives/edgar/data/1800/000117911017013439/edgar.xml" >
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