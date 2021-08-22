<div class="card">
<div class="m-2">
    <div class="row">
        <div class="col-lg-6">
            <div class="row m-1">
                <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">
                    Designation :
                </div>
                <div class="col-lg-7 p-0">
                    <select class="form-control form-control-sm" name="designation" id="designation" Tabindex="8" required>
                        <option value="" hidden>** Select Designation **</option>
                        <?php foreach($data as $designation){ ?>
                            <option value="<?php echo $designation->id; ?>">
                                <?php echo $designation->description; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row m-1">
                <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">
                    Release Date :
                </div>
                <div class="col-lg-7 p-0">
                    <input type="date" class="form-control form-control-sm" id="dateReleased" name="dateReleased"
                        Tabindex="11" required>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row m-1">
                <div class="col-lg-5 p-0" style="font-weight: bolder;font-size:0.9">
                    Receiver's Name :
                </div>
                <div class="col-lg-7 p-0">
                    <input type="text" name="designationPerson" class="form-control form-control-sm" id="designationPerson" required>
                </div>
            </div>
        </div>
    </div>
</div>
</div>