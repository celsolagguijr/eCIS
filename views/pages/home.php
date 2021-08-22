<div class="card shadow-sm">
    <div class="card-header bg-light pl-1 pr-1 ">

    <div style="font-weight:bolder;"> <span class="fa fa-users mb-2 ml-2"></span> Search Member</div>

        <div class="row">
            <div class="col-6">
                <form class="form-inline" method="POST" id="searcRecordForm"
                    action="/eCIS/controllers/TransactionsController.php">
                    <input type="hidden" name="userAction" value="getRecords">
                    <select class="form-control form-control-sm m-1" name="searchBy" id="searchBy">
                        <option value="Name">Name</option>
                        <option value="BpNo">BP No.</option>
                        <option value="gsisIdNo">GSIS ID No.</option>
                        <option value="agency">Agency</option>
                    </select>

                    <input type="text" class="form-control m-1 form-control-sm" name="BpNo" id="BpNo"
                        placeholder="BP No." autocomplete="off" hidden disabled required>


                    <input type="text" class="form-control m-1 form-control-sm" name="gsisIdNo" id="gsisIdNo"
                        placeholder="GSIS ID No." autocomplete="off" hidden disabled required>


                    <input type="text" class="form-control m-1 form-control-sm" name="lastName" id="lastName"
                        placeholder="Last Name" autocomplete="off" required>


                    <input type="text" class="form-control m-1 form-control-sm" name="firstName" id="firstName"
                        placeholder="First Name" autocomplete="off" required>
                    
                    <input type="text" class="form-control m-1 form-control-sm" name="agency" id="agency"
                        placeholder="Agency Name" autocomplete="off" style="min-width :500px"  hidden disabled required>

                    <button type="submit" class="btn btn-success btn-sm m-1 box-shadow">Search <span
                            class="fa fa-search"></span></button>
                </form>
            </div>

            <div class="col-6 row justify-content-end">

                <!-- <button type="button" class="btn btn-info btn-sm btnShowRequest mr-1" pageName="shoAllRequest" >Request <div class="badge badge-danger" id="noOfRequest"><?php echo Notification::count() ?></div></button> -->
                <button type="button" class="btn btn-secondary btn-sm btnClear"> Clear <span
                            class="fa fa-sync"></span></button>

            </div>
        </div>



    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="listOfRecords" class="table table-bordered  table-striped" style="font-size:0.8rem; width:100%">
                <thead>
                    <tr>
                        <th>Controls</th>
                        <th>Card Type</th>
                        <th>Card Status</th>
                        <th>Servicing Bank</th>
                        <th>Date Released</th>
                        <th>GSIS ID No. and BP No.</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Office Name</th>
                        <th>Member Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
