<?php  $dropDowns = Transactions::getDropDownDatas(); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="card shadow">
            <div class="card-header bg-success text-light">
                <div class="card-title h5 m-0 p-0">Batch Release <span class="fa fa-download"></span></div>
            </div>
            <div class="card-body row justify-content-between">
                <div class="search col-lg-7">
                    <h5 class="text-success">Search</h5>
                    <form action="/eCIS/controllers/TransactionsController.php" method="POST"
                        id="searchECardsForReleaseForm">
                        <div class="form-row">
                            <div class="col-3">
                                <input type="hidden" name="userAction" value="searchMemberPaginate">
                                <select class="form-control form-control-sm m-1" name="searchBy" id="searchBy">
                                    <option value="lastname">Last Name</option>
                                    <option value="firstname">First Name</option>
                                    <option value="gsisid">GSIS ID No.</option>
                                    <option value="bpNo">BP No.</option>
                                    <option value="office">Agency</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control form-control" autocomplete="off"
                                    name="searchText" id="searchText" placeholder="Search" required>
                            </div>
                            <div class="col-3">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="submit" class="btn btn-success btn-sm p-2">Search <span
                                            class="fa fa-search"></span></button>
                                    <button type="reset" class="btn btn-dark btn-sm p-2 btnSearchClear">Clear <span
                                            class="fa fa-times"></span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="searchContent mt-2">
                        <ul class="list-group searchDatas" style="height:350px; overflow:auto;">
                            <h5>** Search **</h5>
                        </ul>
                        <div class="mt-2">
                            <ul class="pagination pagination-sm pagination_Content"></ul>
                        </div>
                    </div>
                </div>
                <div class="list col-lg-5" style="border:1px solid green;">

                    <form action="/eCIS/controllers/TransactionsController.php" method="POST" id="ecardReleaseForm">
                        <input type="hidden" name="userAction" value="saveListofecard">
                        <h5 class="text-success mt-2">List of eCard to be release</h5>
                        <ul class="list-group selectedDatas mb-2" style="height:250px; overflow:auto;"></ul>
                        <div class="form-group">
                            <label for=""><b>Remarks :</b></label>
                            <textarea class="form-control form-control-sm" name="remarks" id="remarks" cols="2"
                                rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for=""><b>Designation :</b></label>
                            <select class="form-control form-control-sm" name="designation" id="designationBatchRelease"
                                required>
                                <option value="" hidden>** Select Designation **</option>
                                <?php foreach($dropDowns['designations'] as $designation){ ?>
                                <option value="<?php echo $designation->id; ?>">
                                    <?php echo $designation->description; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""><b>Receiver's Name :</b></label>
                            <input type="text" class="form-control form-control-sm " id="receiver" name="receiver"
                                required>
                        </div>
                        <div class="form-group">
                            <label for=""><b>Released Date :</b></label>
                            <input type="date" class="form-control form-control-sm " id="dateReleased"
                                name="dateReleased" required>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-dark btn-sm btnClearListofEcard">Clear <span
                                    class="fa fa-times"></span></button>
                            <button type="submit" class="btn btn-success btn-sm">Submit <span
                                    class="fa fa-check"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>