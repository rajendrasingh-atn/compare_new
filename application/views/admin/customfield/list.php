<?php defined('BASEPATH') OR exit('No direct script access allowed');
   if($this->session->flashdata('success')) {
    echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" aria-label="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> '.$this->session->flashdata("success").'
        </div>';
   }
   ?>
<div class="panel panel-default">
   <a href="<?php echo base_url('admin/customfield/form');?>" class="btn btn-primary cat float-right" ><?php echo lang('customfield title customfield_add');?> 
   </a>
   <div class="clearfix"></div>
   <hr>
   <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
         <tr>
            <th><?php echo lang('admin table no'); ?></th>
            <th><?php echo lang('admin table Group Name'); ?></th>
            <th><?php echo lang('admin table Custom Field Name'); ?></th>
            <th><?php echo lang('admin table Input Type'); ?></th>
            <th><?php echo lang('admin table action'); ?></th>
         </tr>
      </thead>
      <tbody>
      </tbody>
   </table>
</div>