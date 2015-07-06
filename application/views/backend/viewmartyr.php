<div class="row" style="padding:1% 0">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right" href="<?php echo site_url("site/createmartyr"); ?>"><i class="icon-plus"></i>Create </a> &nbsp;
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                martyr Details
            </header>
            <div class="drawchintantable">
                <?php $this->chintantable->createsearch("martyr List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th data-field="id">ID</th>
                            <th data-field="regimentname">Regiment</th>
                            <th data-field="name">Name</th>
                            <th data-field="rank">Rank</th>
                            <th data-field="unit">Unit</th>
                            <th data-field="homestate">Home State</th>
                            <th data-field="operation">Operation</th>
                            <th data-field="dateofdeath">Date Of Death</th>
<!--                            <th data-field="image">Image</th>-->
                            <th data-field="age">Age</th>
<!--
                            <th data-field="description">Description</th>
                            <th data-field="status">Status</th>
-->
                            <th data-field="lights">Lights</th>
                            <th data-field="email">Email</th>
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
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.regimentname + "</td><td>" + resultrow.name + "</td><td>" + resultrow.rank + "</td><td>" + resultrow.unit + "</td><td>" + resultrow.homestate + "</td><td>" + resultrow.operation + "</td><td>" + resultrow.dateofdeath + "</td><td>" + resultrow.age + "</td><td>" + resultrow.lights + "</td><td>" + resultrow.email + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editmartyr?id=');?>" + resultrow.id + "'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deletemartyr?id='); ?>" + resultrow.id + "'><i class='icon-trash '></i></a></td></tr>";
            }
            generatejquery("<?php echo $base_url;?>");
        </script>
    </div>
</div>
