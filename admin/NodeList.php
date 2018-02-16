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
            array_push($nodeList, $value);
        }
        return $nodeList;
    }
    
    public function toBeDeleted($nodes, $parentId )
    {   
        //    echo '<pre>';
   //print_r($arrToDelete);
//    echo '</pre>';
    //die();
        $toDelete = array();
        foreach ($nodes as $node) {
            if ($node['parentID'] == $parentId) {
                array_push($toDelete, $node["ID"]);
                if ($node['hasChild'] == 1) {
                    $this->toBeDeleted($nodes, $node['ID']);
                }
            }
        }
    }

//    function buildTree(array $elements, $parentID = 1)
//    {
//        $structure = "<ul>";
//        foreach ($elements as $element) {
//            if ($element['parentID'] == $parentID) {
//                $structure .= "<li>" . $element['content'];
//                if ($element['hasChild'] == 1) {
//                    $structure .= buildTree($elements, $element['ID']);
//                }
//                $structure .= "</li>";
//            }
//        }
//        $structure .= "</ul>";
//        return $structure;
//    }
    
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

    function deleteNodes($ids){
        $db = new Database();
        $sql = "DELETE FROM nodes WHERE ID = :id";
        foreach ($ids as $id) {
            $db->executeWithParam($sql, array(array(':id', $id)));
        }
        $db = null;
    }
  
    // Add new node
    function addNode($parentId ,$content, $button){ 
        $db = new Database();
        $sql = 'INSERT INTO nodes(content, parentId, button)
        VALUES (:content, :parentId, :button)';
        $result = $db->executeWithParam($sql, array(array(':content', $content), array(':parentId', $parentId), array(':button', $button)));
        
               
        $sql= "update nodes set hasChild = '1' where ID = :id";
        $db->executeWithParam($sql, array(array(':id', $parentId)));
        
        $db = null;
        return $result;
    }
}

   
