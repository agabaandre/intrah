
            <!--Main Start-->

                <div class="blog-page">
                    <div class="">
                        <img src="<?php echo base_url(); ?>assets/img/blog/<?php echo $blog->image; ?>" height="10px" style="max-height: 400px" alt="#">
                    </div>
                    </a>
                    <div class="blog-container">
                        <div class="row">

                            <!--Blog Heading Start-->
                            <div class="blog-heading col-md-8 offset-md-2">
                                <span class="cat"><?php echo $blog->category; ?></span>
                                <h1><?php echo $blog->title; ?></h1>

                                <span class="blog-date" ><?php echo $blog->date_added; ?></span>
                            </div>
                            <!--Blog Heading Start-->

                            <!--Blog Content Start-->
                            <span style="color: blue;"><a href="<?php echo base_url(); ?>my-blog" class="pt-link pull-right"><small>Go back to Blogs</small></a></span>
                            <div class="blog-content col-md-10 offset-md-1">
                                <blockquote>
                                   <?php echo $blog->highlight; ?>
                                </blockquote>

                                <p align=”justify”><?php echo $blog->desc; ?></p>
                                <hr style="background-color: white;"/>
                            </div>
                            <!--Blog Content End-->

                            <div class="comment-form col-lg-8 offset-lg-2">

                                <center><span class="mb-40">Would you Like to comment about This Post, you can please Leave a message</h4></span>
                                <form action="#">

                                    <div class="row">
                                        <!--Name Field-->
                                        <div class="col-md-6 mb-50">
                                            <span class="input">
                                                <input class="input__field" type="text" id="name" name="name" required/>
                                                <label class="input__label" for="name">Name</label>
                                            </span>
                                        </div>

                                        <!--Email Field-->
                                        <div class="col-md-6 mb-50">
                                            <span class="input">
                                                <input class="input__field" type="text" id="email" name="email" required/>
                                                <label class="input__label" for="email">Email</label>
                                            </span>
                                        </div>

                                        <!--Message Box-->
                                        <div class="col-md-12 mb-30">
                                            <span class="input">
                                                <textarea  class="input__field" id="message" name="message" rows="5" required></textarea>
                                                <label class="input__label" for="message">Your Comment</label>
                                            </span>
                                        </div>

                                        <!--Submit Button-->
                                        <div class="col-md-12">
                                            <button class="btn-main">Post Comment</button>
                                        </div>
                                        <div><br></div>

                                    </div>

                                </form>

                            </div>

                        </div>
                    </div>
                </div>

    
