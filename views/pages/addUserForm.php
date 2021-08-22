<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="addUserForm">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
		  <form id="saveNewUser" method="POST" action="/eCIS/controllers/TransactionsController.php">
                <input type="hidden" name="userAction" value="addUser">

                <div class="modal-header">
                    <span style="font-weight:bolder;">Add User</span>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                   <div class="form-group m-0 mb-1">
                        <label for="" style="font-weight:bolder">Name </label>
                        <input type="text" class="form-control form-control-sm" name="fullname" autocomplete="off" required>
                   </div>
                   <div class="form-group m-0 mb-1">
                        <label for="" style="font-weight:bolder">User Type</label>
                        <select class="form-control form-control-sm" name="usertype"  required>
                            <option value="">** SELECT **</option>
                            <option value="1">LESU</option>
                            <option value="2">OBM</option>
                            <option value="3">SUPER USER</option>
                        </select>
                   </div>
                   <div class="form-group m-0 mb-1">
                        <label for="" style="font-weight:bolder">User Name</label>
                        <input type="text" class="form-control form-control-sm" name="username"  autocomplete="off"required>
                   </div>
                   <div class="form-group m-0 mb-1">
                        <label for="" style="font-weight:bolder">Password</label>
                        <input type="text" class="form-control form-control-sm" name="password" autocomplete="off" value="12345678" required>
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
