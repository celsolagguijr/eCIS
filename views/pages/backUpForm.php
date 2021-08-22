<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="backupForm">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <span style="font-weight:bolder;">Backup Record</span>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="confirmBackupForm" method="POST" action="/eCIS/controllers/TransactionsController.php">
                <div class="modal-body">
                    <div class="formMessage">
                        <div style="font-size:1.5rem" >Confirm backup.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-dark btn-sm shadow" data-dismiss="modal">Cancel <span
                                class="fa fa-times"></span></button>
                        <button type="submit" class="btn btn-success btn-sm">Confirm <span
                                class="fa fa-save"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
