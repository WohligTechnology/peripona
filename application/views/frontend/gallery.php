<div class="contact-bk">
    <img src="<?php echo base_url('frontassets/image/gallery.jpg'); ?>" class="img-responsive">
    <div class="contact-text">
        <h1>Gallery</h1>
        <div class="circle">

        </div>
    </div>
</div>
<div class="container">
    <div class="overview-cont text-center">
        <p>
            We invite our leisure and business travelers to become immersed in the charm and intrigue of Design Hotel Chennai’s contemporary art styles infused with traditional South Indian Art. Welcome home! </p>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery1.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery1.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery2.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery2.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery3.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery3.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery4.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery4.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery5.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery5.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery6.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery6.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery7.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery7.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery8.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery8.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery9.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery9.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
    </div>   
        <div class="row">
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery10.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery10.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery11.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery11.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery12.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery12.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() { 

    $('img').hide();
    $('img').each(function(i) {
        if (this.complete) {
            $(this).fadeIn();
        } else {
            $(this).load(function() {
                $(this).fadeIn(1000);
            });
        }
    });
});
</script>