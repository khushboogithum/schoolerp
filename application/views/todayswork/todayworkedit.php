<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
 <style>
.readonly-select {
    pointer-events: none;
    background-color:rgb(235, 239, 243);
    color: #495057;
    cursor: not-allowed;

}
 </style>   
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            // if ($this->rbac->hasPrivilege('todayswork', 'can_add')) {
            ?>
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('todays_work_syllubus_report'); ?></h3>
                    </div><!-- /.box-header -->
                    <form id="form1" action="<?php echo site_url('todayswork/edit/' . $today_work_id); ?>" method="post" accept-charset="utf-8">
                    <div class="box-body">
                            <?php
                            if ($this->session->flashdata('msg')) {
                                echo $this->session->flashdata('msg');
                                $this->session->unset_userdata('msg');
                            }
                            ?>

                            <?php
                            if (isset($error_message)) {
                                echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                            }
                            ?>
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('todays_date'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="work_date" name="work_date" placeholder="" type="date" class="form-control readonly-select" value="<?php echo $work_date; ?>" />
                                        <span class="text-danger"><?php echo form_error('work_date'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="searchclassid" name="class_id" onchange="getSectionByClass(this.value, 0, 'secid')" class="form-control readonly-select">
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
                                        <label><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select id="secid" name="section_id" class="form-control readonly-select">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('subject_group'); ?></label><small class="req"> *</small>
                                        <select id="subject_group_id" name="subject_group_id" class="form-control readonly-select">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>

                                        </select>
                                        <span class="subject_group_id_error text-danger"><?php echo form_error('subject_group_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('subject'); ?></label><small class="req"> *</small>
                                        <select id="subid" name="subject_id" class="form-control readonly-select">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="subject_id_error text-danger"><?php echo form_error('subject_id'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('lesson_no'); ?></label><small class="req"> *</small>
                                        <select id="lesson_number" name="lesson_number" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="lesson_number_error text-danger"><?php echo form_error('lesson_number'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('lesson_name'); ?></label><small class="req"> *</small>
                                        <select id="lesson_name" name="lesson_name" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('lesson_name'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class_work'); ?></label><small class="req"> *</small><br>
                                        <select id="teaching_activity_id" name="teaching_activity_id[]" multiple class="form-control select2">

                                            <?php
                                            if (!empty($teachingClassWork)) {
                                                foreach ($teachingClassWork as $classwork) { ?>
                                                    <option value="<?php echo $classwork['teaching_activity_id']; ?>"
                                                        <?php
                                                        if (!empty($teaching_activity_id) && in_array($classwork['teaching_activity_id'], explode(',', $teaching_activity_id))) {
                                                            echo "selected";
                                                        }
                                                        ?>>
                                                        <?php echo $classwork['teaching_activity_title']; ?>
                                                    </option>
                                            <?php }
                                            } else {
                                                echo "<option value=''>No Teaching Activities Found</option>";
                                            } ?>

                                        </select>
                                        <span class="text-danger"><?php echo form_error('teaching_activity_id[]'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class_work_note_book'); ?></label><small class="req"> *</small><br>
                                        <select id="note_book_type_id" name="note_book_type_id[]" multiple class="form-control select2">
                                        <?php
                                            if (!empty($todays_class_notebook)) {
                                                foreach ($todays_class_notebook as $classNoteBook) { ?>
                                                    <option value="<?php echo $classNoteBook['note_book_type_id']; ?>"
                                                        <?php
                                                        if (!empty($note_book_type_id) && in_array($classNoteBook['note_book_type_id'], explode(',', $note_book_type_id))) {
                                                            echo "selected";
                                                        }
                                                        ?>>
                                                        <?php echo $classNoteBook['note_book_title']; ?>
                                                    </option>
                                            <?php }
                                            } else {
                                                echo "<option value=''>No note book Found</option>";
                                            } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('note_book_type_id[]'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('home_work'); ?></label><small class="req"> *</small><br>
                                        <select id="teaching_activity_home_work_id" name="teaching_activity_home_work_id[]" multiple class="form-control select2">
                                        <?php
                                            if (!empty($teachingClassWork)) {
                                                foreach ($teachingClassWork as $classwork) { ?>
                                                    <option value="<?php echo $classwork['teaching_activity_id']; ?>"
                                                        <?php
                                                        if (!empty($homework_teaching_activity_id) && in_array($classwork['teaching_activity_id'], explode(',', $homework_teaching_activity_id))) {
                                                            echo "selected";
                                                        }
                                                        ?>>
                                                        <?php echo $classwork['teaching_activity_title']; ?>
                                                    </option>
                                            <?php }
                                            } else {
                                                echo "<option value=''>No Teaching Activities Found</option>";
                                            } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('teaching_activity_home_work_id[]'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('home_work_note_book'); ?></label><small class="req"> *</small><br>
                                        <select id="note_book_type_id_home_work" name="note_book_type_id_home_work[]" multiple class="form-control select2">
                                        <?php
                                            if (!empty($todays_homework_notebook)) {
                                                foreach ($todays_homework_notebook as $homeNoteBook) { ?>
                                                    <option value="<?php echo $homeNoteBook['note_book_type_id']; ?>"
                                                        <?php
                                                        if (!empty($homework_note_book_type_id) && in_array($homeNoteBook['note_book_type_id'], explode(',', $homework_note_book_type_id))) {
                                                            echo "selected";
                                                        }
                                                        ?>>
                                                        <?php echo $homeNoteBook['note_book_title']; ?>
                                                    </option>
                                            <?php }
                                            } else {
                                                echo "<option value=''>No note book Found</option>";
                                            } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('note_book_type_id_home_work[]'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right" style="margin-left:5px !important;"><?php echo $this->lang->line('update'); ?></button>
                        </div>
                    </form>
                </div>

            </div>
            <?php //}
            ?>
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix" style="margin-left: 35%;"><?php echo $this->lang->line('todays_work_syllubus_report'); ?></h3>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive mailbox-messages ">
                            <table class="table table-striped table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('subject'); ?></th>
                                        <th><?php echo $this->lang->line('total_lesson'); ?></th>
                                        <th><?php echo $this->lang->line('now_going_on'); ?></th>
                                        <th><?php echo $this->lang->line('class_work'); ?></th>
                                        <th><?php echo $this->lang->line('home_work'); ?></th>
                                        <th><?php echo $this->lang->line('syllabus_percentage'); ?></th>
                                        <!-- <th><?php echo $this->lang->line('action'); ?></th> -->

                                    </tr>
                                </thead>
                                <!-- <tbody>
                                    <?php

                                    $todayWorkId = $todaysWork[0]['today_work_id'];
                                    $classid = $todaysWork[0]['class_id'];
                                    $subjectname = $todaysWork[0]['subject_name'];
                                    $subjectid = $todaysWork[0]['subject_id'];
                                    //$classSubjectID='?class_id='.$classid.'&subject_name='.$subjectname.'&subject_id='.$subjectid;

                                    if (!empty($todaysWork)) {
                                        foreach ($todaysWork as $todayLists) {
                                    ?>
                                            <tr>
                                                <td><?= $todayLists['subject_name'] ?></td>
                                                <td><?= $todayLists['total_lessons'] ?></td>
                                                <td>Lesson-<?= $todayLists['lesson_number'] ?> <?= $todayLists['lesson_name'] ?></td>
                                                <td>
                                                    <?php
                                                    $class_work = $todayLists['class_work'];
                                                    foreach ($class_work as $class_works) {
                                                        echo "<div><b>" . ucfirst($class_works['teaching_activity_title']) . "</b></div>";
                                                    }
                                                    $class_notebook = $todayLists['class_notebook'];
                                                    foreach ($class_notebook as $class_notebooks) {
                                                        echo "<div>" . ucfirst($class_notebooks['note_book_title']) . "</div>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $home_work = $todayLists['home_work'];
                                                    foreach ($home_work as $home_works) {
                                                        echo "<div><b>" . ucfirst($home_works['teaching_activity_title']) . "</b></div>";
                                                    }
                                                    $home_notebook = $todayLists['home_notebook'];
                                                    foreach ($home_notebook as $home_notebooks) {
                                                        echo "<div>" . ucfirst($home_notebooks['note_book_title']) . "</div>";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $todayLists['syllabus_percentage'] ?>%</td>
                                                <td>
                                                    <a href="<?php echo base_url(); ?>todayswork/edit/<?php echo $todayLists['today_work_id']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else { ?>
                                        <tr class="odd">
                                            <td valign="top" colspan="8" class="dataTables_empty">
                                                <div align="center">No data available in table <br> <br><img src="https://smart-school.in/ssappresource/images/addnewitem.svg" width="150"><br><br> <span class="text-success bolds"><i class="fa fa-arrow-left"></i> Add new record or search with different criteria.</span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody> -->
                                <tbody>
                                    <?php
                                   
                                   
                                    $todayWorkId = $todaysWork[0]['today_work_id'];
                                    $classid = $todaysWork[0]['class_id'];
                                    $subjectname = $todaysWork[0]['subject_name'];
                                    $subjectid = $todaysWork[0]['subject_id'];
                                    //$classSubjectID='?class_id='.$classid.'&subject_name='.$subjectname.'&subject_id='.$subjectid;
                                    $subjectArray=$todayWorkArray=array();
                                    if (!empty($todaysWork)) {
                                        foreach ($todaysWork as $todayLists) {
                                            $subjectArray[]=$todayLists['subject_id'];
                                            $todayWorkArray[]=$todayLists['today_work_id'];

                                    ?>
                                            <tr>
                                                <td><?= $todayLists['subject_name'] ?></td>
                                                <td><?= $todayLists['total_lessons'] ?></td>
                                                <td>Lesson-<?= $todayLists['lesson_number'] ?> <?= $todayLists['lesson_name'] ?></td>
                                                <td>
                                                    <?php
                                                    $class_work = $todayLists['class_work'];
                                                    foreach ($class_work as $class_works) {
                                                        echo "<div><b>" . ucfirst($class_works['teaching_activity_title']) . "</b></div>";
                                                    }
                                                    $class_notebook = $todayLists['class_notebook'];
                                                    foreach ($class_notebook as $class_notebooks) {
                                                        echo "<div>" . ucfirst($class_notebooks['note_book_title']) . "</div>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $home_work = $todayLists['home_work'];
                                                    foreach ($home_work as $home_works) {
                                                        echo "<div><b>" . ucfirst($home_works['teaching_activity_title']) . "</b></div>";
                                                    }
                                                    $home_notebook = $todayLists['home_notebook'];
                                                    foreach ($home_notebook as $home_notebooks) {
                                                        echo "<div>" . ucfirst($home_notebooks['note_book_title']) . "</div>";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $todayLists['syllabus_percentage'] ?>%</td>
                                                <!-- <td>
                                                    <a href="<?php echo base_url(); ?>todayswork/edit/<?php echo $todayLists['today_work_id']; ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                </td> -->
                                            </tr>
                                        <?php
                                        }
                                    } else { ?>
                                        <tr class="odd">
                                            <td valign="top" colspan="8" class="dataTables_empty">
                                                <div align="center">No data available in table <br> <br><img src="https://smart-school.in/ssappresource/images/addnewitem.svg" width="150"><br><br> <span class="text-success bolds"><i class="fa fa-arrow-left"></i> Add new record or search with different criteria.</span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php  if (!empty($todaysWork)) { ?>
                        <!-- <form id="form1" action="<?php echo site_url('todayswork/todayStudentWorkReportEdit'); ?>" method="post" accept-charset="utf-8"> -->
                        <form id="form1" action="<?php echo site_url('todayswork/todayStudentWorkReportEdit'); ?>" method="get" accept-charset="utf-8">
                            <input type="hidden" class="form-control" name="subject_id" value="<?=implode(",",$subjectArray)?>"/>
                            <input type="hidden" class="form-control" name="today_work_id" value="<?=implode(",",$todayWorkArray)?>"/>
                            <input type="hidden" class="form-control" name="class_id" value="<?=$todaysWork[0]['class_id']?>"/>
                            <div> <button type="submit"  class="btn btn-info pull-right" style="margin-left:5px !important;"><?php echo $this->lang->line('go_for_student_work_report'); ?></button></div><br><br>
                        </form>
                        <!-- <div><a href="<?php echo site_url('todayswork/studentworkreport'); ?><?=$classSubjectID?>" class="btn btn-info pull-right" style="margin-left:5px !important;"><?php echo $this->lang->line('go_for_student_work_report'); ?></a></div> -->
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        const selectors = [
            '#teaching_activity_id',
            '#note_book_type_id',
            '#teaching_activity_home_work_id',
            '#note_book_type_id_home_work'
        ];

        selectors.forEach(selector => {
            if ($(selector).length) {
                $(selector).SumoSelect({
                    placeholder: "<?php echo $this->lang->line('select'); ?>",
                    allowClear: true,
                    selectAll: true
                });
                console.log(`${selector} initialized`);
            } else {
                console.warn(`${selector} not found in DOM`);
            }
        });
    });
</script>

<script>
    $(document).ready(function(e) {

        getSectionByClass("<?php echo $class_id ?>", "<?php echo $section_id ?>", 'secid');
        getSubjectGroup("<?php echo $class_id ?>", "<?php echo $section_id ?>", "<?php echo $subject_group_id ?>", 'subject_group_id')
        getsubjectBySubjectGroup("<?php echo $class_id ?>", "<?php echo $section_id ?>", "<?php echo $subject_group_id ?>", "<?php echo $subject_id ?>", 'subid');
        getLessionBySubject("<?php echo $subject_id ?>", "<?php echo $class_id ?>", "<?= $lesson_number ?>");
        getLessionNameById("<?= $lesson_id ?>", "<?= $lesson_name ?>");
        var selectedTeachingActivityIds = "<?= $teaching_activity_id ?>".split(',');

        // Load Class Notebooks based on pre-selected teaching activity
       // getClassNoteBook(selectedTeachingActivityIds, "<?= $note_book_type_id ?>");


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
            // alert(subject_group_subject_id);
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
                        if (subject_group_subject_id == obj.subject_id) {
                            // alert('hii');
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


    $(document).on('change', '#subid', function() {

        var subid = $('#subid').val();
        let class_id = $('#searchclassid').val();
        getLessionBySubject(subid, class_id, '');

    });

    function getLessionBySubject(subid, class_id, lession_id) {

        var div_lession_no = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        // var div_lession_name = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({
            type: 'POST',
            url: base_url + 'todayswork/getlessionData',
            data: {
                'subject_id': subid,
                'class_id': class_id,
            },
            dataType: 'JSON',
            beforeSend: function() {
                // setting a timeout
                $('#lesson_number').html("").addClass('dropdownloading');
            },
            success: function(data) {
                // console.log(data);
                $.each(data, function(i, obj) {
                    var sel = "";
                    if (lession_id == obj.lesson_number) {
                        // alert('hii');
                        sel = "selected";
                    }

                    div_lession_no += "<option value=" + obj.lesson_id + " " + sel + ">" + obj.lesson_number + "</option>";

                });
                $('#lesson_number').html(div_lession_no);
            },
            error: function(xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

            },
            complete: function() {
                $('#lesson_number').removeClass('dropdownloading');
                // $('#lesson_name').removeClass('dropdownloading');
            }
        });
    }


    $(document).on('change', '#lesson_number', function() {
        var lesson_number = $('#lesson_number').val();
        getLessionNameById(lesson_number, '');

    });

    function getLessionNameById(lesson_id, lesson_name) {
        var div_lession_name = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({

            type: 'POST',
            url: base_url + 'todayswork/getlessionDataByLessionId',
            data: {
                'lesson_id': lesson_id
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('#lesson_name').html("").addClass('dropdownloading');
            },
            success: function(data) {
                //console.log(data);
                $.each(data, function(i, obj) {
                    var sel = "";
                    if (lesson_name == obj.lesson_name) {
                        sel = "selected";
                    }
                    div_lession_name += "<option value=" + obj.lesson_name + " " + sel + ">" + obj.lesson_name + "</option>";
                });
                $('#lesson_name').html(div_lession_name);
            },
            error: function(xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

            },
            complete: function() {
                $('#lesson_name').removeClass('dropdownloading');
            }
        });
    }
    // $('#teaching_activity_id').on('change', function() {
    //     var teaching_activity_id = [];
    //     $("#teaching_activity_id option:selected").each(function() {
    //         teaching_activity_id.push($(this).val());
    //     });

    //     getClassNoteBook(teaching_activity_id, '');
    // });

    // function getClassNoteBook(teaching_activity_id, note_book_type_id) {
    //     var note_book = '';

    //     $.ajax({
    //         type: 'POST',
    //         url: base_url + 'todayswork/getNotebooksByClasswork',
    //         data: {
    //             'teaching_activity_id': teaching_activity_id
    //         },
    //         dataType: 'JSON',
    //         beforeSend: function() {
    //             // $('#note_book_type_id').html("").addClass('dropdownloading');
    //         },
    //         success: function(data) {

    //             $.each(data, function(i, obj) {
    //                 var selectedIds = note_book_type_id ? note_book_type_id.split(',') : [];
    //                 var sel = selectedIds.includes(obj.note_book_type_id) ? "selected" : "";
    //                 // console.log(sel);

    //                 note_book += "<option value='" + obj.note_book_type_id + "' " + sel + ">" + obj.note_book_title + "</option>";
    //             });

    //             $('#note_book_type_id').html(note_book);

    //             setTimeout(function() {
    //                 $('#note_book_type_id')[0].sumo.reload();
    //                 $('.sumo_note_book_type_id').find('.CaptionCont').removeClass('SumoUnder');
    //             }, 100);
    //         },
    //         error: function(xhr) {
    //             alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
    //         }
    //     });
    // }
      
    $('#teaching_activity_id').on('change', function() {
        var teaching_activity_id = [];
        $("#teaching_activity_id option:selected").each(function() {
            teaching_activity_id.push($(this).val());
        });  
        var note_book = '';
        $.ajax({
            type: 'POST',
            url: base_url + 'todayswork/getNotebooksByClasswork',
            data: {
                'teaching_activity_id': teaching_activity_id
            },
            dataType: 'JSON',
            beforeSend: function() {
                // $('#note_book_type_id').html("").addClass('dropdownloading');
            },
            success: function(data) {
                // console.log(data);
                $.each(data, function(i, obj) {
                    var sel = "";
                    if (note_book_type_id == obj.note_book_type_id) {
                        sel = "selected";
                    }
                    note_book += "<option value='" + obj.note_book_type_id + "  " + sel + "'>" + obj.note_book_title + "</option>";
                });


                $('#note_book_type_id').html(note_book);
                $('#note_book_type_id')[0].sumo.reload();
                $('.sumo_note_book_type_id').find('.CaptionCont').removeClass('SumoUnder ');
            },
            error: function(xhr) {
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            },
            complete: function() {}
        });
    });

    $('#teaching_activity_home_work_id').on('change', function() {

        var teaching_activity_home_work_id = [];
        $("#teaching_activity_home_work_id option:selected").each(function() {
            teaching_activity_home_work_id.push($(this).val());
        });

        var home_work_note_book = '';
        $.ajax({
            type: 'POST',
            url: base_url + 'todayswork/getNotebooksByHomeswork',
            data: {
                'teaching_activity_home_work_id': teaching_activity_home_work_id
            },
            dataType: 'JSON',
            beforeSend: function() {
                // $('#note_book_type_id').html("").addClass('dropdownloading');
            },
            success: function(data) {
               // console.log(data);
                $.each(data, function(i, obj) {
                    home_work_note_book += "<option value='" + obj.note_book_type_id + "'>" + obj.note_book_title + "</option>";
                });
                $('#note_book_type_id_home_work').html(home_work_note_book);
                $('#note_book_type_id_home_work')[0].sumo.reload();
                $('.sumo_note_book_type_id_home_work').find('.CaptionCont').removeClass('SumoUnder ');

            },
            error: function(xhr) {
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            },
            complete: function() {}
        });
    });
</script>