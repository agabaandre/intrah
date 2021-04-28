
<!--Porfolio Section Start-->
<section id="portfolio" class="portfolio-section pt-page">
    <div class="section-container">

        <!--Page Heading-->
        <div class="page-heading">
            <span class="icon"><i class="lnr lnr-briefcase"></i></span>
            <h2>Portfolio.</h2>
        </div>

        <!--div class="row">
            <div class="col-md-12 portfolio-filter text-center">
                <ul>
                    <li class="active" data-filter="*">All</li>
                    <li data-filter=".brand">Brand</li>
                    <li data-filter=".design">Design</li>
                    <li data-filter=".graphic">Graphic</li>
                </ul>
            </div>
        </div -->

        <!--Portfolio Items-->
        <div class="row portfolio-items mb-50">

            
           <?php  foreach ($portfolios as $port):   ?>
                <!--Portfolio Item-->
                <div class="item col-lg-4 col-sm-6 brand graphic">
                    <a class="image-link" href="<?php echo base_url(); ?>assets/img/portfolio/<?php echo $port->image; ?>">
                        <figure>
                            <img src="<?php echo base_url(); ?>assets/img/portfolio/<?php echo $port->image; ?>" alt="">
                            <figcaption>
                                <h4><?php echo $port->title; ?></h4>
                                <p><?php echo $port->brand; ?></p>
                            </figcaption>
                        </figure>
                    </a>
                </div>
            <?php  endforeach;    ?>


        </div>
    </div>
</section>
<!--Porfolio Section End-->