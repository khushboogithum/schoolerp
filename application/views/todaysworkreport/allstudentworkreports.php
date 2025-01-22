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
                                    /* padding: 5px; */
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
                                        <th>Sr.</th>
                                        <th>Student's Name</th>
                                        <th>Dress</th>
                                        <th>Conduct</th>
                                        <?php
                                        foreach ($subjects as $subject) {
                                            if ($subject !== 'discipline') {
                                                echo "<th>Fair Copy</th><th>Writing Work</th><th>Learning Work</th>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($getreportdata as $student => $data){
                                    ?>
                                    <tr>
                                        <td>1</td>
                                        <td><?=$student ?></td>
                                        <td><input type="checkbox" <?= isset($data['discipline']['dress']) && $data['discipline']['dress'] ? 'checked' : ''; ?> disabled name="" value="" /></td>
                                        <td><input type="checkbox" <?= isset($data['discipline']['dress']) && $data['discipline']['dress'] ? 'checked' : ''; ?> disabled name="" value="" /></td>
                                        <?php
                                            foreach ($subjects as $subject) {
                                                if ($subject !== 'discipline') {
                                                    $fair_copy = isset($data[$subject]['fair_copy']) ? 'checked' : '';
                                                    $writing_work = isset($data[$subject]['writing_work']) ? 'checked' : '';
                                                    $learning_work = isset($data[$subject]['learning_work']) ? 'checked' : '';
                                                  
                                            ?>
                                                <td><input type="checkbox" <?=$fair_copy ?> name="" disabled value="" /></td>
                                                <td><input type="checkbox" <?=$writing_work ?>  name="" disabled value="" /></td>
                                                <td><input type="checkbox" <?=$learning_work ?>  name="" disabled value="" /></td>
                                        <?php } } ?>
                                    </tr> 
                                    <?php } ?>
<!--                                     
                                    <tr>
                                        <td>2</td>
                                        <td>Anshu Sharma</td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Ayush</td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Khushi</td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Khushi</td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Khushi</td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Khushi</td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                        <td><input type="checkbox" checked name="" value="" /></td>
                                    </tr> -->
                                    <!-- Add more rows as needed -->
                                    <!-- <tr>
                                        <td colspan="8" style="text-align: center;">No data available</td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                        <div class="subject_wise_home"><b><?= $this->lang->line('subject_wise_home_work_percentage') ?></b></div>
                        <div class="subject-grid">
                            <div class="subject-box">
                                <div>Hindi</div>
                                <div>7 / 9</div>
                            </div>
                            <div class="subject-box">
                                <div>English</div>
                                <div>7 / 9</div>
                            </div>
                            <div class="subject-box">
                                <div>Mathematics</div>
                                <div>7 / 9</div>
                            </div>
                            <div class="subject-box">
                                <div>Science</div>
                                <div>7 / 9</div>
                            </div>
                            <div class="subject-box">
                                <div>SST</div>
                                <div>7 / 9</div>
                            </div>
                            <div class="subject-box">
                                <div>Drawing</div>
                                <div>7 / 9</div>
                            </div>
                            <div class="subject-box">
                                <div>Computer</div>
                                <div>7 / 9</div>
                            </div>
                            <div class="subject-box">
                                <div>Custom</div>
                                <input type="text" class="form-control" placeholder="......" />
                            </div>
                        </div>

                        <input type="checkbox" value="" style="margin-top:10px;"/><b> <?php echo $this->lang->line('submitted_for_approval'); ?></b>
                        <div><a href="" class="btn btn-info pull-right" style="margin-top:2%;"><?php echo $this->lang->line('final_submit'); ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>