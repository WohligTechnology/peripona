<section class="panel">
    <header class="panel-heading">
        message Details
    </header>
    <div class="panel-body">
        <form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/editmessagesubmit");?>' enctype='multipart/form-data'>
            <input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Name</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="name" value='<?php echo set_value(' name ',$before->name);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Contact Number</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="contact" value='<?php echo set_value(' contact ',$before->contact);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Email</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="email" value='<?php echo set_value(' email ',$before->email);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">City</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="city" value='<?php echo set_value(' city ',$before->city);?>'>
                </div>
            </div>
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Message</label>
                <div class="col-sm-8">
                    <textarea name="message" id="" cols="20" rows="10" class="form-control tinymce"><?php echo set_value( 'message',$before->message);?></textarea>
                </div>
            </div>
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Martry</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "martry",$martry,set_value( 'martry',$before->martry),"class='chzn-select form-control'");?>
                </div>
            </div>
            
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">approval</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "approval",$approval,set_value( 'approval',$before->approval),"class='chzn-select form-control'");?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href='<?php echo site_url("site/viewpage"); ?>' class='btn btn-secondary'>Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
