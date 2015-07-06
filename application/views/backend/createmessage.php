<div class="row" style="padding:1% 0">
    <div class="col-md-12">
        <div class="pull-right">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                message Details
            </header>
            <div class="panel-body">
                <form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/createmessagesubmit");?>' enctype='multipart/form-data'>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Name</label>
                            <div class="col-sm-4">
                                <input type="text" id="normal-field" class="form-control" name="name" value='<?php echo set_value(' name ');?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Contact Number</label>
                            <div class="col-sm-4">
                                <input type="text" id="normal-field" class="form-control" name="contact" value='<?php echo set_value(' contact ');?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Email</label>
                            <div class="col-sm-4">
                                <input type="text" id="normal-field" class="form-control" name="email" value='<?php echo set_value(' email ');?>'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="normal-field">City</label>
                            <div class="col-sm-4">
                                <input type="text" id="normal-field" class="form-control" name="city" value='<?php echo set_value(' city ');?>'>
                            </div>
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Message</label>
                            <div class="col-sm-8">
                                <textarea name="message" id="" cols="20" rows="10" class="form-control tinymce"><?php echo set_value( 'message');?></textarea>
                            </div>
                        </div>
                        <div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Martry</label>
                            <div class="col-sm-4">
                                <?php echo form_dropdown( "martry",$martry,set_value( 'martry'), "class='chzn-select form-control'");?>
                            </div>
                        </div>
                        
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">approval</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "approval",$approval,set_value( 'approval'),"class='chzn-select form-control'");?>
                </div>
            </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="<?php echo site_url("site/viewmessage"); ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                </form>
                </div>
        </section>
        </div>
    </div>
