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
    <?php
    print_r($images);
    ?>
    <div class="row">
       <?php
        foreach($images as $image);
        {
            print_r($image);
            $img=$image->image;
        ?>
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('uploads/'.$img); ?>">
          <img src="<?php echo base_url('uploads/'.$img); ?>" class="img-responsive"/></a>
            </div>
        </div>
        <?php
        }
        ?>
<!--
        <div class="col-md-4">
            <div class="img-gallery">
                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('frontassets/image//gallery/gallery2.jpg'); ?>">
          <img src="<?php echo base_url('frontassets/image//gallery/gallery2.jpg'); ?>" class="img-responsive"/></a>
            </div>
        </div>
-->
    </div>

</div>