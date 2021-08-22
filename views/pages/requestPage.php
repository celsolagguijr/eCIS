<?php
    require_once("../../includes/Classes/Transactions.php");

    $trans = new Transactions();
    
    $tasks = $trans->showAllRequest();
?>


<div class="table-responsive">
    <table id="listofRequest" class="table table-bordered" style="font-size:0.8rem; width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Request Type</th>
                <th>Member Name</th>
                <th>Agency</th>
                <th>Requested By</th> 
                <th>Created At</th>
                <th>Remarks</th>
                <th>Controls</th>
            </tr>
        </thead>
        <tbody>


        <?php if(count($tasks) <= 0){ ?>
            <tr>
                <td colspan="8" class="text-center"><p> No request found. </p></td>
            </tr>
        <?php } ?>


            <?php $i=1; foreach ($tasks as $task) { ?>
                
                <tr >
                    <td class="text-center"><?php echo $i++; ?></td>
                    <td class="text-center">
                        <div class='badge <?php echo "badge-".$task->COLOR; ?>' style='font-size:.9rem;'><?php echo $task->LABEL; ?></div>
                    </td>
                    <td><?php echo $task->MEMBER; ?></td>
                    <td><?php echo $task->AGENCY; ?></td>
                    <td><?php echo $task->REQUESTED_BY; ?></td>
                    <td> <?php echo $task->CREATED_AT; ?> </td>
                    <td>
                        <textarea style='width:100%' rows='3' readonly><?php echo $task->REMARKS; ?></textarea>
                    </td>
                    <td>
                        <button 
                            type="button" 
                            class="btn btn-sm btn-success btnDone shadow-sm"
                            recid="<?php echo $task->id; ?>"
                            userAction = "taskComplete" >Done <span class="fa fa-check"></span>
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>