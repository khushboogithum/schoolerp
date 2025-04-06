<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$subject_ids = isset($_GET['subject_id']) ? $_GET['subject_id'] : '';
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
$today_work_ids = isset($_GET['today_work_id']) ? $_GET['today_work_id'] : '';
$url = '?subject_id=' . $subject_ids . '&class_id=' . $class_id . '&today_work_id=' . $today_work_ids;



?>
 <style>
    .card {
        border-radius: 10px;
        margin-top: 10px;
    }

    .card-header h5 {
        font-weight: 600;
    }

    .display-6 {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .p-4{
        padding-left: 10px;
    }
    .fw-bold{
        font-weight: 600;

    }
    p {
        margin: 0 0 2px !important;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <?php //echo "<pre>"; print_r($student_data); die();
                        ?>
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
                            <form method="post" action="<?= site_url('todayswork/studentworkreport' . $url) ?>">
                                <table id="studentTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th colspan="2" style="text-align: center;">Discipline</th>

                                            <?php foreach ($subject_details as $subject_detail) { ?>
                                                <th colspan="3" style="text-align: center;"><?= $subject_detail['name']; ?></th>
                                            <?php } ?>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('s_no'); ?></th>
                                            <th><?php echo $this->lang->line('student_name'); ?></th>
                                            <th><?php echo $this->lang->line('dress'); ?></th>
                                            <th><?php echo $this->lang->line('conduct'); ?></th>
                                            <?php foreach ($subject_details as $subject_detail) { ?>
                                                <th><?php echo $this->lang->line('fair_copy'); ?></th>
                                                <th><?php echo $this->lang->line('writing_copy'); ?></th>
                                                <th><?php echo $this->lang->line('learning_copy'); ?></th>
                                            <?php } ?>
                                            <th><?php echo $this->lang->line('remarks'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <input type="hidden" name="class_id" value="<?= $class_id ?>" />
                                        <?php

                                        if (!empty($student_data)) {
                                            foreach ($student_data as $key => $students) {
                                        ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td>
                                                        <input type="hidden" name="studentId[]" value="<?= $students['id'] ?>" />
                                                        <input type="hidden" name="student_name[]" value="<?= $students['firstname'] ?> <?= $students['middlename'] ?> <?= $students['lastname'] ?>" />
                                                        <?= $students['firstname'] ?> <?= $students['middlename'] ?> <?= $students['lastname'] ?>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="dress[<?= $key ?>]" value="0" />
                                                        <input type="checkbox" class="custom-checkbox" checked name="dress[<?= $key ?>]" value="1" style="pointer-events: none;" />
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="conduct[<?= $key ?>]" value="0" />
                                                        <input type="checkbox" class="custom-checkbox" checked name="conduct[<?= $key ?>]" value="1" style="pointer-events: none;" />
                                                    </td>
                                                    <?php foreach ($subject_details as $student_key => $subject_detail) { ?>

                                                        <td>
                                                            <input type="hidden" name="subject_id[<?= $key ?>][<?= $subject_key ?>]" value="<?= $students['id'] ?>" />
                                                            <input type="hidden" name="subject_name[<?= $key ?>][<?= $subject_key ?>]" value="<?= $subject_detail['name'] ?>" />
                                                            <input type="hidden" name="fair_copy[<?= $key ?>][<?= $student_key ?>]" value="0" />
                                                            <input type="checkbox" class="<?= trim(strtolower($subject_detail['name'])) ?>" checked name="fair_copy[<?= $key ?>][<?= $student_key ?>]" value="1" />
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="writing_copy[<?= $key ?>][<?= $student_key ?>]" value="0" />
                                                            <input type="checkbox" class="<?= trim(strtolower($subject_detail['name'])) ?>" checked name="writing_copy[<?= $key ?>][<?= $student_key ?>]" value="1" />
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="learning_copy[<?= $key ?>][<?= $student_key ?>]" value="0" />
                                                            <input type="checkbox" class="<?= trim(strtolower($subject_detail['name'])) ?>" checked name="learning_copy[<?= $key ?>][<?= $student_key ?>]" value="1" />
                                                        </td>
                                                    <?php } ?>
                                                    <td><input type="text" class="form-control" name="remarks[<?= $key ?>]" placeholder="Text .........." /></td>
                                                </tr>
                                            <?php
                                            }
                                        } else { ?>
                                            <tr>
                                                <td colspan="8" style="text-align: center;">No data available</td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                        </div>
                       
                    <?php if (!empty($student_data)) { ?>
                        <div class="row">
                            <?php foreach ($subject_details as $student_key => $subject_detail) { ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm border-primary">
                                        <div class="card-header bg-primary text-white p-4">
                                            <h5 class="mb-0"><?= ucfirst($subject_detail['name']) ?> Overview</h5>
                                        </div>
                                        <div class="card-body p-4"> 
                                            <div class="row align-items-center">
                                                <!-- Left Side: Student Counts -->
                                                <div class="col-md-6">
                                                    <p><strong>Total Students:</strong>
                                                        <span id="totalStudents<?= ucfirst($subject_detail['name']) ?>"><?= count($student_data) ?></span>
                                                    </p>
                                                    <input type="hidden" id="counttotalStudents<?= ucfirst($subject_detail['name']) ?>" name="total_student[]" value="<?= count($student_data) ?>">

                                                    <p><strong>Completed Work:</strong>
                                                        <span id="completedWork<?= ucfirst($subject_detail['name']) ?>"><?= count($student_data) ?></span>
                                                    </p>
                                                    <input type="hidden" id="countcompletedWork<?= ucfirst($subject_detail['name']) ?>" name="today_completed_work[]" value="<?= count($student_data) ?>">

                                                    <p><strong>Uncompleted Work:</strong>
                                                        <span id="uncompletedWork<?= ucfirst($subject_detail['name']) ?>">0</span>
                                                    </p>
                                                    <input type="hidden" id="countuncompletedWork<?= ucfirst($subject_detail['name']) ?>" name="today_uncompleted_work[]" value="0">
                                                </div>

                                                <!-- Right Side: Percentages -->
                                                <!-- Completed Percentage -->
                                                <div class="p-3 mb-3 rounded bg-light">
                                                    <h6 class="mb-0">
                                                        <span class="text-success fw-bold">Completed: 
                                                            <span id="completedPercentage<?= ucfirst($subject_detail['name']) ?>">100.00%</span>
                                                        </span>
                                                    </h6>
                                                    <input type="hidden" id="countcompletedPercentage<?= ucfirst($subject_detail['name']) ?>" name="today_completed_percentage[]" value="100">
                                                </div>

                                                <!-- Uncompleted Percentage -->
                                                <div class="p-3 rounded bg-light">
                                                    <h6 class="mb-0">
                                                        <span class="text-danger fw-bold">Uncompleted: 
                                                            <span id="uncompletedPercentage<?= ucfirst($subject_detail['name']) ?>">0.00%</span>
                                                        </span>
                                                    </h6>
                                                    <input type="hidden" id="countuncompletedPercentage<?= ucfirst($subject_detail['name']) ?>" name="today_uncompleted_percentage[]" value="0">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-info"><?php echo $this->lang->line('final_submit'); ?></button>
                        </div>
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
            $('#' + totalStudentsId).text(totalStudents);
            $('#' + completedWorkId).text(completedStudents);
            $('#' + uncompletedWorkId).text(uncompletedStudents);
            $('#' + completedPercentageId).text(completedPercentage + '%');
            $('#' + uncompletedPercentageId).text(uncompletedPercentage + '%');

            $('#count' + totalStudentsId).val(totalStudents);
            $('#count' + completedWorkId).val(completedStudents);
            $('#count' + uncompletedWorkId).val(uncompletedStudents);
            $('#count' + completedPercentageId).val(completedPercentage);
            $('#count' + uncompletedPercentageId).val(uncompletedPercentage);
        }

        function updateAllSubjects() {
            <?php foreach ($subject_details as $student_key => $subject_detail) {
                $subjectName = trim(strtolower($subject_detail['name']));
            ?>
                updateSubjectWiseCounts('<?= $subjectName ?>', 'totalStudents<?= ucfirst($subjectName) ?>', 'completedWork<?= ucfirst($subjectName) ?>', 'uncompletedWork<?= ucfirst($subjectName) ?>', 'completedPercentage<?= ucfirst($subjectName) ?>', 'uncompletedPercentage<?= ucfirst($subjectName) ?>');
            <?php } ?>
        }
        updateAllSubjects();

        $('#studentTable').on('change', 'input[type="checkbox"]', function() {
            updateAllSubjects();
        });

    });
</script>