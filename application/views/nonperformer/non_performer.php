<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<style>
    .subject-grid {
        padding: 10px;
        /* border: 1px solid gray; */
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .subject-box {
        padding: 8px;
        border: 1px solid #000;
        text-align: center;
        width: 100px;
        border-radius: 5px;
        min-height: 35px;
    }

    .sub-color {
        background-color: #136b23d9;
        color: white;
    }

</style>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            //   if ($this->rbac->hasPrivilege('class', 'can_add')) {
            ?>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('class_wise_non_performer'); ?></h3>
                    </div>
                    <div class="subject-grid">
                        <?php
                        // echo "<pre>"; print_r($classlist);
                        foreach ($classlist as $key => $classlists) { ?>
                            <a href="?class_id=<?=$classlists['id'] ?>" style="text-decoration:none; color:#000000">
                                <span class="ml-2"><?= $classlists['class'] ?></span>
                                <div class="subject-box d-flex <?php echo $classPercentage[$classlists['id']] ? 'sub-color' : '' ?>">
                                    <?= $classPercentage[$classlists['id']] ?>
                                </div>
                            </a>
                        <?php  } ?>

                        <!-- <div>
                                <span class="ml-2">Class K.G</span>
                                <div class="subject-box d-flex">
                                     84.21%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 2</span>
                                <div class="subject-box d-flex" >
                                     78.95%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 4</span>
                                <div class="subject-box d-flex">
                                     95%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 6</span>
                                <div class="subject-box d-flex">
                                     90%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 8</span>
                                <div class="subject-box d-flex">
                                     92%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 10</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 12</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class Nursery</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 1</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 2</span>
                                <div class="subject-box d-flex">
                                     90%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 5</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 7</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 9</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 11</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div> -->
                    </div>
                </div>

            </div>
            <?php //} 
            ?>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages overflow-visible">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('admission_number'); ?></th>
                                        <th><?php echo $this->lang->line('roll_no'); ?></th>
                                        <th><?php echo $this->lang->line('student_name'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('section'); ?></th>
                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                        <th><?php echo $this->lang->line('mother_name'); ?></th>
                                        <th><?php echo $this->lang->line('mobile_number'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach($nonPerformerStudent as $key=>$student){
                                            $url="/schoolerp/ptmreport/index?class_id=".$student['class_id']."&section_id=".$student['section_id']."&student_id=".$student['id']."&from_date=".date("Y-m-d")."&to_date=".date('Y-m-d');
                                        
                                    ?>
                                    <tr>
                                        <td><?=$student['admission_no'] ?></td>
                                        <td><?=$student['roll_no'] ?></td>
                                        <td><a href="<?=$url ?>"><?=$student['firstname'] ?></a></td>
                                        <td><?=$student['class'] ?></td>
                                        <td><?=$student['section'] ?></td>
                                        <td><?=$student['father_name'] ?></td>
                                        <td><?=$student['mother_name'] ?></td>
                                        <td><?=$student['mobileno'] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <h4 class="box-title titlefix"><?php echo $this->lang->line('subject_wise_performance'); ?></h4>
                        </div>
                        <div class="subject-grid">
                            <?php
                            foreach ($subjectPercentage as $subjectPercentages) { ?>
                                <div>
                                    <span class="ml-2"><?= $subjectPercentages['subject_name'] ?></span>
                                    <div class="subject-box d-flex">
                                        <?= $subjectPercentages['subject_percentage'] ?>%
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- <div>
                                <span class="ml-2">Mathmatics</span>
                                <div class="subject-box d-flex">
                                    84.21%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Hindi</span>
                                <div class="subject-box d-flex">
                                    78.95%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Science</span>
                                <div class="subject-box d-flex">
                                    95%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">SST</span>
                                <div class="subject-box d-flex">
                                    90%
                                </div>
                            </div>

                            <div>
                                <span class="ml-2">Drawing</span>
                                <div class="subject-box d-flex">
                                    92%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Computer</span>
                                <div class="subject-box d-flex">
                                    70%
                                </div>
                            </div> -->
                        </div>

                        <button type="submit" class="btn btn-info pull-right" style="margin-top:2%;margin-right: 10px;"><?php echo $this->lang->line('message'); ?></button>
                        <button type="submit" class="btn btn-info pull-right" style="margin-top:2%;margin-right: 10px;"><?php echo $this->lang->line('email'); ?></button>
                        <button type="submit" class="btn btn-info pull-right" style="margin-top:2%;margin-right: 10px;"><?php echo $this->lang->line('whatsapp'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>