<section class="panel">
    <header class="panel-heading">
        martyr Details
    </header>
    <div class="panel-body">
        <form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/editmartyrsubmit");?>' enctype='multipart/form-data'>
            <input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Regiment</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "regiment",$regiment,set_value( 'regiment',$before->regiment),"class='chzn-select form-control'");?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Name</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="name" value='<?php echo set_value(' name ',$before->name);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Rank</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="rank" value='<?php echo set_value(' rank ',$before->rank);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Unit</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="unit" value='<?php echo set_value(' unit ',$before->unit);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Home State</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="homestate" value='<?php echo set_value(' homestate ',$before->homestate);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Operation</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="operation" value='<?php echo set_value(' operation ',$before->operation);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Date Of Death</label>
                <div class="col-sm-4">
                    <input type="date" id="normal-field" class="form-control" name="dateofdeath" value='<?php echo set_value(' dateofdeath ',$before->dateofdeath);?>'>
                </div>
            </div>
            
            
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Image</label>
				  <div class="col-sm-4">
					<input type="file" id="normal-field" class="form-control" name="image" value="<?php echo set_value('image',$before->image);?>">
					<?php if($before->image == "")
						 { }
						 else
						 { ?>
							<img src="<?php echo base_url('uploads')."/".$before->image; ?>" width="140px" height="140px">
						<?php }
					?>
				  </div>
				</div>
				
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Age</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="age" value='<?php echo set_value(' age ',$before->age);?>'>
                </div>
            </div>
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Description</label>
                <div class="col-sm-8">
                    <textarea name="description" id="" cols="20" rows="10" class="form-control tinymce"><?php echo set_value( 'description',$before->description);?></textarea>
                </div>
            </div>
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Status</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "status",$status,set_value( 'status',$before->status),"class='chzn-select form-control'");?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Lights</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="lights" value='<?php echo set_value(' lights ',$before->lights);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Email</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="email" value='<?php echo set_value(' email ',$before->email);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href='<?php echo site_url("site/viewmartyr"); ?>' class='btn btn-secondary'>Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
