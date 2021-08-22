
<div class="row">
    <div class="col-lg-9 col-md-5 col-12" style="width:50%; margin:0 auto;">
        <div class="card shadow">
            <div class="card-header bg-success text-light">
                <div class="card-title h5 m-0 p-0">Users 
                    <span class="fa fa-users"></span> 
                    <div class="float-right">
                    <button class="btn btn-light btn-sm addUserForm" pageName="getaddUserForm" ><span class="fa fa-user-plus"></span></button>  
                    <button class="btn btn-light btn-sm UserPrivileges" pageName="UserPrivileges"><span class="fa fa-filter"></span></button>  
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="listOfUser" 
                        class="table table-bordered table-condensed table-striped"
                        style="font-size:0.9rem; width:100%">
                        <thead>
                            <tr>
                                <th>Controls</th>
                                <th>Name</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>