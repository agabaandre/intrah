<!--Banner Section Start-->
<section id="home" class="banner-section pt-page" style="background-image: url('<?php echo base_url(); ?>assets/img/home/<?php echo $home_data->image; ?>')">

    <div class="banner-content">
        <!--Banner Text-->
        <h1 class="mb-20"><?php echo $home_data->fname; ?> <span><?php echo $home_data->lname; ?></span></h1>

        <!--Animated Text-->
        <center><p class="cd-headline clip is-full-width">
        <span>I am a </span>
        <span class="cd-words-wrapper">
            <b class="is-visible"><?php echo $home_data->skill1; ?></b>
            <b><?php echo $home_data->skill2; ?></b>
            <b><?php echo $home_data->skill3; ?></b>
            <b><?php echo $home_data->skill4; ?></b>
        </span>
        </p></center>

    </div>

</section>
<!--Banner Section End-->