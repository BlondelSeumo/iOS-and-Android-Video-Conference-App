<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"><?php echo $page_title;?></h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm btn-icon-split" data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/meeting_add';?>" id="menu">
                            <span class="icon text-white-50"><i class="fa fa-plus"></i></span>
                            <span class="text">Add</span>
                        </button>
                        <br>
                    </div>
                    <div class="col-md-9">
                        <form class="form-inline " method="get" action="<?php echo base_url('admin/meeting') ?>">
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="title" class="sr-only">Meeting ID</label>
                                <input type="text" name="meeting_code" value="<?php if(isset($meeting_code)){ echo $meeting_code;} ?>" class="form-control form-control-sm" id="title" placeholder="Meeting ID">&nbsp;
                                <button type="submit" class="btn btn-primary btn-sm btn-icon-split">
                                    <span class="icon text-white-50"><i class="fa fa-search"></i></span>
                                    <span class="text">Search</span>
                                </button>
                            </div>                            
                        </form>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Option</th>
                            <th>Meeting Title</th>
                            <th>Meeting ID</th>
                            <th>Created by</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1;
                            foreach ($meetings as $meeting):                     

                        ?>
                        <tr id='row_<?php echo $meeting['meeting_id'];?>'>
                            <td><?php echo $sl++;?></td>
                            <td>
                                <div class="dropdown no-arrow mb-4">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="<?php echo base_url("room/".$meeting['meeting_code']);?>" target="_blank">Join Meeting</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/meeting_edit/'. $meeting['meeting_id'];?>" id="menu" title="<?php echo trans('edit'); ?>">Edit</a>
                                        <a class="dropdown-item" href="#" title="<?php echo trans('delete'); ?>" onclick="delete_row(<?php echo " 'meeting' ".','.$meeting['meeting_id'];?>)" class="delete">Delete</a>
                                    </div>
                                </div>
                            </td>
                            <td><strong><?php echo $meeting['meeting_title'];?></strong></td>
                            <td><strong><?php echo $meeting['meeting_code'];?></strong></td>
                            <td><?php echo $this->common_model->get_name_by_id($meeting['user_id']);?></td>
                            <td><?php echo $meeting['created_at'];?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <?php echo $links; ?>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('form').parsley();
        });
    </script>

    <!-- select2-->
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
    <!-- select2-->