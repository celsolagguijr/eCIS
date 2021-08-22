<?php
    $transactions = new Transactions();
    $memberInfo = $transactions->viewCardInformation($data['id'])[0];
?>

<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="addAppointmentForm">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form id="saveAppointment" method="POST" action="/eCIS/controllers/TransactionsController.php">

                <input type="hidden" name="userAction" value="saveAppointment">
                <input type="hidden" name="recordID" value="<?php echo $data['id'] ?>">
                <?php if(!Users::isLogin()){ ?>
                        <input type="hidden" name="userid" value="<?php echo $data['userid'] ?>">
                <?php } ?>


                <div class="modal-header">
                    <span style="font-weight:bolder;">Set Appointment</span>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-1"><strong>Member Information</strong></p>
                    <div  class="card p-2 mb-3" style="font-size: .9em;">
                        <p class="p-0 m-0"><strong>Bp No.           :</strong> <span> <?php echo $memberInfo->bpNo; ?> </span></p>
                        <p class="p-0 m-0"><strong>GSIS ID No.      :</strong> <span> <?php echo $memberInfo->gsisid; ?> </span></p>
                        <p class="p-0 m-0"><strong>Member Name      :</strong> <span> <?php echo $memberInfo->LASTNAME.', '.$memberInfo->FIRSTNAME.' '.$memberInfo->MIDDLENAME; ?> </span> </p>
                        <p class="p-0 m-0"><strong>Agency           :</strong> <span> <?php echo $memberInfo->AGENCY; ?> </span> </p>
                        <p class="p-0 m-0"><strong>Member Status    :</strong> <span> <?php echo $memberInfo->MEMBERTYPE; ?> </span> </p>
                        <p class="p-0 m-0"><strong>Servicing Bank   :</strong> <span> <?php echo $memberInfo->BANK; ?> </span> </p>
                        <p class="p-0 m-0"><strong>Card Type        :</strong> <span> <?php echo $memberInfo->ECARD_TYPE; ?> </span> </p>
                    </div>
                    <p class="p-0 m-0"><strong>Set Appointment Date</strong></p>
                    <input type="date" name="appointmentDate" class="form-control form-control-md">

                    
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

