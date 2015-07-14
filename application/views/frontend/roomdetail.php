<div class="contact-bk">
    <img src="<?php echo base_url('frontassets/image/roominner.jpg'); ?>" class="img-responsive">
    <div class="contact-text">
        <h1 style="  text-transform: lowercase; font-size: 50px;">maya</h1>
        <div class="circle">
        </div>
    </div>
</div>

    <?php
//print_r($room);
?>
<div class="container maku">
    <div class="row">
        <div class="overview-cont line-hgt">
            <p>
                <?php echo $room->description; ?>
            </p>
<!--
            <p class="pad-top">

                Marble desktops, smooth grey sandstone flooring, flat-screen TVs, plush leather seating and floor to ceiling frameless glass showers leave our guests reluctant to leave the comfort of their 390 sq. ft. rooms.
            </p>
-->

            <div class="acc text-center">
                <span>ACCOMMODATIONS</span>
            </div>
            <div class="med-circle">
            </div>
        </div>
    </div>
    <div class="row">
       <?php
//print_r($accommodation);
        foreach($accommodation as $value)
        {
        ?>
        <div class="col-md-offset-1 col-md-5 col-sm-6 ">

            <div class="amenities-block ul-lists">
                <h1><?php echo $value->title;?></h1>

<?php echo $value->description; ?>

<!--
                <ul style="list-style-type:disc">
                    <li><span>Forest Essentials™ Luxurious Ayurveda Bath Amenities</span>
                    </li>
                    <li><span>Amenities</span>
                    </li>
                    <li><span>Make-up/Shaving Mirror</span>
                    </li>
                    <li><span>Bedroom Slippers</span>
                    </li>
                    <li><span>Hairdryer</span>
                    </li>

                </ul>
-->
            </div>
        </div>
        <?php
        }
        ?>
  
    </div>
    <?php
//    print_r($images);
    ?>
    <div class="row galleryin">
        <div class="acc text-center">
            <span>GALLERY</span>
        </div>
        <div class="med-circle">
        </div>
    </div>
    <div class="row galleryout">
       <?php
        foreach($images as $value)
        {
            $image=$value->image;
        ?>
        <div class="col-md-4 col-sm-6">
            <div class="inner-img">
                <img src="<?php echo base_url('uploads/'.$image); ?>" class="img-responsive" />
            </div>
        </div>
        <?php
        }
        ?>
<!--
        <div class="col-md-4 col-sm-6">
            <div class="inner-img">
                <img src="<?php echo base_url('frontassets/image//gallery/galleryin1.jpg'); ?>" class="img-responsive" />
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="inner-img">
                <img src="<?php echo base_url('frontassets/image//gallery/galleryin2.jpg'); ?>" class="img-responsive" />
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="inner-img">
                <img src="<?php echo base_url('frontassets/image//gallery/galleryin3.jpg'); ?>" class="img-responsive" />
            </div>
        </div>
-->
    </div>
    <div class="row booknowbt">
        <div class="booknow text-center">
            <a href="">BOOK THIS ROOM</a>
        </div>
    </div>

</div>