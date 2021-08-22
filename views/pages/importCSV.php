<div class="row">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="card shadow">
            <div class="card-header bg-success text-light">
                <div class="card-title h5 m-0 p-0">Import CSV File <span class="fa fa-download"></span></div>
            </div>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-lg-4 ">
                        <form action="/eCIS/controllers/TransactionsController.php" id="csvRecordsForm" class="form"
                            method="POST">
                            <input type="hidden" name="userAction" value="saveCSV">
                            <div class="form-group">
                                <label for="recordStatus" style="font-weight:bolder;">Record Status </label>
                                <select name="recordStatus" id="recordStatus"
                                    class="form-control form-control-md col-lg-12" required>
                                    <option value="">** SELECT **</option>
                                    <option value="newRecord">New Record</option>
                                    <option value="oldRecord">Old Record</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="recordStatus" style="font-weight:bolder;">Import File </label>
                                <input type="file" class="form-control form-control-md col-lg-12 text-danger"
                                    accepts="file/csv"
                                    style="padding-bottom:35px;border-color:green; border-style: dashed;" name='csvFile'
                                    id="csvFile" required>
                            </div>

                            <div class="form-group">
                                <button type="reset" class="btn btn-dark">Clear <span
                                        class="fa fa-times"></span></button>
                                <button type="submit" class="btn btn-success float-right">Submit <span
                                        class="fa fa-download"></span></button>
                            </div>
                            <div class="alert alert-danger text-bolder">Note : Incorrect Format will cause errors.</div>
                        </form>

                    </div>

                    <div class="col-lg-8">
                        <h5>Instructions :</h5>
                        Please follow the csv file format below :
                        <ul>
                            <li class="m-2"><b>New Records Column Format : </b>
                                <a href="#" request="newRec" class="btn btn-sm btn-primary downloadBtn">Download the
                                    template. <span class="fa fa-download"></span></a>
                            </li>
                            <li class="m-2"><b> Old Records Column Format : </b>
                                <a href="#" request="oldRec" class="btn btn-sm btn-primary downloadBtn">Download the
                                    template. <span class="fa fa-download"></span></a>
                            </li>
                            <li class="m-2"><b>File must be less than 2 megabytes.</b></li>
                            <li class="m-2 text-danger">Note: Please read carefully the instructions inside the file to
                                avoid error in uploading. Thankyou :)</li>

                        </ul>

                    </div>
                </div>
                <br>
                <br>
                <h5>Transaction Result</h5>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true">Success <span
                                class="badge badge-success noSuccess">0</span></a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false">Errors <span
                                class="badge badge-danger noError">0</span></a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent" >
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="table-responsive" style="height:350px;">
                            <table class="table table-striped table-bordered table-sm" style="font-size:0.8rem">
                                <thead>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Office Name</th>
                                        <th>Member Status</th>
                                        <th>eCard Type</th>
                                        <th>Bank</th>
                                        <th>GSIS ID NO.</th>
                                        <th>BP No.</th>
                                        <th>Contact No.</th>
                                        <th>Date Received</th>
                                        <th>Status</th>
                                        <th>Release Date</th>
                                        <th>Designation</th>
                                        <th>Receiver's Name</th>
                                        <th>Release By</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody id="successBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="table-responsive" style="height:350px;">
                            <table class="table table-striped table-bordered table-sm" style="font-size:0.8rem">
                                <thead>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Office Name</th>
                                        <th>Member Status</th>
                                        <th>eCard Type</th>
                                        <th>Bank</th>
                                        <th>GSIS ID NO.</th>
                                        <th>BP No.</th>
                                        <th>Contact No.</th>
                                        <th>Date Received</th>
                                        <th>Status</th>
                                        <th>Release Date</th>
                                        <th>Designation</th>
                                        <th>Receiver's Name</th>
                                        <th>Release By</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody id="errorBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
