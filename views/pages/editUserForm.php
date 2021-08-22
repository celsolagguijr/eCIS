<?php
    $user = new Users();
    $datas = $user->getUserRecord($data['id'])[0];
?>

<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="editUserForm">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
		  <form id="saveEditUser" method="POST" action="/eCIS/controllers/TransactionsController.php">
                <input type="hidden" name="userAction" value="editUser">
                <input type="hidden" name="userID" value="<?php echo $datas->id; ?>">

                <div class="modal-header">
                    <span style="font-weight:bolder;">Edit User</span>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                   <div class="form-group m-0 mb-1">
                        <label for="" style="font-weight:bolder">Name </label>
                        <input type="text" class="form-control form-control-sm" name="fullname" value="<?php echo $datas->fullName; ?>" required>
                   </div>
                   <div class="form-group m-0 mb-1">
                        <label for="" style="font-weight:bolder">User Type</label>
                        <select class="form-control form-control-sm" name="usertype" required>
                            <option value="">** SELECT **</option>
                            <option value="1" <?php echo $datas->userType == 1 ? "selected": ''; ?> >LESU</option>
                            <option value="2" <?php echo $datas->userType == 2 ? "selected": ''; ?> >OBM</option>
                            <option value="3" <?php echo $datas->userType == 3 ? "selected": ''; ?> >SUPER USER</option>
                        </select>
                   </div>
                   <div class="form-group m-0 mb-1">
                        <label for="" style="font-weight:bolder">User Name</label>
                        <input type="text" class="form-control form-control-sm" name="username" value="<?php echo $datas->userName; ?>" required>
                   </div>
                </div>

                <div class="modal-footer float-right">
                    <button type="button" class="btn btn-dark btn-sm shadow" data-dismiss="modal">Cancel <span
                            class="fa fa-times"></span></button>
                    <button type="submit" class="btn btn-success btn-sm shadow" > Save <span
                            class="fa fa-check"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>
