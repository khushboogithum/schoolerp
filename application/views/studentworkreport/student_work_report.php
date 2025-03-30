<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <style>
        input[type="checkbox"],
        input[type="text"] {
            margin: 0;
            padding: 5px;

        }

        .btn-container input[type="checkbox"] {
            margin-right: 10px;

        }

        .btn-container a {
            margin-right: 20px;
        }

        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 5px;
            height: 10px;
            background-color: #f0f0f0;
            border: 2px solid #007bff;
            border-radius: 3px;
            display: inline-block;
            position: relative;
            cursor: not-allowed;
        }

        .custom-checkbox:checked {
            background-color: #007bff;
            padding: 6px;
        }

        .custom-checkbox:checked::after {
            content: '';
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            position: absolute;
            top: 0px;
            left: 3px;
            transform: rotate(45deg);
        }

        .custom-checkbox:disabled {
            opacity: 0.6;
        }

        .present {
            background-color: #136b23;
            color: #ffffff;
        }

        .absent {
            background-color: #ff0000;
            color: #ffffff;
        }

        table.dataTable, 
        table.dataTable th, 
        table.dataTable td {
            border: 1px solid black !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        table.dataTable {
            border-collapse: collapse;
        } 
    </style>

    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <!-- <h3 class="box-title"><?php echo $this->lang->line('todays_work_syllubus_report'); ?></h3> -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" action="<?php echo base_url('studentworkreport/index'); ?>">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">

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
                                        <label for="exampleInputEmail1">From Date</label>
                                        <input autofocus="" id="work_date" name="from_date" placeholder="" type="date" class="form-control" value="<?=@$from_date?>" autocomplete="off">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">To Date</label>
                                        <input autofocus="" id="work_date" name="to_date" placeholder="" type="date" class="form-control" value="<?=@$to_date   ?>" autocomplete="off">
                                        <span class="text-danger"></span>
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
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix" style="margin-left:40%;"><?php echo $this->lang->line('student_work_evaluation_report'); ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive overflow-visible">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        
                                        <th rowspan="2"><?php echo $this->lang->line('s_no'); ?></th>
                                        <th rowspan="2" width="10%  "><?php echo $this->lang->line('date'); ?></th>
                                        <th rowspan="2"><?php echo $this->lang->line('attendence'); ?></th>
                                        <th colspan="2"><?php echo $this->lang->line('discipline'); ?></th>
                                        <?php

                                        foreach ($getreportdata as $entries) {
                                            foreach ($entries as $subject => $fields) {
                                                if ($subject !== "discipline") {
                                                    if (!isset($subjects[$subject])) {
                                                        $subjects[$subject] = array_keys($fields);
                                                    } else {
                                                        $subjects[$subject] = array_unique(array_merge($subjects[$subject], array_keys($fields)));
                                                    }
                                                }
                                            }
                                        }

                                        foreach ($subjects as $subject => $fields) {
                                            echo "<th colspan='3'>$subject</th>";
                                        }
                                        ?>
                                    </tr>
                                    <tr>

                                        <th><?php echo $this->lang->line('dress'); ?></th>
                                        <th><?php echo $this->lang->line('conduct'); ?></th>
                                        <?php
                                        foreach ($subjects as $key => $subject) {
                                            if ($subject !== 'discipline') {
                                                echo "<th>" . $this->lang->line('fair_copy') . "</th><th>" . $this->lang->line('writing_copy') . "</th><th>" . $this->lang->line('learning_copy') . "</th>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($getreportdata as $date => $data) {


                                    ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td class="text-left"><?= $date ?></td>
                                            <td><?= isset($getAttendenceReport[$date]['attendence']) && $getAttendenceReport[$date]['attendence'] == 'P' ? '<span class="btn present">P</span>' : '<span class="btn absent">A</span>'; ?></td>

                                            <!-- <td><input type="checkbox" <?= isset($data['discipline']['dress']) && $data['discipline']['dress'] == 1 ? 'checked' : ''; ?> disabled name="" value="" class="custom-checkbox" /></td>
                                            <td><input type="checkbox" <?= isset($data['discipline']['conduct']) && $data['discipline']['conduct'] == 1 ? 'checked' : ''; ?> disabled name="" value="" class="custom-checkbox" /></td> -->
                                            <td><span style="font-size:20px;"><?= isset($data['discipline']['dress']) && $data['discipline']['dress'] == 1 ? '✅' : '❌'; ?></span></td>
                                            <td><span style="font-size:20px;"><?= isset($data['discipline']['conduct']) && $data['discipline']['conduct'] == 1 ? '✅' : '❌'; ?></span></td>

                                            <?php

                                            foreach ($subjects as $subject => $fields) {
                                                foreach ($fields as $field) {
                                                    $checked = isset($data[$subject][$field]) && $data[$subject][$field] == 1 ? '✅' : '❌';
                                                    // echo "<td><input type='checkbox' $checked disabled class='custom-checkbox'></td>";
                                                    echo "<td><span style='font-size:20px;'>".$checked."</span></td>";
                                                }
                                            }


                                            ?>


                                        </tr>

                                       
                                                        
                                                        <td><span style="font-size:20px;"><?= $learning_work ?></span></td>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4><b><?= $this->lang->line('report') ?></b></h4>
                        </div>
                        <div class="report-container">
                            <span class="ml-2 subject-label">1. <?= $this->lang->line('attendance_summary') ?></span>
                            <div class="subject_details">
                                <span class=""><?= $this->lang->line('no_of_day_school_open') ?></span>
                                <div class="subject-box-student d-flex" style="width:127px; padding:10px;margin-right: 30px;">
                                    <?= ($getAttendenceReport['school_open'] ?? 0) ?>
                                </div>
                            </div>
                            <div class="subject_details">
                                <span class=""><?= $this->lang->line('no_of_day_student_attend_the_class') ?></span>
                                <div class="subject-box-student d-flex" style="width:127px; padding:10px;margin-right: 30px;">
                                    <?= ($getAttendenceReport['student_attend'] ?? 0) ?>
                                </div>
                            </div>
                        </div>
                        <div class="report-container">
                            <span class="ml-2 subject-label">2. <?= $this->lang->line('discipline_summary') ?></span>
                            <div class="subject_details">
                                <span class=""><?= $this->lang->line('without_dress') ?></span>
                                <div class="subject-box-student d-flex" style="width:127px; padding:10px;margin-right: 30px;">
                                    <?= ($getsubjectwisestatus['withoutDress'] ?? 0) ?>
                                </div>
                            </div>
                            <div class="subject_details">
                                <span class=" "><?= $this->lang->line('bad_conduct_found') ?></span>
                                <div class="subject-box-student d-flex" style="width:127px; padding:10px;margin-right: 30px;">
                                    <?= ($getsubjectwisestatus['bedconduct'] ?? 0) ?>
                                </div>
                            </div>
                        </div>
                        <div class="report-container">
                            <span class="ml-2 subject-label">3. <?= $this->lang->line('work_summary') ?></span>
                            <!-- <div>
                                <span class="">Hindi</span>
                                <div class="subject-box-student highlight">45/50</div>
                            </div> -->
                            <?php   $percentage=array();
                                    foreach ($getsubjectwisestatus['subjectReport'] as $key => $subjectStatus) {
                                        if($subjectStatus['complete']>0){
                                            $percentage[]=round(($subjectStatus['complete']/$subjectStatus['totalstudent'])*100,0,2);
        
                                        }
                                ?>
                                <div>
                                    <span class=""><?= $key ?></span>
                                    <div class="subject-box-student"><?php echo ($subjectStatus['complete'] ?? 0) . '/' . ($subjectStatus['totalstudent'] ?? 0) ?></div>
                                </div>
                            <?php } ?>
                            <!-- <div>
                                <span class="">English</span>
                                <div class="subject-box-student">45/50</div>
                            </div>
                            <div>
                                <span class="">Mathematics</span>
                                <div class="subject-box-student">45/50</div>
                            </div>
                            <div>
                                <span class="">Science</span>
                                <div class="subject-box-student">45/50</div>
                            </div>
                            <div>
                                <span class="">SST</span>
                                <div class="subject-box-student">45/50</div>
                            </div>
                            <div>
                                <span class="">Drawing</span>
                                <div class="subject-box-student">45/50</div>
                            </div>
                            <div>
                                <span class="">Computer</span>
                                <div class="subject-box-student">45/50</div>
                            </div> -->

                            <!-- Grade Box -->
                            <div>
                                <span class="">Grade</span>
                                <div class="grade-box"><?=!empty($percentage) ? getGrade(array_sum($percentage) / count($percentage)) : 'NA';?></div>
                            </div>
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
<script>
    $(document).ready(function(e) {
        getSectionByClass("<?php echo $class_id ?>", "<?php echo $section_id ?>", 'secid');
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