<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<style>
    .radio-container input[type="radio"]:checked+.btn-default {
        border-color: #727272;
        background-color: #727272;
        color: #FFFFFF;
        transform: scale(1.1);
    }

    .radio-container input[type="radio"] {
        opacity: 0;
    }

    .d-none {
        display: none;
    }
</style>
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
                                    <label class="radio-container">
                                        <input class="form-check-input ml-2 report_type " name="report_type" type="radio" id="icon1" value="class_wise" <?php if (isset($report_type) && $report_type == 'class_wise') {
                                                                                                                                                            echo 'checked';
                                                                                                                                                        } ?>>
                                        <span class="btn  btn-default">Class Wise</span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="radio-container">
                                        <input class="form-check-input ml-2 report_type " name="report_type" type="radio" id="icon1" value="teacher_wise" <?php if (isset($report_type) && $report_type == 'teacher_wise') {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                        <span class="btn  btn-default">Teacher Wise</span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="radio-container">
                                        <input class="form-check-input ml-2 report_type" name="report_type" type="radio" id="icon1" value="subject_wise" <?php if (isset($report_type) && $report_type == 'subject_wise') {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                        <span class="btn  btn-default">Subject Wise</span>
                                    </label>
                                </div>

                            </div>
                            <span class="text-danger text-center"><?php echo form_error('report_type'); ?></span>
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('from_date'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="from_date" name="from_date" placeholder="" type="date" class="form-control" value="<?= @$from_date ?>" autocomplete="off">
                                        <span class="section_id_error text-danger"><?php echo form_error('from_date'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('to_date'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="to_date" name="to_date" placeholder="" type="date" class="form-control" value="<?= @$to_date ?>" autocomplete="off">
                                        <span class="section_id_error text-danger"><?php echo form_error('to_date'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2 d-none class-wise">
                                    <div class="form-group">

                                        <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
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
                                        <input type="hidden" id="lesson_subjectid" name="lesson_subjectid">
                                        <span class="class_id_error text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2 d-none class-wise">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select id="secid" name="section_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2 d-none teacher-wise">
                                    <div class="form-group">
                                        <label>Teacher</label><small class="req"> *</small>
                                        <select id="teacher_id" name="teacher_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($teacherlist as $teacherlists) {
                                            ?>
                                                <option <?php
                                                        if ($teacher_id == $teacherlists["id"]) {
                                                            echo "selected";
                                                        }
                                                        ?> value="<?php echo $teacherlists['id'] ?>"><?php echo $teacherlists['name'] . " " . $teacherlists['surname'] . " (" . $teacherlists['employee_id'] . ")"; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="teacher_id_error text-danger"><?php echo form_error('teacher_id'); ?></span>
                                    </div>
                                </div>

                                <!-- <div class="col-md-2 d-none subject-wise">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('subject_group'); ?></label><small class="req"> *</small>
                                        <select id="subject_group_id" name="subject_group_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($subjectgroup as $subjectgroups) {
                                            ?>
                                                <option value="<?php echo $subjectgroups['subject_id'] ?>"><?php echo $subjectgroups['name'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('subject_group_id'); ?></span>
                                    </div>
                                </div> -->
                                <div class="col-md-2 d-none subject-wise">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('subject'); ?></label>
                                        <select id="subject_id" name="subject_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($subjectlist as $subjects) {
                                            ?>
                                                <option value="<?php echo $subjects['id'] ?>"
                                                    <?php if ($subject_id == $subjects["id"]) {
                                                        echo "selected";
                                                    } ?>><?php echo $subjects['name'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('subject_id'); ?></span>

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm" style="margin-top: 21px;">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a href="<?= base_url() ?>/syallabusreport/index" type="reset" name="reset" value="reset_filter" class="btn btn-primary btn-sm" style=" margin-top: 21px;"><i class="fa fa-filter"></i> Reset</a>
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
                    $syllabusPerArray = $className = array();

                    if ($report_type == 'class_wise') {
                        foreach ($syallabusReport as $item) {
                            $date = $item['work_date'];
                            $subject = $item['subject_name'];
                            $syllabusPerArray[$subject] = $item['syllabus_percentage'];
                            $lesson = "Lesson-{$item['lesson_number']} {$item['lesson_name']}";
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
                    }


                    if ($report_type == 'teacher_wise') {

                        foreach ($teacherwisereport as $item) {
                            $date = $item['work_date'];
                            $subject = $item['subject_name'];
                            $syllabusPerArray[$subject] = $item['syllabus_percentage'];
                            $className[$subject] = $item['class_name'];
                            $lesson = "Lesson-{$item['lesson_number']} {$item['lesson_name']}";
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
                    }


                    if ($report_type == 'subject_wise') {
                        // echo "<pre>";
                        // print_r($classlist);
                        // die();
                        $subjectReport = $subjectWiseReport['subjectReport'];
                    }
                    ?>
                    <div class="table-responsive mailbox-messages overflow-visible">
                        <table class="table table-striped table-bordered table-hover example">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <?php


                                    if ($report_type == 'subject_wise') {
                                        $subjectdata = $subjectWiseReport['subjectdata'];
                                        foreach ($classlist as $class_list) {
                                            echo "<th>".$class_list['class']."</th>";
                                        }
                                    } else {
                                        foreach ($subjects as $subject) {
                                            echo "<th>{$subject}-<span class='text-green'>{$syllabusPerArray[$subject]} % </span><br><span class='text-warning'><b>{$className[$subject]}</b></span></th>";
                                        }
                                    }

                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($report_type == 'subject_wise') {
                                      foreach ($subjectReport as $date => $subjectreports) {
                                        echo "<tr>";
                                        echo "<td>$date</td>"; // Date Column

                                        foreach ($classlist as $class_list) {
                                            $class_id=$class_list['id'];
                                            if (isset($subjectreports[$class_id])) {
                                                $comp = $subjectreports[$class_id]['complete'];
                                                $tot = $subjectreports[$class_id]['totalstudent'];
                                                $incomp = $subjectreports[$class_id]['incomplete'];
                                                $percent = ($tot > 0) ? round(($comp / $tot) * 100, 2) : 0;
                                                echo "<td>Total: $tot <br> Complete: $comp <br> Incomplate: $incomp <br> Percentage: $percent %  </td>";
                                            } else {
                                                echo "<td>NA</td>"; // If subject not found in this date
                                            }
                                        }

                                        echo "</tr>";
                                    }
                                } else { ?>

                                    <?php foreach ($groupedData as $date => $subjectData) { ?>
                                        <tr>
                                            <td><?= $date ?></td>
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
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row col-md-12 slybuss_report" style="display: <?= ($report_type == 'class_wise') ? 'block' : 'none'; ?>;">
                        <div class="col-md-4">
                            <p><b><?= $this->lang->line('today_class_performance') ?></b></p>
                            <div class="subject-boxs">
                                <div><?= $get_winning_class['final_percentage'] ?>%</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p><b><?= $this->lang->line('today_winner_class') ?></b></p>
                            <div class="subject-boxs">
                                <div><?= $get_winning_class['final_class_name'] ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-12 slybuss_report" style="display: <?= ($report_type == 'subject_wise') ? 'block' : 'none'; ?>;">
                        <div class="col-md-4">
                            <p><b><?= $this->lang->line('today_subject_performance') ?><p><b>
                            <div class="subject-boxs">
                                <div><?= $get_winning_subjectwise['percentage'] ?>%</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p><b><?= $this->lang->line('today_winner_subject') ?><p><b>
                            <div class="subject-boxs">
                                <div><?= $get_winning_subjectwise['name'] ?></div>
                            </div>
                        </div>

                    </div>
                    <!-- Teacher Wise Report -->
                    <div class="row slybuss_report" style="display: <?= ($report_type == 'teacher_wise') ? 'flex' : 'none'; ?>; gap: 20px;">
                        <div class="col-md-4">
                            <p><b><?= $this->lang->line('today_marks') ?></b></p>
                            <div class="subject-boxs">
                                <div class="display-6"><?= $get_winning_teacher['percentage'] ?>%</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p><b><?= $this->lang->line('today_winner') ?></b></p>
                            <div class="subject-boxs">
                                <?php if ($get_winning_teacher['image'] != '') { ?>
                                    <img src="<?= $get_winning_teacher['image'] ?>" alt="Teacher Image" class="img-fluid rounded mb-2" height="100">
                                <?php } ?>
                                <div class="h5"><?= $get_winning_teacher['name'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>
<script>
    $(document).on('click', '.report_type', function() {
        let reportType = $(this).val();
        // alert('dd');
        radioButtonChecked(reportType)
    })

    function radioButtonChecked(reportType) {
        if (reportType == 'class_wise') {
            $('.class-wise').removeClass('d-none')
            $('.teacher-wise').addClass('d-none')
            $('.subject-wise').addClass('d-none')
        }
        if (reportType == 'teacher_wise') {
            $('.class-wise').addClass('d-none')
            $('.teacher-wise').removeClass('d-none')
            $('.subject-wise').addClass('d-none')
        }
        if (reportType == 'subject_wise') {
            $('.subject-wise').removeClass('d-none')
            $('.class-wise').addClass('d-none')
            $('.teacher-wise').addClass('d-none')
        }
    }



    $(document).ready(function(e) {

        radioButtonChecked('<?= $report_type ?>');

        getSectionByClass("<?php echo $class_id ?>", "<?php echo $section_id ?>", 'secid');
        getSubjectGroup("<?php echo $class_id ?>", "<?php echo $section_id ?>", "<?php echo $subject_group_id ?>", 'subject_group_id')
        getsubjectBySubjectGroup("<?php echo $class_id ?>", "<?php echo $section_id ?>", "<?php echo $subject_group_id ?>", "<?php echo $subject_id ?>", 'subid');
    });

    function getSectionByClass(class_id, section_id, select_control) {
        if (class_id != "") {
            $('#' + select_control).html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#' + select_control).addClass('dropdownloading');
                },
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#' + select_control).html(div_data);
                },
                complete: function() {
                    $('#' + select_control).removeClass('dropdownloading');
                }
            });
        }
    }


    $(document).on('change', '#secid', function() {
        var class_id = $('#searchclassid').val();
        var section_id = $(this).val();
        getSubjectGroup(class_id, section_id, 0, 'subject_group_id');
    });

    function getSubjectGroup(class_id, section_id, subjectgroup_id, subject_group_target) {
        if (class_id != "" && section_id != "") {

            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/subjectgroup/getGroupByClassandSection',
                data: {
                    'class_id': class_id,
                    'section_id': section_id
                },
                dataType: 'JSON',
                beforeSend: function() {
                    // setting a timeout
                    $('#' + subject_group_target).html("").addClass('dropdownloading');
                },
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var sel = "";
                        if (subjectgroup_id == obj.subject_group_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.subject_group_id + " " + sel + ">" + obj.name + "</option>";
                    });
                    $('#' + subject_group_target).html(div_data);
                },
                error: function(xhr) { // if error occured
                    alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

                    
                },
                complete: function() {
                    $('#' + subject_group_target).removeClass('dropdownloading');
                }
            });
        }
    }

    $(document).on('change', '#subject_group_id', function() {
        var class_id = $('#searchclassid').val();
        var section_id = $('#secid').val();
        var subject_group_id = $(this).val();
        getsubjectBySubjectGroup(class_id, section_id, subject_group_id, 0, 'subid');
    });

    function getsubjectBySubjectGroup(class_id, section_id, subject_group_id, subject_group_subject_id, subject_target) {
        if (class_id != "" && section_id != "" && subject_group_id != "") {
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/subjectgroup/getGroupsubjects',
                data: {
                    'subject_group_id': subject_group_id
                },
                dataType: 'JSON',
                beforeSend: function() {
                    // setting a timeout
                    $('#' + subject_target).html("").addClass('dropdownloading');
                },
                success: function(data) {
                    console.log(data);
                    $.each(data, function(i, obj) {
                        var sel = "";
                        if (subject_group_subject_id == obj.id) {
                            sel = "selected";
                        }

                        var code = '';
                        if (obj.code) {
                            code = " (" + obj.code + ") ";
                        }

                        div_data += "<option value=" + obj.subject_id + " " + sel + ">" + obj.name + code + "</option>";
                    });
                    $('#' + subject_target).html(div_data);
                },
                error: function(xhr) { // if error occured
                    alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

                },
                complete: function() {
                    $('#' + subject_target).removeClass('dropdownloading');
                }
            });
        }
    }
</script>