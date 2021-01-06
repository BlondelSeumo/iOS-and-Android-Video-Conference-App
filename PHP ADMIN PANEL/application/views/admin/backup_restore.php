<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><?php echo $page_title;?></h6>
  </div>
  <div class="card-body">    
    <div class="row">
      <div class="col-md-12">        
        <div class="col-sm-offset-3 col-sm-6 m-t-15">
          <a href="<?php echo base_url().'admin/backup_restore/create'?>" class="btn btn-primary btn-sm btn-icon-split">
            <span class="icon text-white-50"><i class="fa fa-download"></i></span>
            <span class="text">Create Backup</span>
          </a>
          <br>
        </div>
        <table class="table table-striped" id="servertable">
          <thead>                        
            <tr>
              <th>#</th>
              <th>File Name</th>
              <th>File Size</th>
              <th>Created</th>
              <th>Download</th>                      
              <th>Delete</th>                      
            </tr>
          </thead>
          <tbody>
          <?php $files = directory_map('./db_backup/');
                asort($files);
                $sl=0;
                foreach($files as $file):
                  $sl++;
                if(is_string($file) && pathinfo($file, PATHINFO_EXTENSION) === 'sql'):
          ?>
            <tr>                
              <td><?php echo $sl; ?></td>
              <td><?php echo $file; ?></td>
              <td><?php echo $this->common_model->formatSizeUnits(filesize('./db_backup/'.$file)); ?></td>
              <td><?php echo date ("d M Y H:i:s",filemtime('./db_backup/'.$file)); ?></td>
              <td>
                <a href="<?php echo base_url().'admin/backup_restore/download/'.$file?>" class="btn btn-primary btn-sm btn-icon-split">
                  <span class="icon text-white-50"><i class="fa fa-download"></i></span>
                  <span class="text">Download</span>
                </a>
              </td>
              <td><a href="<?php echo base_url().'admin/backup_restore/delete/'.$file?>" class="btn btn-sm btn-danger"><span class="btn-label"><i class="fa fa-close"></i></span>Delete </a></td>
            </tr>           
          <?php endif; ?>
          <?php endforeach; ?>              
          </tbody>
        </table>
      </div>        
    </div>
  </div>
</div>


