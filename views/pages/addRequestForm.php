<?php
    $transaction = new Transactions();
    $employees = $transaction->showEmployees();
    $levels = $transaction->showLevelsOFImportancy();

?>

<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="addRequestForm">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
		  <form id="saveRequest" method="POST" action="/eCIS/controllers/TransactionsController.php">
                <input type="hidden" name="userAction" value="addRequest">

                <div class="modal-header">
                    <span style="font-weight:bolder;">Add Request</span>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="">Lastname</label>
                            <input type="text" class="form-control mb-2" name="lastName" required>
                            <label for="">Firstname</label>
                            <input type="text" class="form-control mb-2" name="firstName" required>
                            <label for="">Middlename</label>
                            <input type="text" class="form-control mb-2" name="middleName" >
                        </div>
                        <div class="col-6">
                            <label for="">Agency</label>
                            <input type="text" class="form-control mb-2" name="agency" >

                            
                            <label for="">Requested by</label>
                            <select name="requestedBy" id="" class="form-control mb-2" required>
                                <option value="" hidden>** SELECT **</option>
                                <?php foreach ($employees as $employee) { ?>
                                    <option value="<?php echo $employee->id; ?>" ><?php echo $employee->fullName; ?></option>
                                <?php } ?>
                                
                            </select>

                            <label for="">Request Type</label>
                            <select name="importancyLevel" id="" class="form-control mb-2" required>
                                <option value="" hidden>** SELECT **</option>
                                <?php foreach ($levels as $level) { ?>
                                    <option value="<?php echo $level->id; ?>" ><?php echo $level->important_label; ?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="">Remarks</label>
                            <textarea name="remarks"  class="form-control" placeholder="Say something..."></textarea>
                        </div>
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
