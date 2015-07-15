<footer class="foot-main">
    <div class="container footer-menu">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="ftr-head">
                    <h4>DESIGN HOTEL CHENNAI</h4>
                    <p>
                        Located at Phoenix Marketcity</p>
                    <p>
                        142, Velachery Main Road, </p>
                    <p>Velachery, Chennai</p>
                    <p>Tamil Nadu 600 042</p>

                    <div class="pad-tp">
                        <p>Tel: +91 44 33161718</p>
                        <p>Fax: +91 44 33161717</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="ftr-head">
                    <ul>
                        <li><a href="<?php echo site_url('/website/overview') ?>">  OVERVIEW</a>
                        </li>
                        <li><a href="<?php echo site_url('/website/room') ?>">ROOMS</a>
                        </li>
                        <li><a href="<?php echo site_url('/website/amenities') ?>">AMENITIES</a>
                        </li>
                        <li><a href="<?php echo site_url('/website/gallery') ?>">GALLERY</a>
                        </li>
                        <li><a href="<?php echo site_url('/website/explore') ?>">EXPLORE PHOENIX MARKETCITY</a>
                        </li>
                        <li><a href="<?php echo site_url('/website/contact') ?>">CONTACT US</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="ftr-head footer-last">
                    <h5>NEWSLETTER SIGNUP</h5>
                    <form class="footer-form">
                        <div class="input-text">
                            <input type="text" class="form-control" id="" placeholder="Enter Email Address">
                        </div>

                        <div class="button-text">
                            <button type="submit" class="btn btn-default">GO</button>
                        </div>
                </div>
                </form>

                <!--
                    <form class="footer-form">
                        <div class="row">
                            <div class="col-sm-offset-2 col-xs-8">
                                <div class="form-group text-main">
                                    <input type="text" class="form-control" id="" placeholder="Enter Email Address">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-default">GO</button>
                            </div>
                        </div>
                    </form>
-->
                <div class="pull-right footer-icons">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"> <i class="fa fa-instagram"></i>
                    </a>
                </div>
                <div class="text-footer-link">
                    <p class="pull-right">COPYRIGHT <a>DESIGN HOTEL CHENNAI 2015</a>
                    </p>
                    <p class="pull-right">DESIGNED BY <a>TING</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>
</footer>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    $(window).load(function () {
        $('.flexslider').flexslider({
            animation: "slide",
            animationLoop: false,
            pauseOnHover: true,
            itemWidth: 284,
            //    itemMargin: 5,

            maxItems: 3
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".fancybox-thumb").fancybox({
            prevEffect: 'none',
            nextEffect: 'none',
            helpers: {
                title: {
                    type: 'outside'
                },
                thumbs: {
                    width: 50,
                    height: 50
                }
            }
        });
    });
</script>
</body>



</html>