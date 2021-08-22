<?php

    $users = new Users();
    $usertype = $users->getusertypes();
    $memberType = $users->getMemberTypes();
?>

<div class="modal fade" data-backdrop="static" aria-hidden="true" role="dialog" id="UserPrivileges">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span style="font-weight:bolder;">User Privileges</span>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User Type</th>
                            <?php foreach($memberType as $data){ ?>
                            <th class="text-center"><?php echo $data->description ?></th>
                            <?php } ?>

                        </tr>
                    </thead>


                    <tbody>
                        <?php foreach ($usertype as $usertypedata) { ?>
                        <tr>
                            <td style="font-size:1.6rem;font-weight:bolder;"><?php echo $usertypedata->description ?>
                            </td>
                            <?php foreach($memberType as $membertypedata){ ?>
                            <td class="text-center">
                                <?php
                                            $rec = $users->getStatusUserPrivileges($membertypedata->id,$usertypedata->id);
                                        ?>
                                <input type="checkbox" <?php echo $rec->status == 1 ? "Checked":""; ?>
                                    class="form-control btnUserPrivilegesChangeStatus"
                                    recordId='<?php echo $rec->id; ?>'>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
