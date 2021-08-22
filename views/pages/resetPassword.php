
<?php
    $user = new Users();
    $datas = $user->getUserRecord($data['id'])[0];
?>



<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="resetPasswordForm">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <span style="font-weight:bolder;">Reset Password</span>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="resetPasswordFormSubmit" method="POST" action="/eCIS/controllers/TransactionsController.php">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2">
                            <input type="hidden" name='userAction' value="resetPassword">
                            <input type="hidden" name='recordID' value="<?php echo $data['id']; ?>">
                            <h5>User name: <span class="text-danger"> <?php  echo $datas->userName; ; ?></span></h5>
                            <div class="form-group">
                                <label for="" style="font-weight:bolder">Password</label>
                                <input type="text" class="form-control" name="password" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-dark btn-sm shadow" data-dismiss="modal">Cancel <span
                                class="fa fa-times"></span></button>
                        <button type="submit" class="btn btn-warning btn-sm">Reset Password <span
                                class="fa fa-key"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
