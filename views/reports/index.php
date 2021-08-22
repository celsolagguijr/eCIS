<?php

require_once("../../includes/Classes/Report.php");

$fileName = "datasheet_".date('Ymd') . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

$report = new Report($_GET['requestReport']);
$result = $report->getReport();

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

<?php } exit; ?>