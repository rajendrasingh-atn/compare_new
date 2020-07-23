<?php defined('BASEPATH') OR exit('No direct script access allowed');
   if($this->session->flashdata('success')) {
    echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" aria-label="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> '.$this->session->flashdata("success").'
        </div>';
   }
   ?>
<div class="panel panel-default">
   <a href="<?php echo base_url("admin/coupon/add");?>" class="btn btn-primary cat float-right" >Add Coupon </a>
   <div class="clearfix"></div>
   <hr>
   <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
         <tr>
            <th>No</th>
            <th>Coupon Name</th>
            <th>Promo Link</th>
            <th>Coupon Code</th>
            <th>Valid Till</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
      </tbody>
   </table>
</div>