
<?php
    $user = new Users();
    $datas = $user->getUserRecord($data['id'])[0];
    $userstatus = $datas->status;
?>

<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="changeStatus">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <span style="font-weight:bolder;">User Status</span>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="changeStatusFormSubmit" method="POST" action="/eCIS/controllers/TransactionsController.php">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2">
                            <input type="hidden" name='userAction' value="changeStatus">
                            <input type="hidden" name='recordID' value="<?php echo $data['id']; ?>">
                            <h5 class="text-danger text-justify">Are you sure you want to <?php echo $userstatus == 1? "Lock":"Unlock"; ?> <?php echo $datas->userName.' \'s'; ?> account ? </h5>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-dark btn-sm shadow" data-dismiss="modal">Cancel <span
                                class="fa fa-times"></span></button>
                        <button type="submit" class="btn btn-<?php echo $userstatus == 1? "danger":"primary"; ?> btn-sm"><?php echo $userstatus == 1? "Lock":"Unlock"; ?> <span
                                class="fa fa-<?php echo $userstatus == 1? "lock":"unlock"; ?>"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
