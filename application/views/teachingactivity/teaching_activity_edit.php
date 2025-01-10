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
                        <h3 class="box-title"><?php echo $this->lang->line('edit_teacher_activity'); ?></h3>
                    </div><!-- /.box-header -->
                    <form id="form1" action="<?php echo site_url('teachingactivity/edit/' . $teachingactivityedit[0]->teaching_activity_id); ?>" method="post" accept-charset="utf-8">
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

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('lession_reading'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="teaching_activity_title" name="teaching_activity_title" placeholder="" type="text" class="form-control" value="<?php echo $teachingactivityedit[0]->teaching_activity_title; ?>" />
                                        <span class="text-danger"><?php echo form_error('teaching_activity_title'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('note_book_type'); ?></label><small class="req"> *</small>
                                        <select id="note_book_type_id" name="note_book_type_id[]" multiple class="form-control select2">
                                            <?php
                                          //  print_r($noteBookIds);
                                            foreach ($notebookList as $notebook) {
                                            ?>
                                                <option
                                                    value="<?php echo $notebook->note_book_type_id; ?>"
                                                    <?php echo in_array($notebook->note_book_type_id, $selected_notebook_ids) ? 'selected' : ''; ?>>
                                                    <?php echo $notebook->note_book_title; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>

                                        <span class="text-danger"><?php echo form_error('note_book_type_id[]'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('remarks'); ?></label><small class="req"> *</small>
                                        <input autofocus="" id="remarks" name="remarks" placeholder="" type="text" class="form-control" value="<?php echo $teachingactivityedit[0]->remark ?>" />
                                        <span class="text-danger"><?php echo form_error('remarks'); ?></span>
                                    </div>
                                </div>
                            </div>


                        </div><!-- /.box-body -->

                        <div class="box-footer">

                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('update'); ?></button>
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
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('teacher_activity_list'); ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages overflow-visible">
                            <div class="download_label"><?php echo $this->lang->line('class_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('lession_reading'); ?></th>
                                        <th><?php echo $this->lang->line('note_book_type'); ?></th>
                                        <th><?php echo $this->lang->line('remarks'); ?></th>
                                        <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($teachingActivityList as $teachingActivity) {
                                    ?>
                                        <tr>
                                            <td class="mailbox-name">
                                                <?php echo $teachingActivity->teaching_activity_title; ?>

                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $teachingActivity->note_book_title; ?>

                                            </td>
                                            <td><?php echo $teachingActivity->remark; ?> </td>
                                            </td>
                                            <td class="mailbox-date pull-right">
                                                <?php
                                                if ($this->rbac->hasPrivilege('class', 'can_edit')) {
                                                ?>
                                                    <a href="<?php echo base_url(); ?>teachingactivity/edit/<?php echo $teachingActivity->teaching_activity_id; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                <?php
                                                }
                                                if ($this->rbac->hasPrivilege('class', 'can_delete')) {
                                                ?>
                                                    <a href="<?php echo base_url(); ?>teachingactivity/delete/<?php echo $teachingActivity->teaching_activity_id; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('deleting_note_book'); ?>');">
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
<script>
    $(document).ready(function() {
        $('#note_book_type_id').SumoSelect({
            placeholder: "<?php echo $this->lang->line('select'); ?>",
            allowClear: true,
            // csvDispCount: 3, // Number of selected items to show
            selectAll: true, // Enable Select All option
            // okCancelInMulti: true, // Add OK/Cancel buttons in multi-select
        });

        console.log($('#note_book_type_id')); // Verify targeting of the element
    });
</script>