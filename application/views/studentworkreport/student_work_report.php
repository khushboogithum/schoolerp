<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix" style="margin-left:40%;"><?php echo $this->lang->line('student_work_evaluation_report'); ?></h3>
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
                                        <th colspan="3" style="text-align: center;"><?php echo $this->lang->line('attendence'); ?></th>
                                        <th colspan="2" style="text-align: center;"><?php echo $this->lang->line('discipline'); ?></th>
                                        <th colspan="3">English</th>
                                        <th colspan="3">Mathmatics</th>
                                        <th colspan="3">Hindi</th>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('s_no'); ?></th>
                                        <th class="report_date"><?php echo $this->lang->line('date'); ?></th>

                                        <th><?php echo $this->lang->line('t_days'); ?></th>
                                        <th><?php echo $this->lang->line('p_attendence'); ?></th>
                                        <th><?php echo $this->lang->line('a_attendence'); ?></th>

                                        <th><?php echo $this->lang->line('dress'); ?></th>
                                        <th><?php echo $this->lang->line('conduct'); ?></th>
                                        <th><?= $this->lang->line('fair_copy') ?></th>
                                        <th><?= $this->lang->line('writing_copy') ?></th>
                                        <th><?= $this->lang->line('learning_copy') ?></th>
                                        <th><?= $this->lang->line('fair_copy') ?></th>
                                        <th><?= $this->lang->line('writing_copy') ?></th>
                                        <th><?= $this->lang->line('learning_copy') ?></th>
                                        <th><?= $this->lang->line('fair_copy') ?></th>
                                        <th><?= $this->lang->line('writing_copy') ?></th>
                                        <th><?= $this->lang->line('learning_copy') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="text-left">10-02-2025</td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td class="text-left">11-02-2025</td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td class="text-left">05-01-2025</td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td class="text-left">10-02-2025</td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td class="text-left">09-01-2025</td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td class="text-left">16-01-2025</td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" disabled="" name="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                        <td><input type="checkbox" checked="" name="" disabled="" value="" class="custom-checkbox"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div><h4><b><?= $this->lang->line('report') ?></b></h4></div>
                        <div class="report-container">
                            <span class="ml-2 subject-label">1. <?= $this->lang->line('attendance_summary') ?></span>
                            <div class="subject_details">
                                <span class=""><?= $this->lang->line('no_of_day_school_open') ?></span>
                                <div class="subject-box-student d-flex" style="width:127px; padding:10px;margin-right: 30px;">
                                    50
                                </div>
                            </div>
                            <div class="subject_details">
                                <span class=""><?= $this->lang->line('no_of_day_student_attend_the_class') ?></span>
                                <div class="subject-box-student d-flex" style="width:127px; padding:10px;margin-right: 30px;">
                                    45
                                </div>
                            </div>
                        </div>
                        <div class="report-container">
                            <span class="ml-2 subject-label">2. <?= $this->lang->line('discipline_summary') ?></span>
                            <div class="subject_details">
                                <span class=""><?= $this->lang->line('without_dress') ?></span>
                                <div class="subject-box-student d-flex" style="width:127px; padding:10px;margin-right: 30px;">
                                    50
                                </div>
                            </div>
                            <div class="subject_details">
                                <span class=" "><?= $this->lang->line('bad_conduct_found') ?></span>
                                <div class="subject-box-student d-flex" style="width:127px; padding:10px;margin-right: 30px;">
                                    50
                                </div>
                            </div>
                        </div>
                        <div class="report-container">
                        <span class="ml-2 subject-label">3. <?= $this->lang->line('work_summary') ?></span>
                            <div>
                                <span class="">Hindi</span>
                                <div class="subject-box-student highlight">45/50</div>
                            </div>
                            <div>
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
                            </div>

                            <!-- Grade Box -->
                            <div>
                                <span class="">Grade</span>
                                <div class="grade-box">A</div>
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