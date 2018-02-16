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
    
    function getContentByID ($id){      
        $db = new Database();
        $sql= "select content, button from nodes where ID = :id";
        $db->executeWithParam($sql, array(array(':id', $id)));
        $result = $db->single();
        $db = null;
        return $result;
    }
    function upDateNode($id ,$content,$button){
        
        $db = new Database();
        $sql= "update nodes set content = :content, button = :button where ID = :id";
        $db->executeWithParam($sql, array(array(':id', $id),array(':content', $content),array(':button', $button)));
        $db = null;
    }
    public function deleteNodes($ids){
       $stringIds = implode(",",$ids);
       $db = new Database();
       $sql = "DELETE FROM nodes WHERE ID = :id";
       $db->executeWithParam($sql, array(array(':id', $stringIds)));
       $db = null;
       }

    public function toBeDeleted(array $nodes,$parentId )
    {   
        $toDelete = array();
        foreach ($nodes as $node) {
            if ($node['parentID'] == $parentId) {
                array_push($toDelete, $node["ID"]);
                if ($node['hasChild'] == 1) {
                    $this->toBeDeleted($nodes, $node['ID']);
            }
     
        }
    }
        
 
        return $toDelete;
    }
  
}