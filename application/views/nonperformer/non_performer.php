<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<style>
    .subject-grid {
        padding: 10px;
        /* border: 1px solid gray; */
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .subject-box {
        padding:8px;
        border: 1px solid #000;
        text-align: center;
        width: 100px;
        border-radius: 5px;
    }
</style>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            //   if ($this->rbac->hasPrivilege('class', 'can_add')) {
            ?>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('class_wise_non_performer'); ?></h3>
                    </div>
                    <div class="subject-grid">
                            <div>
                                <span class="ml-2">Class Play</span>
                                <div class="subject-box d-flex">
                                     84.21%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class K.G</span>
                                <div class="subject-box d-flex">
                                     84.21%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 2</span>
                                <div class="subject-box d-flex" >
                                     78.95%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 4</span>
                                <div class="subject-box d-flex">
                                     95%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 6</span>
                                <div class="subject-box d-flex">
                                     90%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 8</span>
                                <div class="subject-box d-flex">
                                     92%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 10</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 12</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class Nursery</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 1</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 2</span>
                                <div class="subject-box d-flex">
                                     90%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 5</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 7</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 9</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Class 11</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
                            </div>
                        </div>
                </div>

            </div>
            <?php //} 
            ?>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages overflow-visible">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('s_no'); ?></th>
                                        <th><?php echo $this->lang->line('admission_number'); ?></th>
                                        <th><?php echo $this->lang->line('roll_no'); ?></th>
                                        <th><?php echo $this->lang->line('student_name'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('section'); ?></th>
                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                        <th><?php echo $this->lang->line('mother_name'); ?></th>
                                        <th><?php echo $this->lang->line('mobile_number'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="checkbox" name="check_student" value="1"></td>
                                        <td>AC001</td>
                                        <td>1</td>
                                        <td>Ram</td>
                                        <td>Class 1</td>
                                        <td>Section A</td>
                                        <td>Shayam</td>
                                        <td>Rohani</td>
                                        <td>9878767856</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="check_student" value="1"></td>
                                        <td>AC001</td>
                                        <td>1</td>
                                        <td>Ram</td>
                                        <td>Class 1</td>
                                        <td>Section A</td>
                                        <td>Shayam</td>
                                        <td>Rohani</td>
                                        <td>9878767856</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="check_student" value="1"></td>
                                        <td>AC001</td>
                                        <td>1</td>
                                        <td>Ram</td>
                                        <td>Class 1</td>
                                        <td>Section A</td>
                                        <td>Shayam</td>
                                        <td>Rohani</td>
                                        <td>9878767856</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="check_student" value="1"></td>
                                        <td>AC001</td>
                                        <td>1</td>
                                        <td>Ram</td>
                                        <td>Class 1</td>
                                        <td>Section A</td>
                                        <td>Shayam</td>
                                        <td>Rohani</td>
                                        <td>9878767856</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="check_student" value="1"></td>
                                        <td>AC001</td>
                                        <td>1</td>
                                        <td>Ram</td>
                                        <td>Class 1</td>
                                        <td>Section A</td>
                                        <td>Shayam</td>
                                        <td>Rohani</td>
                                        <td>9878767856</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h4 class="box-title titlefix"><?php echo $this->lang->line('subject_wise_performance'); ?></h4>
                        </div>
                        <div class="subject-grid">
                            <div>
                                <span class="ml-2">English</span>
                                <div class="subject-box d-flex">
                                     84.21%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Mathmatics</span>
                                <div class="subject-box d-flex">
                                     84.21%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Hindi</span>
                                <div class="subject-box d-flex" >
                                     78.95%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Science</span>
                                <div class="subject-box d-flex">
                                     95%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">SST</span>
                                <div class="subject-box d-flex">
                                     90%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Drawing</span>
                                <div class="subject-box d-flex">
                                     92%
                                </div>
                            </div>
                            <div>
                                <span class="ml-2">Computer</span>
                                <div class="subject-box d-flex">
                                     70%
                                </div>
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