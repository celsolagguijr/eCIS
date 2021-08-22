<?php
    $transactions = new Transactions();
    $info = $transactions->getAppointmentInfo($data['id']);
?>

<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="editAppointmentForm">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="saveEditAppointment" method="POST" action="/eCIS/controllers/TransactionsController.php">

                <input type="hidden" name="userAction" value="saveEditAppointment">
                <input type="hidden" name="recordID" value="<?php echo $data['id'] ?>">

                <div class="modal-header">
                    <span style="font-weight:bolder;">Edit Appointment</span>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-1"><strong>Member Information</strong></p>
                    <div  class="card p-2 mb-3" style="font-size: .9em;">
                        <p class="p-0 m-0"><strong>Bp No.           :</strong> <span> <?php echo $info->BPNO; ?> </span></p>
                        <p class="p-0 m-0"><strong>GSIS ID No.      :</strong> <span> <?php echo $info->GSISID; ?> </span></p>
                        <p class="p-0 m-0"><strong>Member Name      :</strong> <span> <?php echo $info->FULLNAME; ?> </span> </p>
                        <p class="p-0 m-0"><strong>Agency           :</strong> <span> <?php echo $info->AGENCY; ?> </span> </p>
                        <p class="p-0 m-0"><strong>Member Status    :</strong> <span> <?php echo $info->MEMBERSTAT; ?> </span> </p>
                        <p class="p-0 m-0"><strong>Servicing Bank   :</strong> <span> <?php echo $info->BANK; ?> </span> </p>
                        <p class="p-0 m-0"><strong>Card Type        :</strong> <span> <?php echo $info->ECARDTYPE; ?> </span> </p>
                    </div>
                    <p class="p-0 m-0"><strong>Set Appointment Date</strong></p>
                    <input type="date" name="appointmentDate" class="form-control form-control-md" value="<?php echo $info->APPOINTMENTDATE; ?>">

                    
                </div>
                <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-dark btn-sm shadow" 
                            data-dismiss="modal">Cancel 
                            <span class="fa fa-times"></span>
                        </button>
                        <button 
                            type="submit" 
                            class="btn btn-success btn-sm shadow" >Save 
                            <span class="fa fa-check"></span>
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>

