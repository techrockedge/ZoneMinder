<div class="modal fade" id="filterdebugModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
     <h5 class="modal-title"><?php echo translate('FilterDebug') ?></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
<?php
  //require_once('includes/Filter.php');
  $fid = validInt($_REQUEST['fid']);
  if ( !$fid ) {
    echo '<div class="error">No filter id specified.</div>';
  } else {
    $filter = new ZM\Filter($_REQUEST['fid']);
    if ( ! $filter->Id() ) {
      echo '<div class="error">Filter not found for id '.$_REQUEST['fid'].'</div>';
    }
  }
?>
       <form name="contentForm" id="filterdebugForm" method="post" action="?">
<?php 
            // We have to manually insert the csrf key into the form when using a modal generated via ajax call
            echo getCSRFinputHTML();
?>
          <p><label>SQL</label><?php echo $filter->sql() ?></p>
         <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('Cancel')?> </button>
        </div>
      </form>
    </div>
  </div>
</div>
