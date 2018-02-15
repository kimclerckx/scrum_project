<?php
require_once 'Node.php';
require_once '../Database.php';

class NodeList
{
    public function getAllNodes()
    {
        $db = new Database();
        $sql = "SELECT * FROM nodes WHERE ID != 1";
        $db->executeWithoutParam($sql);
        $resultSet = $db->resultset();
        $db = null;
        $nodeList = array();
        foreach ($resultSet as $value) {
            $content = array();
            $content['ID'] = $value['ID'];
            $content['content'] = $value['content'];
            $content['parentID'] = $value['parentID'];
            $content['button'] = $value['button'];
            $content['hasChild'] = $value['hasChild'];
            array_push($nodeList, $content);
        }
        return $nodeList;
    }

    function buildTree(array $elements, $parentID = 1)
    {
        $structure = "<ul>";
        foreach ($elements as $element) {
            if ($element['parentID'] == $parentID) {
                $structure .= "<li>" . $element['content'];
                if ($element['hasChild'] == 1) {
                    $structure .= buildTree($elements, $element['ID']);
                }
                $structure .= "</li>";
            }
        }
        $structure .= "</ul>";
        return $structure;
    }

    function getContentByID($id)
    {
        $db = new Database();
        $sql = "SELECT content FROM nodes WHERE ID = :id";
        $db->executeWithParam($sql, array(array(':id', $id)));
        $result = $db->single();
        $db = null;
        return $result;
    }

    function upDateNode($id, $content)
    {

        $db = new Database();
        $sql = "UPDATE nodes SET content = :content WHERE ID = :id";
        $db->executeWithParam($sql, array(array(':id', $id), array(':content', $content)));
        $db = null;
    }

}