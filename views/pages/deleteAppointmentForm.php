<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="deleteAppointmentForm">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <span style="font-weight:bolder;">Delete Appointment</span>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteAppointment" method="POST" action="/eCIS/controllers/TransactionsController.php">
                <div class="modal-body">
                    <div class="formMessage"></div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2">
                            <input type="hidden" name='userAction' value="deleteAppointment">
                            <input type="hidden" name='recordID' value="<?php echo $data['id']; ?>">
                            <div style="font-size: 14px;" class="mb-2">Are you sure you want to delete this appointment ?</div>
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
