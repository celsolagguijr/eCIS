

<?php
    $transaction = new Transactions();
    $record_info = $transaction->viewCardInformation($data['id'])[0];
    $fulllname   = $record_info->LASTNAME.', '.$record_info->FIRSTNAME.' '.$record_info->MIDDLENAME;
    $eCard       = $record_info->ECARD_TYPE;
?>

<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="deleteForm">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <span style="font-weight:bolder;">Delete Record</span>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteFormSubmit" method="POST" action="/eCIS/controllers/TransactionsController.php">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2">
                            <input type="hidden" name='userAction' value="deleteRecord">
                            <input type="hidden" name='recordID' value="<?php echo $data['id']; ?>">
                            <?php if(!Users::isLogin()) { ?>
                                <input type="hidden" name='userid' value="<?php echo $data['userid']; ?>">
                            <?php } ?>
                            <div style="font-size: 14px;" class="mb-2">Are you sure you want to delete this record ?</div>
                            <h5 class="text-danger"> <?php echo $fulllname;?> </h5>
                            <h5 class="text-danger"> <?php echo $eCard;?> </h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-dark btn-sm shadow" data-dismiss="modal">Cancel <span
                                class="fa fa-times"></span></button>
                        <button type="submit" class="btn btn-danger btn-sm">Delete <span
                                class="fa fa-trash"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
