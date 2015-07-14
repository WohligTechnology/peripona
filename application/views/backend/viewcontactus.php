<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createcontactus'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Contactus Details
            </header>
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("Contactus List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="firstname">Firstname</th>
                        <th data-field="lastname">Lastname</th>
                        <th data-field="email">Email</th>
                        <th data-field="status">Status</th>
                        <th data-field="timestamp">Timestamp</th>
                        <th data-field="action"> Actions </th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
                </table>
                   <?php $this->chintantable->createpagination();?>
            </div>
		</section>
		<script>
            function drawtable(resultrow) {
                if(resultrow.status=="0")
                {
                    resultrow.status="Disabled";
                }
                if(resultrow.status=="1")
                {
                     resultrow.status="Enabled";
                }
              
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.firstname + "</td><td>" + resultrow.lastname + "</td><td>" + resultrow.email + "</td><td>" + resultrow.status + "</td><td>" + resultrow.timestamp + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editcontactus?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deletecontactus?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>
