<div class="row" style="padding:1% 0">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right" href="<?php echo site_url("site/createmessage"); ?>"><i class="icon-plus"></i>Create </a> &nbsp;
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                message Details
            </header>
            <div class="drawchintantable">
                <?php $this->chintantable->createsearch("message List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th data-field="id">ID</th>
                            <th data-field="name">Name</th>
                            <th data-field="contact">Contact Number</th>
                            <th data-field="email">Email</th>
                            <th data-field="city">City</th>
                            <th data-field="message">Message</th>
                            <th data-field="martry">Martry</th>
                            <th data-field="approval">Approval</th>
                            <th data-field="action">Action</th>
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
                if(resultrow.approval=="1")
                {
                    resultrow.approval="Approved";
                }
                else
                {
                     resultrow.approval="Unapproved";
                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.contact + "</td><td>" + resultrow.email + "</td><td>" + resultrow.city + "</td><td>" + resultrow.message + "</td><td>" + resultrow.martyrname + "</td><td>" + resultrow.approval + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editmessage?id=');?>" + resultrow.id + "'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deletemessage?id='); ?>" + resultrow.id + "'><i class='icon-trash '></i></a></td></tr>";
            }
            generatejquery("<?php echo $base_url;?>");
        </script>
    </div>
</div>
