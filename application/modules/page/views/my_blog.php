

<!--Blog Section Start-->
<section id="blog" class="blog-section pt-page">
    <div class="section-container">

        <!--Page Heading-->
        <div class="page-heading">
            <span class="icon"><i class="lnr lnr-book"></i></span>
            <h2>My Blogs.</h2>
        </div>

        <div class="row blogs-masonry">

            <?php foreach ($blogs as $blog):  ?>
                <div class="col-lg-4 col-sm-6">
                    <a href="<?php echo base_url(); ?>my-blog-post/<?php echo $blog->blogId; ?>" class="blog-item">
                        <div class="blog-image">
                            <img src="<?php echo base_url(); ?>assets/img/blog/<?php echo $blog->image; ?>" alt="#">
                        </div>
                        <div class="blog-content">
                            <span class="cat"><?php echo $blog->category; ?></span>
                            <h4 class="blog-title"><?php echo $blog->title; ?></h4>
                            <div class="blog-date"><?php echo $blog->date_added; ?></div>
                        </div>
                    </a>
                </div>
            <?php  endforeach;    ?>


        </div>
    </div>
</section>
<!--Blog Section End-->
