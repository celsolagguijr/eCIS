<?php

    $transaction = new Transactions();
    $summaryRecords = $transaction->reportSummary();
    $reportFields = $transaction->getDropDownDatas(null);

?>


<div class="row ">
    <div class="col-lg-11 col-md-10 col-12 " style="width:50%; margin:0 auto;">
        <div class="card shadow">
            <div class="card-header m-0 p-0 text-light">
                <nav>
                    <div class="nav nav-tabs m-0 p-0" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true">Summary <span class="fa fa-chart-bar"></span></a>
                        <a class="nav-item nav-link btnAppointmentTab" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                            role="tab" aria-controls="nav-profile" aria-selected="false">Appointments <span class="fa fa-calendar-check"></span></a>
                        <!-- <a class="nav-item nav-link btnRequestTab" id="nav-request-tab" data-toggle="tab" href="#nav-request"
                            role="tab" aria-controls="nav-profile" aria-selected="false">Request <span class="fa fa-paper-plane"></span></a> -->
                    </div>
                </nav>
            </div>

            <div class="card-body m-0 p-0 mt-3 ml-3 mr-3">
                <div class="tab-content" id="nav-tabContent" >
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                            <div class="row">
                                <div class="col-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr >
                                                    <th>Inventory</th>
                                                    <th class="text-center">Active</th>
                                                    <th class="text-center">Pensioner</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr >
                                                    <td>All Records</td>
                                                    <td class="text-center"><a href="#" class="btnReportRequest" requestReport ="activeMembers" ><?php echo $summaryRecords['activeMembers']; ?></a></td>
                                                    <td class="text-center"><a href="#" class="btnReportRequest" requestReport ="pensionerMembers" ><?php echo $summaryRecords['pensionerMembers']; ?></a></td>
                                                    <td class="text-center"><?php echo $summaryRecords['pensionerMembers'] + $summaryRecords['activeMembers']; ?></td>
                                                </tr>
                                                <tr >
                                                    <td>All Released eCards</td>
                                                    <td class="text-center"><a href="#" class="btnReportRequest" requestReport ="activeReleased"><?php echo $summaryRecords['totalActiveReleased']; ?></a></td>
                                                    <td class="text-center"><a href="#" class="btnReportRequest" requestReport ="pensionerReleased"><?php echo $summaryRecords['totalPensionerReleased']; ?></a></td>
                                                    <td class="text-center"><?php echo $summaryRecords['totalActiveReleased'] + $summaryRecords['totalPensionerReleased']; ?></td>
                                                </tr>
                                                <tr >
                                                    <td>All Pending eCards</td>
                                                    <td class="text-center"><a href="#" class="btnReportRequest" requestReport ="activeRemain"><?php echo $summaryRecords['totalActiveRemain']; ?></a></td>
                                                    <td class="text-center"><a href="#" class="btnReportRequest" requestReport ="pensionerRemain"><?php echo $summaryRecords['totalPensionerRemain']; ?></a></td>
                                                    <td class="text-center"><?php echo $summaryRecords['totalActiveRemain'] + $summaryRecords['totalPensionerRemain']; ?></td>
                                                </tr>
                                                <tr >
                                                    <td>LandBank eCards</td>
                                                    <td class="text-center"><a href="#" class="btnReportRequest" requestReport ="activeLBP"><?php echo $summaryRecords['totalActiveLBP']; ?></a></td>
                                                    <td class="text-center"><a href="#" class="btnReportRequest" requestReport ="pensionerLBP"><?php echo $summaryRecords['totalPensionerLBP']; ?></a></td>
                                                    <td class="text-center"><?php echo $summaryRecords['totalActiveLBP'] + $summaryRecords['totalPensionerLBP']; ?></td>
                                                </tr>
                                                <tr >
                                                    <td>UnionBank eCards</td>
                                                    <td class="text-center"><a href="#" class="btnReportRequest" requestReport ="activeUBP"><?php echo $summaryRecords['totalActiveUBP']; ?></a></td>
                                                    <td class="text-center"><a href="#" class="btnReportRequest" requestReport ="pensionerUBP"><?php echo $summaryRecords['totalPensionerUBP']; ?></a></td>
                                                    <td class="text-center"><?php echo $summaryRecords['totalActiveUBP'] + $summaryRecords['totalPensionerUBP']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center"> Note : Click the links to see the report summary. </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card mb-4">
                                        <div class="card-content">
                                            <div class="card-header">
                                              Generate Report
                                            </div>

                                            <div class="card-body">
                                                <form action="/eCIS/views/reports/manualReport.php" id="generateReport" method = "GET" target="_blank">

                                                    <div class="card mb-3">
                                                        <!-- <div class="card-header">
                                                           Required Filters
                                                        </div> -->


                                                        <div class="card-body">
                                                            
                                                        <label for="" style="font-weight:600">Member Type <span style="font-size:0.8em" class="text-danger">(Required)</span></label>
                                                    <div class="d-flex justify-content-start mb-3">
                                                        <?php foreach($reportFields['mTypes'] as $memberType) { ?>
                                                            <input type="checkbox" name="memberType[]" value="<?php echo $memberType->id ?>" id="" class="mr-1" > <span class="mr-3"><?php echo $memberType->description; ?></span>
                                                        <?php } ?>
                                                    </div>
                                                  
                                                    <label for="" style="font-weight:600">Servicing Bank <span style="font-size:0.8em" class="text-danger">(Required)</span></label>
                                                    <div class="d-flex justify-content-start mb-3">
                                                        <?php foreach($reportFields['bank'] as $bank) { ?>
                                                            <input type="checkbox" name="banks[]" value="<?php echo $bank->id ?>" class="mr-1"> <span class="mr-3"><?php echo $bank->bankcode; ?></span>
                                                        <?php } ?>
                                                    </div>
                                                  
                                                    <label for="" style="font-weight:600">eCard Type <span style="font-size:0.8em" class="text-danger">(Required)</span></label>
                                                    <div class="d-flex justify-content-start mb-3">
                                                        <?php foreach($reportFields['etypes'] as $eType) { ?>
                                                            <input type="checkbox" name="eTypes[]" value="<?php echo $eType->id ?>" class="mr-1"> <span class="mr-3"><?php echo $eType->description; ?></span>
                                                        <?php } ?>
                                                    </div>
                                                   
                                                    <label for="" style="font-weight:600">Status <span style="font-size:0.8em" class="text-danger">(Required)</span></label>
                                                    <div class="d-flex justify-content-start mb-3">
                                                        <?php foreach($reportFields['status'] as $status) { ?>
                                                            <input type="checkbox" name="status[]" value="<?php echo $status->id ?>" class="mr-1"> <span class="mr-3"><?php echo $status->description; ?></span>
                                                        <?php } ?>
                                                    </div>
                                                        </div>
                                                    </div>

                                                    <div class="card mb-3">
                                                    <div class="card-header">
                                                    Optional Filters
                                                        </div>

                                                        <div class="card-body">

                                                            <!-- Optional Filters -->
                                                            <div class="d-flex justify-content-start ">
                                                                <div >
                                                                    <input type="radio" name="dateType" value="releaseDate" >
                                                                    <label class="form-check-label" for="flexCheckChecked" style="font-weight:600">
                                                                    Released Date Range
                                                                    </label>
                                                                    </div>
                                                                <div class="ml-4">
                                                                    <input type="radio" name="dateType" value="dateRecieved" > 
                                                                    <label class="form-check-label" style="font-weight:600">
                                                                    Received Date Range
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <p style="font-size:0.8em;font-weight:600" class="text-danger m-0 p-0 mb-3">Note : Select Date Range Type First.</p>
                                                    
                                                            <div class="mt-2 mb-3">
                                                                <label class="form-check-label" for="flexCheckChecked" style="font-weight:600">From</label>
                                                                <input type="date" name="from"  class="form-control form-control-sm mb-2" >
                                                                <label class="form-check-label" for="flexCheckChecked" style="font-weight:600">To</label>
                                                                <input type="date" name="to"  class="form-control form-control-sm" > 
                                                            </div>

                                                            <label for="" style="font-weight:600">Agency</label>
                                                              
                                                            <input type="text" name="agency"  class="form-control form-control-sm" > 
                                                          
                                                            <p style="font-size:0.8em;font-weight:600" class="text-danger m-0 p-0">Ex. MUN GOVT OF ILAGAN</p>
                                                        
                                                            <!-- <label for="" style="font-weight:600">Notification </label>
                                                            <div class="d-flex justify-content-start mb-3">
                                                                <input type="checkbox" name="notification" value="1" class="mr-1"> <span class="mr-3">not yet notified ?</span>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                    

                                                    <!-- <hr>
                                                    <label for="" style="font-weight:600">Date Released </label>
                                                    <div class="d-flex justify-content-start mb-3">
                                                        
                                                    </div> -->
                                                    
                                                    <div class="d-flex justify-content-end">
                                                        <button type="reset" class="btn btn-secondary btn-sm mr-1">Cancel <span class="fa fa-times"></span></button>
                                                        <button type="submit" class="btn btn-success btn-sm ">Generate  <span class="fa fa-chart-bar"></span></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="card">
                                <div class="card-header">

                                <div class="row">

                                    <div class="col-6"></div>
                                    <div class="col-6">
                                        <form id="searchAppointmentByDate" class="d-flex justify-content-end">
                                            <div class="from mr-2">
                                                <span>From : </span><input type="date" name="from" required>
                                            </div>

                                            <div class="to mr-2">
                                                <span>To : </span> <input type="date" name="to" required>
                                            </div>

                                            <div class="submit">
                                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="listOfAppointments" class="table table-bordered" style="font-size:0.8rem; width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Controls</th>
                                                    <th>BP No</th>
                                                    <th>GSIS ID</th>
                                                    <th>Member Name</th>
                                                    <th>Agency</th>
                                                    <th>Member Status</th>
                                                    <th>Servicing Bank</th>
                                                    <th>eCard Type</th>
                                                    <th>Appointment Date</th>
                                                    <th>Appointed By</th>
                                                    <th>Date Created</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-request" role="tabpanel" aria-labelledby="nav-request-tab">
                            <div class="table-request"></div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




