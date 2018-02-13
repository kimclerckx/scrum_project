<?php

require_once 'Node.php';
require_once 'Database.php';
class NodeList
{
    public function getNodes()
    {
        $db = new Database();
        $sql = "SELECT * FROM nodes";
        $db->query($sql);
        $resultSet = $db->resultset();
        $db = null;
        $nodeList = array();
        foreach ($resultSet as $value) {
            $node = new Node($value["ID"], $value["content"], $value["parentID"],
                $value["button"],$value["hasChild"]);
            $nodeList[] = $node;
        }
        return $nodeList;
    }
}