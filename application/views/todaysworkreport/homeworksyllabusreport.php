<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
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
                        <form method="post" action="<?php echo base_url('todaysworkreport/index'); ?>">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('todays_date'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="todays_date" name="todays_date" placeholder="" type="date" class="form-control" value="<?php echo isset($todays_date) ? $todays_date : ''; ?>" />
                                        <span class="text-danger"><?php echo form_error('todays_date'); ?></span>
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
                                                <option value="<?php echo $class['id']; ?>"  <?php if (set_value('class_id') == $class['id']) {
                                                    echo "selected=selected";} ?>>
                                                    <?php echo $class['class']; ?>
                                                </option>
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
                                        <select id="secid" name="section_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('subject_group'); ?></label><small class="req"> *</small>
                                        <select id="subject_group_id" name="subject_group_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('subject_group_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('subject'); ?></label><small class="req"> *</small>
                                        <select id="subid" name="subject_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="section_id_error text-danger"><?php echo form_error('subject_id'); ?></span>
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
                    <h3 class="box-title titlefix"><?php echo $this->lang->line('todays_work_syllubus_report'); ?></h3>

                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive mailbox-messages overflow-visible">
                        <table class="table table-striped table-bordered table-hover example">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('subject'); ?></th>
                                    <th><?php echo $this->lang->line('total_lesson'); ?></th>
                                    <th><?php echo $this->lang->line('now_going_on'); ?></th>
                                    <th><?php echo $this->lang->line('class_work'); ?></th>
                                    <th><?php echo $this->lang->line('home_work'); ?></th>
                                    <th><?php echo $this->lang->line('syllabus_percentage'); ?></th>
                                    <th><?php echo $this->lang->line('student_work_percentage'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //$todayWorkId = $todaysWork[0]['today_work_id'];

                                if (!empty($todaysWork)) {
                                    foreach ($todaysWork as $todayLists) {
                                ?>
                                        <tr>
                                            <td><?= $todayLists['subject_name'] ?></td>
                                            <td><?= $todayLists['total_lessons'] ?></td>
                                            <td><?= $todayLists['lesson_number'] ?>-<?= $todayLists['lesson_name'] ?></td>
                                            <td>
                                                <?php
                                                $class_work = $todayLists['class_work'];
                                                foreach ($class_work as $class_works) {
                                                    echo "<div>" . ucfirst($class_works['teaching_activity_title']) . "</div>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $home_work = $todayLists['home_work'];
                                                foreach ($home_work as $home_works) {
                                                    echo "<div>" . ucfirst($home_works['teaching_activity_title']) . "</div>";
                                                }
                                                ?>
                                            </td>
                                            <td><?= $todayLists['syllabus_percentage'] ?>%</td>
                                            <td>NA</td>
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
                    <!-- <form id="form1" action="<?php echo site_url('todaysworkreport/allStudentWorkReport'); ?>" method="post" accept-charset="utf-8">
                            <input type="hidden" class="form-control" name="today_work_id" value="<?= $todayWorkId ?>"/>
                            <div> <button type="submit"  class="btn btn-info pull-right" style="margin-left:5px !important;"><?php echo $this->lang->line('final_submit'); ?></button></div><br><br>
                        </form> -->

                    <div><a href="<?php echo site_url('todaysworkreport/allstudentworkreports'); ?>" class="btn btn-info pull-right" style="margin-left:5px !important;"><?php echo $this->lang->line('go_for_all_student_work_report'); ?></a></div>
                </div>
            </div>
        </div>
</div>
<div class="row">
    <!-- left column -->

    <!-- right column -->
    <div class="col-md-12">

    </div><!--/.col (right) -->
</div> <!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

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
                        if (subject_group_subject_id == obj.subject_id) {
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