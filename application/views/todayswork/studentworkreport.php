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
                            </style>

                            <table>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th colspan="2" style="text-align: center;">Discipline</th>
                                        <th colspan="3" style="text-align: center;"><?= $subject_name; ?></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>Student's Name</th>
                                        <th>Dress</th>
                                        <th>Conduct</th>
                                        <th>Fair Copy</th>
                                        <th>Writing Work</th>
                                        <th>Learning Work</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form method="post" action="<?=site_url('todayswork/studentworkreport') ?>">
                                        
                                    <input type="hidden" name="subject_name" value="<?=$subject_name ?>" />
                                    <input type="hidden" name="class_name" value="<?=$class_id ?>" />
                                    <?php
                                    if (!empty($student_data)) {
                                        foreach ($student_data as $key => $students) {

                                    ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td>
                                            <input type="hidden" name="studentId[]" value="<?=$students['id'] ?>" />
                                            <input type="hidden" name="student_name[]" value="<?= $students['firstname'] ?> <?= $students['middlename'] ?> <?= $students['lastname'] ?>" />
                                                 <?= $students['firstname'] ?> <?= $students['middlename'] ?> <?= $students['lastname'] ?></td>
                                            <td>
                                                <input type="hidden"  name="dress[<?=$key ?>]" value="0" />
                                                <input type="checkbox" checked name="dress[<?=$key ?>]" value="1" />
                                            </td>
                                            <td>
                                                <input type="hidden"  name="conduct[<?=$key ?>]" value="0" />
                                                <input type="checkbox" checked name="conduct[<?=$key ?>]" value="1" />
                                            </td>
                                            <td>
                                                <input type="hidden"  name="fair_copy[<?=$key ?>]" value="0" />
                                                <input type="checkbox" checked name="fair_copy[<?=$key ?>]" value="1" />
                                            </td>
                                            <td>
                                                <input type="hidden"  name="writing_copy[<?=$key ?>]" value="0" />
                                                <input type="checkbox" checked name="writing_copy[<?=$key ?>]" value="1" />
                                            </td>
                                            <td>
                                                <input type="hidden"  name="learning_copy[<?=$key ?>]" value="0" />
                                                <input type="checkbox" checked name="learning_copy[<?=$key ?>]" value="1" />
                                            </td>
                                            <td><input type="text" class="form-control" name="remarks[]" placeholder="Text .........." /></td>
                                        </tr>
                                        <?php    }
                                    } else { ?>
                                        <tr>
                                            <td colspan="8" style="text-align: center;">No data available</td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <div><button type="submit" class="btn btn-info pull-right" style="margin-top:2%;"><?php echo $this->lang->line('final_submit'); ?></button></div>
                    </div>
                                    </form>
                </div>
            </div>
        </div>
    </section>
</div>