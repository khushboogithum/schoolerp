<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix" style="margin-left:40%;"><?php echo $this->lang->line('student_work_report'); ?> - Hindi</h3>
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
                                        <th colspan="3" style="text-align: center;">Hindi</th>
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
                                    <tr>
                                        <td>1</td>
                                        <td>Arpan Sharma</td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="text" class="form-control" placeholder="Text .........." /></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Anshu Sharma</td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="text" class="form-control" placeholder="Text .........." /></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Ayush</td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="text" class="form-control" placeholder="Text .........." /></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Khushi</td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="text" class="form-control" placeholder="Text .........." /></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Khushi</td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="text" class="form-control" placeholder="Text .........." /></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Khushi</td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="text" class="form-control" placeholder="Text .........." /></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Khushi</td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="checkbox" checked name="" value=""/></td>
                                        <td><input type="text" class="form-control" placeholder="Text .........." /></td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                    <!-- <tr>
                                        <td colspan="8" style="text-align: center;">No data available</td>
                                    </tr> -->
                                </tbody>
                            </table>

                        </div>
                        <div><a href="" class="btn btn-info pull-right" style="margin-top:2%;" ><?php echo $this->lang->line('final_submit'); ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>