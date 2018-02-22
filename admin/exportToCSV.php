<?php
require_once '../Database.php';
if (isset($_POST["Export"])) {
    
    date_default_timezone_set('Europe/Berlin');
    $date = date('d-m-y H.i.s', time());
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=log '.$date.'.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array("sep=,"));
    fputcsv($output, array('Start sessie', 'Einde sessie', 'Laatst bezochte element'));
    $db = new Database();
    $sql = "SELECT timestampStart, timestampEnd, content
            FROM logs
            inner join nodes on nodes.ID = logs.lastnode";
    $db->executeWithoutParam($sql);
    $result = $db->resultset();
    foreach ($result as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
}
