<div class="container">

    <div class="row">

        <div class="overview-cont text-center">
            <h2>More than just a hotel

</h2>
            <p>
                Our architectural detail is but one element that defines Design Hotel Chennai as one of the best luxury boutique hotels in India – and certainly its most uncommon. In line with our commitment to offer our guests a diversity of quality choice, our 26 well-appointed guest rooms are elegantly designed according to the bold artistic theme of our four culturally distinct corridors.
            </p>
        </div>
    </div>
    <?php
        $countslider=0;
    foreach($room as $key=>$row)
    {
        $mt50="";
        $id=$row->id;
        $name=$row->name;
        $description=$row->description;
        $images=$row->roomimage;
        if($key>0)
        {
        $mt50="mt50";
        }
    ?>
    
    <div class="row gallery-room <?php echo $mt50;?>">
        <div class="col-md-3 padding0">
            <div class="room-side <?php echo $name;?>">
                <img src="<?php echo base_url('frontassets/image/header.png'); ?>">
                <h1><?php echo $name;?></h1>
                <p><?php echo $description;?></p>
                <div class="wrap-btn">
                     <a href="<?php echo site_url('/website/roomdetail?id='.$id) ?>" class="button enter-btn">ENTER
                    </a>
                    <div class="all-btns"></div>
                </div>
            </div>
        </div>
        <div class="col-md-9 padding0">
            <div id="myCarousel-<?php echo $countslider;?>" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                   
                    <?php 
                    foreach($images as $key1=>$img)
    {
                    $activeclass="";
        $imgvalue=$img->image;
                    if($key1==0)
                    {
                        $activeclass="active";
                    }
                    ?>
                    <div class="item <?php echo $activeclass; ?>">
                        <img src="<?php echo base_url('uploads/'.$imgvalue); ?>" alt="">
                    </div>
                    <?php
                    }
                    ?>
                </div>

                <!-- Left and right controls -->
                <a class=" carousel-controls" href="#myCarousel-<?php echo $countslider;?>" role="button" data-slide="prev">
  <img class="left" src="<?php echo base_url('frontassets/image/left.png'); ?>" alt="Flower">

  </a>
                <a class=" carousel-controls" href="#myCarousel-<?php echo $countslider;?>" role="button" data-slide="next">
   <img class="right" src="<?php echo base_url('frontassets/image/right.png'); ?>" alt="Flower">
<!--    <span class="sr-only">Next</span>-->
  </a>
            </div>
        </div>
    </div>
    <?php
        
        $countslider++;
    }
    ?>
    <div class="row mrg">
        <div class="col-md-offset-3 col-md-6">
            <div class="col-md-6 col-sm-6">
                <div class="col-xs-6">
                    <div class="cal">
                        <p>check in</p>
                        <p class="date">12</p>
                        <p class="date-bold">SEPTEMBER ’15</p>
                        <img src="<?php echo base_url('frontassets/image/amenites/border.png'); ?>" />
                        </a>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="cal">
                        <p>check out</p>
                        <p class="date">17</p>
                        <p class="date-bold">OCTOBER ’15</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="box">
                    <a href="">CHECK AVAILABILITY</a>
                </div>
            </div>
        </div>

    </div>
</div>