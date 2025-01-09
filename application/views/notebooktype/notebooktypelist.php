<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            //   if ($this->rbac->hasPrivilege('class', 'can_add')) {
            ?>
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('add_note_book_type'); ?></h3>
                    </div><!-- /.box-header -->
                    <form id="form1" action="<?php echo site_url('notebooktype'); ?>" method="post" accept-charset="utf-8">
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
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('note_book_type'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="note_book_title" name="note_book_title" placeholder="" type="text" class="form-control" value="<?php echo set_value('note_book_title'); ?>" />
                                        <span class="text-danger"><?php echo form_error('note_book_title'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('remarks'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="remarks" name="remarks" placeholder="" type="text" class="form-control" value="<?php echo set_value('remarks'); ?>" />
                                        <span class="text-danger"><?php echo form_error('remarks'); ?></span>
                                    </div>
                                </div>
                            </div>


                        </div><!-- /.box-body -->

                        <div class="box-footer">

                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('add'); ?></button>
                          </div>
                    </form>
                </div>

            </div><!--/.col (right) -->
            <!-- left column -->
            <?php //} 
            ?>
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('lesson_list'); ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages overflow-visible">
                            <div class="download_label"><?php echo $this->lang->line('class_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('note_book_type'); ?></th>
                                        <th><?php echo $this->lang->line('remarks'); ?></th>
                                        <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($notebookList as $notebookLists) {
                                    ?>
                                    <tr>
                                        <td class="mailbox-name">
                                            <?php echo $notebookLists->note_book_title; ?>

                                        </td>
                                        <td><?php echo $notebookLists->remark; ?> </td>                                       </td>
                                        <td class="mailbox-date pull-right">
                                            <?php
                                             if ($this->rbac->hasPrivilege('class', 'can_edit')) {
                                            ?>
                                            <a href="<?php echo base_url(); ?>notebooktype/edit/<?php echo $notebookLists->note_book_type_id; ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                            <?php
                                              }
                                             if ($this->rbac->hasPrivilege('class', 'can_delete')) {
                                            ?>
                                              <a href="<?php echo base_url(); ?>notebooktype/delete/<?php echo $notebookLists->note_book_type_id; ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('deleting_note_book'); ?>');">
                                                        <i class="fa fa-remove"></i> 
                                            </a>
                                            <?php } 
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                      }
                                    ?>

                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->

        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
