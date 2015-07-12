<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title></title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('frontassets/css/style.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('frontassets/css/custom.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('frontassets/css/flexslider.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('frontassets/css/mobile.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('frontassets/fancy/jquery.fancybox.css?v=2.1.5'); ?>" />
    <!--    <link rel="stylesheet" type="text/css" href="<?php echo base_url('frontassets/image/style.css'); ?>" />-->

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <!--    <link rel="stylesheet" href="css/main.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

    <!--    <script src="<?php echo base_url("frontassets");?>/js/jquery-1.11.1.min.js"></script>-->
    <script src="<?php echo base_url(" frontassets ");?>/js/jquery.flexslider.js"></script>
    <script src="<?php echo base_url(" frontassets ");?>/fancy/jquery.fancybox.pack.js?v=2.1.5"></script>


    <link rel="stylesheet" href="<?php echo base_url('frontassets/fancy/helpers/jquery.fancybox-buttons.css?v=1.0.5'); ?>" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo base_url(" frontassets ");?>/fancy/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="<?php echo base_url(" frontassets ");?>/fancy/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

    <link rel="stylesheet" href="<?php echo base_url('frontassets/fancy/helpers/jquery.fancybox-thumbs.css?v=1.0.7'); ?>" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo base_url(" frontassets ");?>/fancy/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700,400italic,600italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>

    <!--[if IE]>
        <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="content menu-main">
        <header class="container">
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <div class="logo">
                        <a href="<?php echo site_url('/website/index') ?>">
                        <img src="<?php echo base_url('frontassets/image/logo.png'); ?>">
                    </a>
                    </div>
                </div>
                <div class="col-md-8 text-center col-xs-12 cpn">
                    <nav class="navbar navbar-default" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse thin">
                            <div class="centered-pills">
                                <ul class="nav nav-pills">
                                    <li>
                                        <a <?php if($active=='overview' ){ echo "class='active'"; } ?> href="<?php echo site_url('/website/overview') ?>">
                                      OVERVIEW
                                       </a>
                                        <div class="half-circle"></div>
                                    </li>
                                    <li>
                                        <a <?php if($active=='room' ){ echo "class='active'"; } ?> href="<?php echo site_url('/website/room') ?>">
                                      ROOMS
                                       </a>
                                        <div class="half-circle"></div>
                                    </li>
                                    <li>
                                        <a <?php if($active=='amenities' ){ echo "class='active'"; } ?> href="<?php echo site_url('/website/amenities') ?>">
                                       AMENITIES
                                    
                                    </a>
                                        <div class="half-circle"></div>
                                    </li>
                                    <li>
                                        <a <?php if($active=='gallery' ){ echo "class='active'"; } ?> href="<?php echo site_url('/website/gallery') ?>">
                                      GALLERY
                                      
                                      </a>
                                        <div class="half-circle"></div>
                                    </li>
                                    <li>
                                        <a <?php if($active=='explore' ){ echo "class='active'"; } ?> href="<?php echo site_url('/website/explore') ?>">
                                       EXPLORE PHOENIX MARKETCITY
                                        
                                       </a>
                                        <div class="half-circle"></div>
                                    </li>
                                    <li>
                                        <a <?php if($active=='contact' ){ echo "class='active'"; } ?> href="<?php echo site_url('/website/contact') ?>">
                                      CONTACT US
                                      
                                      </a>
                                        <div class="half-circle"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </nav>
                </div>
            </div>
        </header>
    </div>