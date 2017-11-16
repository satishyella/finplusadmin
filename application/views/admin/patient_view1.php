				<div class="content">
					<div class="container-fluid">
					
					
					<div class="row"> 



			<div class="col-md-12">
			  
				<div class="tabbable-panel">
					<div class="tabbable-line">
						<ul class="nav nav-tabs ">
						<li class="active">
								<a href='<?=site_url()."/vet/view?token=".$_GET['token']."&pet=".$_GET['pet']."&parent=".$_GET['parent']."&tparam=no";?>'>
								Last 6 values </a>
							</li>
							<li>
								
								<a href='<?=site_url()."/vet/view?token=".$_GET['token']."&pet=".$_GET['pet']."&parent=".$_GET['parent']."&tparam=48";?>'>48 hours</a>
							</li>
							<li>
								<a href='<?=site_url()."/vet/view?token=".$_GET['token']."&pet=".$_GET['pet']."&parent=".$_GET['parent']."&tparam=168";?>'>
								1 week  </a>
							</li>
							<li>
								<a href='<?=site_url()."/vet/view?token=".$_GET['token']."&pet=".$_GET['pet']."&parent=".$_GET['parent']."&tparam=336";?>'>
								2 Week  </a>
							</li>
							<li>
								<a href='<?=site_url()."/vet/view?token=".$_GET['token']."&pet=".$_GET['pet']."&parent=".$_GET['parent']."&tparam=720";?>'>
								1 Mnonth </a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_default_1">
								
								
									
					 <div class="col-lg-12 col-12" >
					 <div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow" id='chart'>
					 <script>
							var chart = c3.generate({
		data: {
			
			json: <?php echo json_encode($graph);?>,
			 keys: {
				 x:'encounter_Date',
				value: ['prepostinsulin','bloodGlucoseValue'],
			},
			empty: {
		label: {
		  text: "No Data"
		}
	  }
		},
		 axis: {
			x: {
			title:"Nmae",
				type: 'timeseries',
				tick: {
					format: '%Y-%m-%d'
				}
			},
			y:{
			 label: {
					text: 'mg/dL',
					position: 'outer-middle'
					
				}
			}
		}
	});
	</script>
					</div>
					</div>

								
								
								
								
							</div>
							
						</div>
					</div>
				</div>

			
				
			</div>

					</div>
					
					
															
						<div class="row">
						
						
						<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
			
				<tr>
			  <th>#</th>
			  <th>Date </th>
			  <th>Post Meals </th>
			  <th>Post Insulin</th>
			  <th>Blood Glucose</th>
			 
				</tr>
			</thead>
			
			<tbody>
			<?php foreach($tabledata as $tdata) { ?>
				<tr>
				
					<td>1</td>
					<td><?php echo $tdata['encounter_Date']?></td>
					<td><?php echo $tdata['pre_post_meal']?></td>
					<td><?php echo $tdata['pre_post_insulin']?></td>
					<td><?php echo $tdata['bloodGlucoseValue']?></td>
				   
				</tr>
				
				<?php 	}  ?>
				
				
				
			</tbody>
			
		</table>
						
						
						</div>
						

						
						
						
					</div>
				</div>
			   