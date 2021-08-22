<?php

require_once("../../includes/Classes/Report.php");


if(
    !isset($_GET["memberType"]) or
    !isset($_GET["banks"]) or
    !isset($_GET["eTypes"]) or
    !isset($_GET["status"]) 
){
   echo "<script>alert('Please fillout the required fields'); window.close();</script>";
   exit();
}


if(
    isset($_GET["dateType"]) and ($_GET["from"] =='' or  $_GET["to"] =='')
){
   echo "<script>alert('Date Range is required'); window.close();</script>";
   exit();
}



$fileName = "datasheet_".date('Ymd') . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

    $memberType     = $_GET["memberType"];
    $bank           = $_GET["banks"];
    $eTypes         = $_GET["eTypes"];
    $status         = $_GET["status"];
    $notYetNotified = isset($_GET["notification"]) ? 1 :0;


    $filterFields = [
        "memberType"     => $memberType,
        "banks"          => $bank,
        "ecardType"      => $eTypes,
        "status"         => $status,
        "notYetNotified" => $notYetNotified,
    ];

    $report = new Report([]); 
    $result =  (isset($_GET['dateType']) || isset($_GET['agency'])) ? $report->generateReport($filterFields, [
        "field" => $_GET['dateType'],
        "from" => $_GET['from'],
        "to" => $_GET['to'],
        "agency" => $_GET['agency']
    ] ) :  $report->generateReport($filterFields);




if($result["status"] === "error")
    echo $result["message"];

if($result["status"] === "success"){

    $header = $result['header'];
    $data = $result['datas'];

?>
    <table >
        <thead>
            <tr>
                <?php for ($i=0; $i < count($header); $i++) { ?>
                    <th style='border:1px solid black'><?php echo $header[$i] ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data  as $key => $value) { ?>
                <tr>
                    <?php for ($i=0; $i < count($header); $i++) { ?>
                        <td style='border:1px solid black'><?php $fieldName = $header[$i];  echo $value->$fieldName;  ?></td>
                    <?php } ?>
                </tr>
        <?php } ?>
        </tbody>
    </table>

<?php } exit(); ?>

