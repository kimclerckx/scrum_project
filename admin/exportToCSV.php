<?php
require_once '../Database.php';
if (isset($_POST["Export"])) {

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=log.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('sessionID', 'timestampStart', 'timestampEnd', 'lastnode'));
    $db = new Database();
    $sql = "SELECT sessionID, timestampStart, timestampEnd, content
            FROM logs
            inner join nodes on nodes.ID = logs.lastnode";
    $db->executeWithoutParam($sql);
    $result = $db->resultset();
    foreach ($result as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
}
