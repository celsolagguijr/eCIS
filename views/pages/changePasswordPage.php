<div class="row">
    <div class="col-lg-3 col-md-5 col-12" style="width:50%; margin:0 auto;">
        <div class="card shadow">
            <div class="card-header bg-success text-light">
                <div class="card-title h5 m-0 p-0">Change Password </div>
            </div>
            <div class="card-body">
                <form id="changePasswordForm" method="POST" action="/eCIS/controllers/TransactionsController.php">
                    <div class="form-group">
                        <label for="" style="font-weight:bolder">Current Password</label>
                        <input type="hidden" name="userAction" value="changePassword">
                        <input type="password" name="currentPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="" style="font-weight:bolder">New Password</label>
                        <input type="password" name="newPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="" style="font-weight:bolder">Confirm Password</label>
                        <input type="password" name="confirmPassword" class="form-control" required>
                    </div>

                    <div class="form-group float-right">
                        <button type="reset" class="btn btn-dark">Clear <span class="fa fa-times"></span></button>
                        <button type="submit" class="btn btn-primary">Save <span class="fa fa-check"></span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>