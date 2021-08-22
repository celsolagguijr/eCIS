<?php
    $dropDowns = Transactions::getDropDownDatas();
?>


<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="addRecord">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
		  <form id="saveNewRecord" method="POST" action="/eCIS/controllers/TransactionsController.php">

                <input type="hidden" name="userAction" value="addRecord">

            <div class="modal-header">
                <span style="font-weight:bolder;">Add Record</span>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

                <div class="modal-body">
                    <h5>Member Information</h5>
                    <div class="card ">
                        <div class="m-2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">BP No.:</div>
                                        <div class="col-lg-7 p-0"><input type="text" class="form-control form-control-sm "  name="bpNo"   Tabindex="1" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">GSIS ID No. :</div>
                                        <div class="col-lg-7 p-0"><input type="text" class="form-control form-control-sm "  name="gsisidno"   Tabindex="2" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0 m-0" style="font-weight: bolder;font-size:0.9;">Last
                                            Name :
                                        </div>
                                        <div class="col-lg-7 p-0"><input type="text"
                                                class="form-control form-control-sm" id="lastname" name="lastname"
                                                Tabindex="3" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">First Name :
                                        </div>
                                        <div class="col-lg-7 p-0"><input type="text"
                                                class="form-control form-control-sm" id="firstname" name="firstname"
                                                Tabindex="4" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">Middle Name
                                            :</div>
                                        <div class="col-lg-7 p-0"><input type="text"
                                                class="form-control form-control-sm " id="middlename" name="middlename"
                                                Tabindex="5" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">Contact # :</div>
                                        <div class="col-lg-7 p-0"><input type="text"
                                                class="form-control form-control-sm" id="contact" name="contact"
                                                Tabindex="6" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">Member Status
                                            :
                                        </div>
                                        <div class="col-lg-7 p-0">
                                            <select class="form-control form-control-sm" name="membertype" id="membertype"  Tabindex="7" required>
                                                <option value="" hidden>** Select Member Status **</option>
                                                <?php foreach($dropDowns['mTypes'] as $type){ ?>
                                                    <option value="<?php echo $type->id; ?>" ><?php echo $type->description; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">Office Name :
                                        </div>
                                        <div class="col-lg-7 p-0"><textarea cols="30" rows="2"
                                                class="form-control form-control-sm" id="agency" name="agency"
                                                Tabindex="8" autocomplete="off" required> </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <br>
                    <h5>Card Information</h5>
                    <div class="card">

                        <div class="m-2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">Card Type. :
                                        </div>
                                        <div class="col-lg-7 p-0">
                                            <select class="form-control form-control-sm" name="ecardtype" id="ecardtype"  Tabindex="9" required>
                                                <option value="" hidden>** Select Card Type **</option>
                                                <?php foreach($dropDowns['etypes'] as $type){ ?>
                                                    <option value="<?php echo $type->id; ?>" ><?php echo $type->description; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">Servicing
                                            Bank :
                                        </div>
                                        <div class="col-lg-7 p-0">
                                            <select class="form-control form-control-sm" name="bank" id="bank"   Tabindex="10"  autocomplete="off" required>
                                                <option value="" hidden>** Select Bank **</option>
                                                <?php foreach($dropDowns['bank'] as $bank){ ?>
                                                    <option value="<?php echo $bank->id; ?>" ><?php echo $bank->bankcode; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row m-1">
                                        <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">Date
                                            Received :
                                        </div>
                                        <div class="col-lg-7 p-0"><input type="date"
                                                class="form-control form-control-sm " id="datereceived" name="datereceived"  Tabindex="11" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer float-right">
                    <button type="button" class="btn btn-dark btn-sm shadow" data-dismiss="modal">Cancel <span
                            class="fa fa-times"></span></button>
                    <button type="submit" class="btn btn-success btn-sm shadow"  Tabindex="12"> Save <span
                            class="fa fa-check"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>
