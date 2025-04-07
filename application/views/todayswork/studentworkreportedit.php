<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$subject_ids = isset($_GET['subject_id']) ? $_GET['subject_id'] : '';
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
$today_work_ids = isset($_GET['today_work_id']) ? $_GET['today_work_id'] : '';
$url = '?subject_id=' . $subject_ids . '&class_id=' . $class_id . '&today_work_id=' . $today_work_ids;



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                    <?php //echo "<pre>"; print_r($student_data); die();?>
                        <h3 class="box-title titlefix" style="margin-left:40%;"><?php echo $this->lang->line('student_work_report'); ?> - <?= $student_data[0]['class_name']; ?></h3>
                    </div>
                    <div class="box-body">
                        <?php
                        if ($this->session->flashdata('msg')) {
                            echo $this->session->flashdata('msg');
                            $this->session->unset_userdata('msg');
                        }
                        ?>

                        <?php
                        // if (isset($error_message)) {
                        //     echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                        // }
                        ?>
                        <div class="table-responsive overflow-visible">
                            <style>
                                table {
                                    width: 100%;
                                    border-collapse: collapse;
                                }

                                th,
                                td {
                                    border: 1px solid gray;
                                    text-align: center;
                                    padding: 8px;
                                }

                                th {
                                    background-color: #f2f2f2;
                                }
                            </style>
                            <form method="post" action="<?= site_url('todayswork/todayStudentWorkReportEdit' . $url) ?>">
                                <table id="studentTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th colspan="2" style="text-align: center;">Discipline</th>
                                           
                                            <?php
                                                $subjects = array_keys($getreportdata[array_keys($getreportdata)[0]]);
                                              
                                                foreach ($subjects as $subject) {
                                                    if ($subject !== 'discipline') {
                                                        echo "<th colspan='3'>$subject</th>";
                                                    }
                                                }
                                                ?>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('s_no'); ?></th>
                                            <th><?php echo $this->lang->line('student_name'); ?></th>
                                            <th><?php echo $this->lang->line('dress'); ?></th>
                                            <th><?php echo $this->lang->line('conduct'); ?></th>
                                            <?php
                                                foreach ($subjects as $key => $subject) {
                                                    if ($subject !== 'discipline') {
                                                        echo "<th>" . $this->lang->line('fair_copy') . "</th><th>" . $this->lang->line('writing_copy') . "</th><th>" . $this->lang->line('learning_copy') . "</th>";
                                                    }
                                                }
                                            ?>
                                            <th><?php echo $this->lang->line('remarks'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // echo "<pre>";
                                    // print_r($getreportdata);

                                    if (!empty($getreportdata)) {

                                        $i = 1;
                                        $unkey=0;
                                        foreach ($getreportdata as $student => $data) {
                                    ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td class="text-left"><?= $student ?></td>
                                                <td>
                                                    <input type="hidden"  name="discipline_dress[<?=$unkey ?>]"  value="0" />
                                                    <input type="checkbox" checked  name="discipline_dress[[<?=$unkey ?>]" value="1" class="custom-checkbox" style="pointer-events: none;" />
                                                </td>
                                                <td>
                                                    <input type="hidden"   name="discipline_conduct[<?=$unkey ?>]"  value="0" />
                                                    <input type="checkbox" checked  name="discipline_conduct[<?=$unkey ?>]" value="1" class="custom-checkbox" style="pointer-events: none;" />
                                                </td> 
                                              

                                                <?php
                                                foreach ($subjects as $skey=>$subject) {
                                                    if ($subject !== 'discipline') {
                                                        $fair_copy = (isset($data[$subject]['fair_copy']) && $data[$subject]['fair_copy'] == 1) ? 'checked' : '';
                                                        $writing_work = isset($data[$subject]['writing_work']) && $data[$subject]['writing_work'] == 1 ? 'checked' : '';
                                                        $learning_work = isset($data[$subject]['learning_work']) && $data[$subject]['learning_work'] == 1 ? 'checked' : '';
                                                ?>
                                                       
                                                        <td>
                                                            <input type="hidden" name="student_work_report_id[]" value="<?=$data[$subject]['student_work_report_id'] ?>">
                                                            <input type="hidden" name="today_work_id[]" value="<?=$data[$subject]['today_work_id'] ?>">
                                                            <input type="hidden" name="student_name[]" value="<?=$data[$subject]['student_name'] ?>">
                                                            <input type="hidden" name="student_id[]" value="<?=$data[$subject]['student_id'] ?>">
                                                            <input type="hidden" name="subject_id[]" value="<?=$data[$subject]['subject_id'] ?>">
                                                            <input type="hidden" name="subject_name[]" value="<?=$data[$subject]['subject_name'] ?>">
                                                            <input type="hidden" name="class_id[]" value="<?=$data[$subject]['class_id'] ?>">
                                                            
                                                        <input type="hidden" name="fair_copy[<?=$unkey ?>]"  value="0">
                                                        <input type="checkbox" <?= $fair_copy ?> name="fair_copy[<?=$unkey ?>]"  value="1" class="custom-checkbox" /></td>
                                                        <td>
                                                            <input type="hidden"  name="writing_work[<?=$unkey ?>]"  value="0"  />
                                                            <input type="checkbox" <?= $writing_work ?> name="writing_work[<?=$unkey ?>]"  value="1" class="custom-checkbox" />
                                                        </td>
                                                        <td>
                                                            <input type="hidden" <?= $learning_work ?> name="learning_work[<?=$unkey ?>]"  value="0" />
                                                            <input type="checkbox" <?= $learning_work ?> name="learning_work[<?=$unkey ?>]"  value="1" class="custom-checkbox" />
                                                        </td>

                                                       
                                                <?php }
                                                } ?>
                                                <td><input type="text" class="form-control" name="remarks[]" placeholder="Text .........." /></td>
                                            </tr>
                                        <?php $unkey++; }
                                    } else { ?>
                                        <tr>
                                            <td colspan="8" style="text-align: center;">No data available</td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                                </table>
                        </div>
                        <?php
                        if (!empty($getTodayWorkReport)) { ?>
                            <div class="subject_wise_home">
                                <?php foreach ($getTodayWorkReport as $student_key => $getTodayWorkReport) { ?>

                                    <div class="col-md-2">
                                        <strong>Today Student: <span id="totalStudents"><?= count($student_data) ?></span></strong></br>
                                        <input type="hidden" id="counttotalStudents" name="total_student" value="<?= count($student_data) ?>">
                                        <input type="hidden"  name="report_subject_id" value="<?=$getTodayWorkReport['subject_id'] ?>">
                                        <input type="hidden"  name="report_class_id" value="<?=$getTodayWorkReport['class_id'] ?>">
                                        <input type="hidden"  name="report_today_work_id" value="<?=$getTodayWorkReport['today_work_id'] ?>">
                                        <input type="hidden"  name="today_work_report_id" value="<?=$getTodayWorkReport['today_work_report_id'] ?>">

                                        <strong>Complete work: <span id="completedWork"><?= count($student_data) ?></span></strong></br>
                                        <input type="hidden" id="countcompletedWork" name="today_completed_work" value="<?= count($student_data) ?>">

                                        <strong>Uncomplete work: <span id="uncompletedWork"> 0 </span></strong></br>
                                        <input type="hidden" id="countuncompletedWork" name="today_uncompleted_work" value="0">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="subject-box-container">
                                            <div class="subject-box">
                                                <div>Completed Work%</div>
                                                <div id="completedPercentage">100</div>
                                                <input type="hidden" id="countcompletedPercentage" name="today_completed_percentage" value="100">
                                            </div>
                                            <div class="subject-box">
                                                <div>Uncompleted Work%</div>
                                                <div id="uncompletedPercentage">0</div>
                                                <input type="hidden" id="countuncompletedPercentage" name="today_uncompleted_percentage" value="0">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div><button type="submit" class="btn btn-info pull-right button-right"><?php echo $this->lang->line('final_submit'); ?></button></div>
                            <?php } ?>
                            </div>
                            </form>
                    </div>
                </div>
            </div>
    </section>
</div>


<script>
    $(document).ready(function() {
        function updateSubjectWiseCounts(subjectClass, totalStudentsId, completedWorkId, uncompletedWorkId, completedPercentageId, uncompletedPercentageId) {
            let totalStudents = $('#studentTable tbody tr').length;
            let completedStudents = 0;
            let uncompletedStudents = 0;

            $('#studentTable tbody tr').each(function() {
                let totalCheckboxes = $(this).find('.' + subjectClass).length;
                let checkedCheckboxes = $(this).find('.' + subjectClass + ':checked').length;

                if (totalCheckboxes === checkedCheckboxes) {
                    completedStudents++;
                } else {
                    uncompletedStudents++;
                }
            });

            let completedPercentage = totalStudents > 0 ? ((completedStudents / totalStudents) * 100).toFixed(2) : 0;
            let uncompletedPercentage = totalStudents > 0 ? ((uncompletedStudents / totalStudents) * 100).toFixed(2) : 0;
            $('#'+totalStudentsId).text(totalStudents);
            $('#' + completedWorkId).text(completedStudents);
            $('#' + uncompletedWorkId).text(uncompletedStudents);
            $('#' + completedPercentageId).text(completedPercentage + '%');
            $('#' + uncompletedPercentageId).text(uncompletedPercentage + '%');

            $('#count'+totalStudentsId).val(totalStudents);
            $('#count' + completedWorkId).val(completedStudents);
            $('#count' + uncompletedWorkId).val(uncompletedStudents);
            $('#count' + completedPercentageId).val(completedPercentage);
            $('#count' + uncompletedPercentageId).val(uncompletedPercentage);
        }

        function updateAllSubjects() {
                updateSubjectWiseCounts('custom-checkbox', 'totalStudents', 'completedWork', 'uncompletedWork', 'completedPercentage', 'uncompletedPercentage');
           
        }
        updateAllSubjects();

        $('#studentTable').on('change', 'input[type="checkbox"]', function() {
            updateAllSubjects();
        });

    });
</script>