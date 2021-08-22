<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="confirmLogin">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <span style="font-weight:bolder;">Enter your Credentials</span>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="confirmationLogin" method="POST" action="/eCIS/controllers/TransactionsController.php">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2">
                            <input type="hidden" name='userAction' value="confirmLogin">
                            <input type="hidden" name='userRequestAction' value="<?php echo $data['action']; ?>">
                            <input type="hidden" name='recordID' value="<?php echo $data['id']; ?>">
                            <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off" required>
                        </div>
                        <div class="col-12">
                            <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <button type="submit" class="btn btn-success btn-sm">Confirm <span
                                class="fa fa-sign-in-alt"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
