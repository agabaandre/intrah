<!--Resume Section Start-->
<section id="resume" class="resume-section pt-page">
    <div class="section-container">
        <div class="page-heading">
            <span class="icon"><i class="lnr lnr-license"></i></span>
            <h2>My Resume.</h2>
        </div>

        <!--Education & Experience Row Start-->
        <div class="row mb-20">

            <!--Experience Column Start-->
            <div class="col-lg-6">
                <div class="subheading">
                    <h3>Work Experience</h3>
                </div>
                <ul class="experience">

                    <!--Experience Item-->
                    <?php foreach ($experiences as $experience) { ?>
                        <li>
                            <span class="line-left"></span>
                            <div class="content">
                                <h4><?php echo $experience->title; ?></h4>
                                <h5><?php echo $experience->institution; ?></h5>
                                <p class="info">
                                   <small><?php echo $experience->desc; ?></small>
                                </p>
                            </div>
                            <span class="year">
                                <span class="to"><?php echo $experience->to; ?></span>
                                <span class="from"><?php echo $experience->from; ?></span>
                            </span>
                        </li>
                    <?php } ?>

                </ul>
            </div>
            <!--Experience Column End-->

            <!--Education Column Start-->
            <div class="col-lg-6">
                <div class="subheading">
                    <h3>Education</h3>
                </div>

                <ul class="education">

                    <!--Education Item-->
                    <?php foreach ($academics as $academic) { ?>
                        <li>
                            <span class="line-left"></span>
                            <div class="content">
                                <h4><?php echo $academic->title; ?></h4>
                                <h5><?php echo $academic->institution; ?></h5>
                                <p class="info">
                                    <small><?php echo $academic->desc; ?></small>
                                </p>
                            </div>
                            <span class="year">
                                <span class="to"><?php echo $academic->to; ?></span>
                                <span class="from"><?php echo $academic->from; ?></span>
                            </span>
                        </li>
                    <?php } ?>

                </ul>
            </div>
            <!--Education Column End-->

        </div>
        <!--Education & Experience Row End-->


        <!--Skills Rows Start-->
        <div class="row col-lg-12">

            <?php if ($ProgramingSkills == true) { ?>
                <!--Coding Skills Column Start-->
                <div class="col-md-6 skills">
                    <div class="subheading">
                        <h3>Coding Skills</h3>
                    </div>

                    <!--Coding Skill Item-->
                    <?php foreach ($ProgramingSkills as $skill) { ?>        
                        
                        <div class="skill-item">
                            <h4 class="progress-title"><?php echo $skill->title; ?></h4>
                            <div class="progress">
                                <div class="progress-bar" data-progress-value="<?php echo $skill->level; ?>">
                                    <div class="progress-value"><?php echo $skill->level; ?>%</div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <!--Coding Skills Column End-->
            <?php } ?>

            <?php if ($FrameworkSkills == true) { ?>
                <!--Framework Skills Column Start-->
                <div class="col-md-6 skills">
                    <div class="subheading">
                        <h3>Frameworks Skills</h3>
                    </div>

                    <!--Framework Skill Item-->
                    <?php foreach ($FrameworkSkills as $skill) { ?>        
                        
                        <div class="col-md-12">
                            <center><span><?php echo $skill->desc; ?></span></center>
                        </div>
                    <?php } ?>

                </div>
                <!--Framework Skills Column End-->
            <?php } ?>

            <?php if ($DesignSkills == true) { ?>
                <!--Design Skills Column Start-->
                <div class="col-md-6 skills">
                    <div class="subheading">
                        <h3>Design Skills</h3>
                    </div>

                    <!--Design Skill Item-->
                    <?php foreach ($DesignSkills as $skill) { ?> 

                        <div class="col-md-12">
                            <center><span><?php echo $skill->desc; ?></span></center>
                        </div>       
                        
                    <?php } ?>

                </div>
                <!--Design Skills Column End-->
            <?php } ?>

            <?php if ($OtherSkills == true) { ?>
                
                <!--Other Skills Column Start-->
                <div class="col-md-6 skills">
                    <div class="subheading">
                        <h3>Other Skills</h3>
                    </div>

                    <!--Other Skill Item-->
                    <?php foreach ($OtherSkills as $skill) { ?>        
                        <div class="col-md-12">
                            <center><span><?php echo $skill->desc; ?></span></center>
                        </div> 
                    <?php } ?>

                </div>
                <!--Other Skills Column End-->
            <?php } ?>

        </div>
    </div>
        <!--Skills Row End-->
    </div>
</section>
<!--Resume Section End-->



