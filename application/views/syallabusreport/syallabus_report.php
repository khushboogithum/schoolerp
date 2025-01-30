<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <!-- <h3 class="box-title"><?php //echo $this->lang->line('syllabus_report'); 
                                                    ?></h3> -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" action="<?php echo base_url('syallabusreport/index'); ?>">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('class_wise'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="searchclassid" name="class_id" onchange="getSectionByClass(this.value, 0, 'secid')" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                                foreach ($classlist as $class) {
                                                ?>
                                                    <option <?php
                                                            if ($class_id == $class["id"]) {
                                                                echo "selected";
                                                            }
                                                            ?> value="<?php echo $class['id'] ?>"><?php echo $class['class'] ?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                        <span class="class_id_error text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('teacher_wise'); ?></label><small class="req"> *</small>
                                        <select id="subject_group_id" name="subject_group_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('subject_group_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('subject_wise'); ?></label><small class="req"> *</small>
                                        <select id="subid" name="subject_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('subject_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('from_date'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="from_date" name="from_date" placeholder="" type="date" class="form-control" value="" autocomplete="off">
                                        <span class="section_id_error text-danger"><?php echo form_error('from_date'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('to_date'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="to_date" name="to_date" placeholder="" type="date" class="form-control" value="" autocomplete="off">
                                        <span class="section_id_error text-danger"><?php echo form_error('to_date'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm" style="margin-top: 21px;">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a href="<?= base_url() ?>/todaysworkreport/index" type="reset" name="reset" value="reset_filter" class="btn btn-primary btn-sm" style=" margin-top: 21px;"><i class="fa fa-filter"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header ptbnull">
                    <h3 class="box-title titlefix"><?php echo $this->lang->line('syallabus_report'); ?></h3>

                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php 

                    $groupedData = [];
                    $subjects = [];
                    //  echo "<pre>";
                    // print_r($syallabusReport);
                    // die();
                    $syllabusPerArray=array();
                    foreach ($syallabusReport as $item) {
                        $date = $item['work_date'];
                        $subject = $item['subject_name'];
                        $syllabusPerArray[$subject] = $item['syllabus_percentage'];
                        $lesson = "Lesson-{$item['lesson_number']} {$item['lesson_name']}";
                        
                        // Include class work, each on a new line
                        $classWork = [];
                        foreach ($item['class_work'] as $cw) {
                            $classWork[] = $cw['teaching_activity_title'];
                        }
                        $lessonWithClassWork = $lesson . "<br>" . implode("<br>", $classWork);

                        $groupedData[$date][$subject][] = $lessonWithClassWork;
                        if (!in_array($subject, $subjects)) {
                            $subjects[] = $subject;
                        }
                    }
                    sort($subjects);
                   
                    
                    
                    
                    
                    ?>
                    <div class="table-responsive mailbox-messages overflow-visible">
                        <table class="table table-striped table-bordered table-hover example">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <?php 
                                    foreach ($subjects as $subject) {
                                        echo "<th>{$subject}<br>{$syllabusPerArray[$subject]} %</th>";
                                    }                                    
                                    
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($groupedData as $date => $subjectData) { ?>
                                <tr>
                                    <td><?=$date ?></td>
                                <?php
                                    foreach ($subjects as $subject) {
                                        echo '<td>';
                                            if (isset($subjectData[$subject])) {
                                                echo implode('<br>', $subjectData[$subject]);
                                            } else {
                                                echo 'NA';
                                            }
                                            echo '</td>';
                                    }
                                    ?>
                                    
                                </tr>
                                <?php } ?>
                                <!-- <tr>
                                    <td>20-01-2025</td>
                                    <td>
                                        <div>Lesson-4 Bad man</div>
                                        <div>Explanation</div>
                                        <div>One page writing</div>
                                    </td>
                                    <td>
                                        <div>Lesson-1 English lesson</div>
                                        <div>Copy Writing</div>
                                        <div>One page writing</div>
                                    </td>
                                    <td>
                                        <div>Lesson-4 Math lesson</div>
                                        <div>Fair Writing</div>
                                        <div>One page writing</div>
                                    </td>
                                    <td>
                                        <div>Lesson-1 Science lesson</div>
                                        <div>Fair Writing</div>
                                        <div>One page writing</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>25-01-2025</td>
                                    <td>
                                        <div>Lesson-3 Bad man</div>
                                        <div>Explanation</div>
                                        <div>One page writing</div>
                                    </td>
                                    <td>
                                        <div>Lesson-2 English lesson</div>
                                        <div>Copy Writing</div>
                                        <div>One page writing</div>
                                    </td>
                                    <td>
                                        <div>Lesson-4 Math lesson</div>
                                        <div>Fair Writing</div>
                                        <div>One page writing</div>
                                    </td>
                                    <td>
                                        <div>Lesson-1 Science lesson</div>
                                        <div>Fair Writing</div>
                                        <div>One page writing</div>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                    <div class="subject-grids">
                    <div>Today Class Performance</div>
                        <div class="subject-boxs">
                            <div>90%</div>
                        </div>
                        <div>Today Winner Class</div>
                        <div class="subject-boxs">
                            <div>First</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>