
<!--About Section Start-->
<section id="about" class="about-section pt-page">
    <div class="section-container">
        <!--Page Heading-->
        <div class="page-heading">
            <span class="icon"><i class="lnr lnr-user"></i></span>
            <h2>About Me.</h2>
        </div>

        <!-- About Info Row Start-->
        <div class="row about mb-70">

            <div class="col-lg-8">
                <!--Personal Intro-->
                <h3 class="mb-20"><?php echo $profile_data->profileTile; ?></h3>
                <?php echo $profile_data->profileDesc; ?>

                <!--Signature Image-->
                <!--div class="signature mt-20">
                    <img src="<?php echo base_url(); ?>assets/img/signature-white.png" alt="">
                </div -->
            </div>

            <!--Personal Info-->
            <div class="col-lg-4">
                <div class="about-info">
                    <h3 class="mb-20">Personal Information</h3>
                    <ul>
                        <?php if (($profile_data->resume)==true) { ?>
                        <li>
                            <span class="title">Name</span>
                            <span class="value"><?php echo $profile_data->names; ?></span>
                        </li>
                        <?php } ?>

                        <?php if (($profile_data->dob)==true) { ?>
                        <li>
                            <span class="title">Age</span>
                            <span class="value"><?php echo date("Y-d-m") - $profile_data->dob; ?> Years</span>
                        </li>
                        <?php } ?>

                        <?php if (($profile_data->nationality)==true) { ?>
                        <li>
                            <span class="title">Nationality</span>
                            <span class="value"><?php echo $profile_data->nationality; ?></span>
                        </li>
                        <?php } ?>

                        <?php if (($profile_data->residence)==true) { ?>
                        <li>
                            <span class="title">Residence</span>
                            <span class="value"><?php echo $profile_data->residence; ?></span>
                        </li>
                        <?php } ?>

                        <?php if (($profile_data->email)==true) { ?>
                        <li>
                            <span class="title">Email</span>
                            <span class="value"><?php echo $profile_data->email; ?></span>
                        </li>
                        <?php } ?>

                        <?php if (($profile_data->phone1)==true || ($profile_data->phone2)) { ?>
                        <li>
                            <span class="title">Phone</span>
                            <span class="value"><?php echo $profile_data->phone1; ?>, <?php echo $profile_data->phone2; ?></span>
                        </li>
                        <?php } ?>

                        <?php if (($profile_data->occupation)==true) { ?>
                        <li>
                            <span class="title">Position</span>
                            <span class="value"><?php echo $profile_data->occupation; ?></span>
                        </li>
                        <?php } ?>
                    </ul>

                    <?php if (($profile_data->resume)==true) { ?>

                        <div class="resume-button mt-30">
                            <a class="btn-main" href="<?php echo $profile_data->resume; ?>" target="_blank">Download Resume</a>
                        </div>
                        
                    <?php } ?>

                </div>
            </div>
        </div>
        <!-- About Info Row End-->

        <!--Services Row Start-->
        <div class="row services mb-30">
            <div class="col-md-12">
                <div class="subheading">
                    <h3>Services</h3>
                </div>
            </div>

            <?php  foreach ($services as $service){ ?>
            <!--Service Item-->
            <div class="col-lg-3 col-sm-6">
                <div class="service-item">
                    <div class="icon"><i class="lnr <?php echo $service->icon; ?>"></i></div>
                    <h4><?php echo $service->title; ?></h4>
                    <p><?php echo $service->description; ?></p>
                </div>
            </div>
            <?php } ?>

        </div>
        <!--Services Row End-->

        <!--Clients Row Start-->
        <!--div class="row clients mb-70">
            <div class="col-md-12">
                <div class="subheading">
                    <h3>Clients</h3>
                </div>
            </div>

            <div class="owl-carousel owl-theme">
                <?php   foreach ($clients as $client){  ?>
                    
                    <div class="client-logo">
                        <a href="<?php echo $client->url; ?>" target="_blank">
                            <img src="<?php echo base_url(); ?>assets/img/clients/<?php echo $client->logo; ?>" alt="">
                        </a>
                    </div>
                <?php } ?>

            </div>
        </div -->
        <!--Clients Row End-->

        <!--Testimonials Row Start-->
        <!--div class="row testimonials mb-50">
            <div class="col-md-12">
                <div class="subheading">
                    <h3>Testimonials</h3>
                </div>
                <div class="owl-carousel owl-theme">

                    --Testimonail Item--
                    <div class="testimonial-item">
                        <div class="testimonial-content">
                            <p>Ipsum ab necessitatibus numquam vitae quis. Nobis nostrum deserunt suscipit eos fugit. Consectetur dolorum temporibus facilis impedit exercitationem dignissimos.</p>
                        </div>
                        <div class="testimonial-meta">
                            <img src="<?php echo base_url(); ?>assets/img/testimonials/author-1.jpg" alt="">
                            <div class="meta-info">
                                <h4>Kate Fox</h4>
                                <p>Digital Marketing Executive</p>
                            </div>
                        </div>
                    </div>

                   --Testimonail Item--
                    <div class="testimonial-item">
                        <div class="testimonial-content">
                            <p>Ipsum ab necessitatibus numquam vitae quis. Nobis nostrum deserunt suscipit eos fugit. Consectetur dolorum temporibus facilis impedit exercitationem dignissimos.</p>
                        </div>
                        <div class="testimonial-meta">
                            <img src="<?php echo base_url(); ?>assets/img/testimonials/author-2.jpg" alt="">
                            <div class="meta-info">
                                <h4>Emma Jones</h4>
                                <p>Creative Director</p>
                            </div>
                        </div>
                    </div>

                    --Testimonail Item--
                    <div class="testimonial-item">
                        <div class="testimonial-content">
                            <p>Ipsum ab necessitatibus numquam vitae quis. Nobis nostrum deserunt suscipit eos fugit. Consectetur dolorum temporibus facilis impedit exercitationem dignissimos.</p>
                        </div>
                        <div class="testimonial-meta">
                            <img src="<?php echo base_url(); ?>assets/img/testimonials/author-3.jpg" alt="">
                            <div class="meta-info">
                                <h4>Jack Smith</h4>
                                <p>Marketing Director</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div -->
    </div>
</section>
<!--About Section Start-->