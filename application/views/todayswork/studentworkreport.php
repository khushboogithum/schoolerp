<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix" style="margin-left:40%;"><?php echo $this->lang->line('student_work_report'); ?> - <?= $subject_name; ?></h3>
                    </div>
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

                                input[type="checkbox"],
                                input[type="text"] {
                                    margin: 0;
                                    padding: 5px;

                                }

                                .subject_wise_home {
                                    margin-top:10px !important;
                                    display: flex;
                                    flex-wrap: wrap;
                                }

                                .subject-box-container {
                                    margin-top:10px !important;
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                    width: 100%;
                                }

                                .subject-box {
                                    border: 1px solid #000;
                                    padding: 5px;
                                    text-align: center;
                                    width: 45%;
                                    /* Adjust width as needed */
                                }
                            </style>

                            <table id="studentTable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th colspan="2" style="text-align: center;">Discipline</th>
                                        <th colspan="3" style="text-align: center;"><?= $subject_name; ?></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('s_no'); ?></th>
                                        <th><?php echo $this->lang->line('student_name'); ?></th>
                                        <th><?php echo $this->lang->line('dress'); ?></th>
                                        <th><?php echo $this->lang->line('conduct'); ?></th>
                                        <th><?php echo $this->lang->line('fair_copy'); ?></th>
                                        <th><?php echo $this->lang->line('writing_copy'); ?></th>
                                        <th><?php echo $this->lang->line('learning_copy'); ?></th>
                                        <th><?php echo $this->lang->line('remarks'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form method="post" action="<?= site_url('todayswork/studentworkreport') ?>">

                                        <input type="hidden" name="subject_name" value="<?= $subject_name ?>" />
                                        <input type="hidden" name="class_name" value="<?= $class_id ?>" />
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
                                                        <input type="checkbox" checked name="dress[<?= $key ?>]" value="1" />
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="conduct[<?= $key ?>]" value="0" />
                                                        <input type="checkbox" checked name="conduct[<?= $key ?>]" value="1" />
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="fair_copy[<?= $key ?>]" value="0" />
                                                        <input type="checkbox" checked name="fair_copy[<?= $key ?>]" value="1" />
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="writing_copy[<?= $key ?>]" value="0" />
                                                        <input type="checkbox" checked name="writing_copy[<?= $key ?>]" value="1" />
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="learning_copy[<?= $key ?>]" value="0" />
                                                        <input type="checkbox" checked name="learning_copy[<?= $key ?>]" value="1" />
                                                    </td>
                                                    <td><input type="text" class="form-control" name="remarks[]" placeholder="Text .........." /></td>
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
                        <div class="subject_wise_home">
                            <div class="col-md-2">
                                <strong>Today Student: <span id="totalStudents"><?=count($student_data) ?></span></strong></br>
                                <strong>Complete work: <span id="complate"><?=count($student_data) ?></span></strong></br>
                                <strong>Uncomplete work: <span id="incomplate"> 0 </span></strong></br>
                            </div>
                            <div class="col-md-4">
                                <div class="subject-box-container">
                                    <div class="subject-box">
                                        <div>Co.W%</div>
                                        <div id="complatePercentage">100</div>
                                    </div>
                                    <div class="subject-box">
                                        <div>Unco.W%</div>
                                        <div id="incomplatePercentage">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div><button type="submit" class="btn btn-info pull-right" style="margin-top:2%;"><?php echo $this->lang->line('final_submit'); ?></button></div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
     $(document).ready(function () {
      function updateCounts() {
        let totalStudents = $('#studentTable tbody tr').length;
        let complateStudent = 0;
        let incomplateStudent = 0;

        // Iterate through each row
        $('#studentTable tbody tr').each(function () {
          const totalCheckboxes = $(this).find('input[type="checkbox"]').length;
          const checkedCheckboxes = $(this).find('input[type="checkbox"]:checked').length;

          // If all checkboxes are checked, count this student
          if (totalCheckboxes === checkedCheckboxes) {
            complateStudent++;
          } else {
            incomplateStudent++;
          }
        });


        let complatePercentage = totalStudents > 0 
          ? ((complateStudent / totalStudents) * 100).toFixed(2)
          : 0;

        let incomplatePercentage = totalStudents > 0 
          ? ((incomplateStudent / totalStudents) * 100).toFixed(2)
          : 0;
        // Update the total and reduced counts
        $('#complate').text(complateStudent);
        $('#incomplate').text(incomplateStudent);
        $('#complatePercentage').text(complatePercentage + '%');
        $('#incomplatePercentage').text(incomplatePercentage + '%');
      }

      // Initialize the counts on page load
      updateCounts();

      // Add change event listener to all checkboxes
      $('#studentTable').on('change', 'input[type="checkbox"]', function () {
        updateCounts();
      });
    });
</script>