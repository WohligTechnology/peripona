	    <section class="panel">
		    <header class="panel-heading">
				 Contact Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editcontactussubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
			
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Firstname</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="firstname" value="<?php echo set_value('firstname',$before->firstname);?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Lastname</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="lastname" value="<?php echo set_value('lastname',$before->lastname);?>">
				  </div>
				</div>
			  <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contact" value="<?php echo set_value('contact',$before->contact);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email',$before->email);?>">
				  </div>
				</div>
			
			   	<div class=" form-group">
				<label class="col-sm-2 control-label" for="normal-field">Request</label>
				<div class="col-sm-8">
					<textarea name="request" id="" cols="20" rows="10" class="form-control tinymce"><?php echo set_value( 'request',$before->request);?></textarea>
				</div>
			</div>
								
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Status</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('status',$status,set_value('status',$before->status),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
					<div class="form-group">
				<label class="col-sm-2 control-label" for="normal-field">Time stamp</label>
				<div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="timestamp" value='<?php echo set_value(' timestamp ',$before->timestamp);?>'>
				</div>
			</div>
			
				
		
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewcontactus'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
