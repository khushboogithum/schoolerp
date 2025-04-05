<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
 <style>
    .report-title {
            font-size: 20px;
            font-weight: bold;
        }
       
        .status {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        .status div {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }
        .completed { background: green;color: white; }
        .not-completed { background: yellow; color: red; }
        .critical { background: red;color: white; }
        .info {
            font-size: 12px;
            margin-top: 10px;
        }
        .buttons {
            margin-top: 15px;
        }
        .buttons button {
            background: blue;
            color: white;
            border: none;
            padding: 8px 15px;
            margin-right: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
 </style>
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('lesson'); ?>

        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <!-- <h3 class="box-title"><?php echo $this->lang->line('todays_work_syllubus_report'); ?></h3> -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" action="<?php echo base_url('parentsreport/index'); ?>">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                            <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> Date</label><small class="req"> *</small>
                                        <input autofocus="" id="tdate" name="tdate" placeholder="" type="date" class="form-control" value="<?=@$tdate?>" autocomplete="off">
                                        <span class="text-danger"><?php echo form_error('tdate'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="searchclassid" name="class_id" onchange="getSectionByClass(this.value, 0, 'secid')" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $class) {
                                                // $selected = (isset($_GET['class_id']) && $_GET['class_id'] == $class['id']) ? "selected" : "";
                                            ?>
                                                <option value="<?php echo $class['id']; ?>" <?php if (set_value('class_id') == $class['id']) {
                                                                                                echo "selected=selected";
                                                                                            } ?>>
                                                    <?php echo $class['class']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select id="secid" name="section_id" class="form-control" onchange="getStudentBySection(this.value, 0, 'student_id')">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>

                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Students</label><small class="req"> *</small>
                                        <select id="student_id" name="student_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('student_id'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm" style="margin-top: 21px;">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a href="<?= base_url() ?>/parentsreport/index" type="reset" name="reset" value="reset_filter" class="btn btn-primary btn-sm" style=" margin-top: 21px;"><i class="fa fa-filter"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-10 text-center">
                <h1 class="text-danger">Pt.R.N.S. Public school, Lahchore Baghpat</h1>
            </div>
            <div class="col-md-2">
                <img src="" alt="">
            </div>
        </div>
        <div class="row m-1 mt-2">
            <div class="col-md-4">
                <p>Admission No.- <?= $studentDetails[0]['admission_no'] ?></p>
                <p>Class Name - <?= $studentDetails[0]['class'] ?></p>
                <p>Roll No. - <?= $studentDetails[0]['roll_no'] ?></p>

            </div>
            <div class="col-md-4">
                <p>Student's Name - <?= $studentDetails[0]['firstname'] ?></p>
                <p>Father's Name - <?= $studentDetails[0]['father_name'] ?></p>
                <p>Address - <?= $studentDetails[0]['current_address'] ?></p>
            </div>
            <div class="col-md-4">
                <p>Mother's Name - <?= $studentDetails[0]['mother_name'] ?></p>
                <p>DOB - <?= $studentDetails[0]['dob'] ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix" style="margin-left: 35%;"><?php echo $this->lang->line('todays_work_syllubus_report'); ?></h3>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('subject'); ?></th>
                                        <th><?php echo $this->lang->line('total_lesson'); ?></th>
                                        <th><?php echo $this->lang->line('now_going_on'); ?></th>
                                        <th><?php echo $this->lang->line('class_work'); ?></th>
                                        <th><?php echo $this->lang->line('home_work'); ?></th>
                                        <th><?php echo $this->lang->line('syllabus_percentage'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $todayWorkId = $todaysWork[0]['today_work_id'];
                                    $classid = $todaysWork[0]['class_id'];
                                    $subjectname = $todaysWork[0]['subject_name'];
                                    $subjectid = $todaysWork[0]['subject_id'];

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
                                            </tr>
                                        <?php
                                        }
                                    } else { ?>
                                        <tr class="odd">
                                            <td valign="top" colspan="8" class="dataTables_empty">
                                                <div align="center">No data available in table</div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (!empty($getSubjectWiseReport)) {?>
                        <div>
                            <h4><b><?= $this->lang->line('report') ?></b></h4>
                        </div>
                        <div class="report-container">
                            <h4 class="ml-2">1.<?= $this->lang->line('attendance_summary') ?>:-</h4> <h4 class="text-primary"><?= ($studentAttendence[0]['attendence_type_id'] == 1) ? 'Today Present' : 'Absent'; ?> </h4> 
                        </div>
                        <div class="report-container">
                            <h4 class="ml-2">2. <?= $this->lang->line('discipline_summary') ?></h4>
                            <div class="subject_details">
                                <span class="">Dress</span>
                                <div class="d-flex text-primary">
                                    <?=$getSubjectWiseReport['dreessStatus'] ?>
                                </div>
                            </div>
                            <div class="subject_details">
                                <span class="">Conduct</span>
                                <div class="d-flex text-primary">
                                <?=$getSubjectWiseReport['conductStatus'] ?>

                                </div>
                            </div>
                        </div>
                        <div class="report-container">
                            <h4 class="ml-2">3. <?= $this->lang->line('work_summary') ?></h4>
                            <!-- <div>
                                <span class="">Hindi</span>
                                <div class="subject-box-student highlight">45/50</div>
                            </div> -->
                            <?php foreach ($getSubjectWiseReport['subjectReport'] as $key => $subjectStatus) { ?>
                                <div>
                                    <span class=""><?= $key ?></span>
                                    <div class="subject-box-student <?=$subjectStatus['backgroundColor']?>"><?=$subjectStatus['subStatus']?></div>
                                </div>
                            <?php } ?>
                            <div>
                                <span class="">Grade</span>
                                <div class="grade-box"><?=$getSubjectWiseReport['grade'] ?></div>
                            </div>
                        </div>

                        <div class="info">
                            <div><span style="background: green; padding: 2px 5px;">&nbsp;</span> Green box means student performance is good.</div>
                            <div><span style="background: yellow; padding: 2px 5px;">&nbsp;</span> Yellow box means student performance is low.</div>
                            <div><span style="background: orange; padding: 2px 5px;">&nbsp;</span> Orange box means student performance needs attention.</div>
                            <div><span style="background: red; padding: 2px 5px;">&nbsp;</span> Red box means student performance is critical, meet principal immediately.</div>
                        </div>

                        <button type="submit" class="btn btn-info pull-right" style="margin-top:2%;margin-right: 10px;"><?php echo $this->lang->line('message'); ?></button>
                        <button type="submit" class="btn btn-info pull-right" style="margin-top:2%;margin-right: 10px;"><?php echo $this->lang->line('email'); ?></button>
                        <button type="submit" class="btn btn-info pull-right" style="margin-top:2%;margin-right: 10px;"><?php echo $this->lang->line('whatsapp'); ?></button>
                    <?php   } ?>
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
        getStudentBySection("<?php echo $section_id ?>", "<?php echo $student_id ?>", 'student_id')
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


    $(document).on('change', '#subid', function() {
        var subid = $('#subid').val();
        let class_id = $('#searchclassid').val();
        // console.log(subid);
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
    });


    $(document).on('change', '#lesson_number', function() {
        var lesson_number = $('#lesson_number').val();
        // console.log(lesson_number);
        var div_lession_name = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({

            type: 'POST',
            url: base_url + 'todayswork/getlessionDataByLessionId',
            data: {
                'lesson_id': lesson_number
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('#lesson_name').html("").addClass('dropdownloading');
            },
            success: function(data) {
                //console.log(data);
                $.each(data, function(i, obj) {
                    var sel = "";
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
    });

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
                    note_book += "<option value='" + obj.note_book_type_id + "'>" + obj.note_book_title + "</option>";
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
                console.log(data);
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

    function getStudentBySection(section_id, student_id, select_control) {
        let class_id = $('#searchclassid').val();
        if (section_id != "") {
            $('#' + select_control).html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "studentworkreport/getstudent",
                data: {
                    'section_id': section_id,
                    'class_id': class_id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#' + select_control).addClass('dropdownloading');
                },
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var sel = "";
                        if (student_id == obj.student_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.student_id + " " + sel + ">" + obj.firstname + "</option>";
                    });
                    $('#' + select_control).html(div_data);
                },
                complete: function() {  
                    $('#' + select_control).removeClass('dropdownloading');
                }
            });
        }
    }
</script>