<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix" style="margin-left:40%;"><?php echo $this->lang->line('all_student_work_report'); ?></h3>
                        <a href="" class="btn btn-info pull-right" style=""><?php echo $this->lang->line('download_pdf'); ?></a>
                    </div>
                    <div class="box-body">
                    <?php
                        if ($this->session->flashdata('msg')) {
                            echo $this->session->flashdata('msg');
                            $this->session->unset_userdata('msg');
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
                                    margin-top: 10px;
                                    margin-bottom: 10px;
                                }

                                .subject-grid {
                                    padding: 20px;
                                    border: 1px solid gray;
                                    display: flex;
                                    flex-wrap: wrap;
                                    gap: 10px;
                                }

                                .subject-box {
                                    border: 1px solid #000;
                                    text-align: center;
                                    width: 100px;
                                    border-radius: 5px;
                                }

                                .btn-container {
                                    margin-top: 20px;
                                    display: flex;
                                    justify-content: space-between;
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
                            </style>

                            <table>
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

                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('s_no'); ?></th>
                                        <th class="text-left"><?php echo $this->lang->line('student_name'); ?></th>
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
                                    if (!empty($getreportdata)) {

                                        $i = 1;
                                        foreach ($getreportdata as $student => $data) {
                                    ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td class="text-left"><?= $student ?></td>
                                                <td><input type="checkbox" <?= isset($data['discipline']['dress']) && $data['discipline']['dress'] ? 'checked' : ''; ?> disabled name="" value="" class="custom-checkbox" /></td>
                                                <td><input type="checkbox" <?= isset($data['discipline']['dress']) && $data['discipline']['dress'] ? 'checked' : ''; ?> disabled name="" value="" class="custom-checkbox" /></td>
                                                <?php
                                                foreach ($subjects as $subject) {
                                                    if ($subject !== 'discipline') {
                                                        $fair_copy = (isset($data[$subject]['fair_copy']) && $data[$subject]['fair_copy'] == 1) ? 'checked' : '';
                                                        $writing_work = isset($data[$subject]['writing_work']) ? 'checked' : '';
                                                        $learning_work = isset($data[$subject]['learning_work']) ? 'checked' : '';

                                                ?>
                                                        <td><input type="checkbox" <?= $fair_copy ?> name="" disabled value="" class="custom-checkbox" /></td>
                                                        <td><input type="checkbox" <?= $writing_work ?> name="" disabled value="" class="custom-checkbox" /></td>
                                                        <td><input type="checkbox" <?= $learning_work ?> name="" disabled value="" class="custom-checkbox" /></td>
                                                <?php }
                                                } ?>
                                            </tr>
                                        <?php }
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
                         if (!empty($getreportdata)) { ?>
                        <div class="subject_wise_home"><b><?= $this->lang->line('subject_wise_home_work_percentage') ?></b></div>
                        <div class="subject-grid">
                        <?php foreach($getsubjectwisestatus as $key=>$subjecttatus){

                                $percentage=$subjecttatus['complete']*100/$subjecttatus['totalstudent'];
                            
                            ?>
                            <div>
                               <span class="ml-2"><?=$key ?></span>
                            <div class="subject-box d-flex" style="width:127px; padding:10px">
                                <?=$subjecttatus['complete'] ?>/ <?=$subjecttatus['totalstudent'] ?> = <?=round($percentage,2,2) ?>%
                            </div>
                            </div>
                            
                        <?php } ?>

                        </div>
                        <form method="post" action="<?= site_url('todaysworkreport/allstudentworkreports') ?>">
                            
                        <input type="hidden" name="class_id" value="2" />
                        <input type="checkbox" required name="status" value="2" style="margin-top:10px;" /><b> <?php echo $this->lang->line('submitted_for_approval'); ?></b>
                        <div><button type="submit" class="btn btn-info pull-right" style="margin-top:2%;"><?php echo $this->lang->line('final_submit'); ?></button></div>
                        </form>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>