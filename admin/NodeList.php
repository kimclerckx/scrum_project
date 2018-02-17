<?php
require_once '../Database.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if (!isset($_SESSION['email'])) {
    header("Location:index.php");
}

class NodeList
{
    // Array to save ids of elements to be deleted
    public $toDelete = array();

    public function buildTree(array $elements, $parentID = 1)
    {
        $structure = '<ul class="editor-page">';
        foreach ($elements as $element) {
            if ($element['parentID'] == $parentID) {
                $structure .= "<li>" . $element['content']
                    . '<a href="NodeEdit.php?action=add&id=' . $element['ID'] . '"><i class="ion-plus-round"></i></a>' . ' '
                    . '<a href="NodeEdit.php?action=edit&id=' . $element['ID'] . '"><i class="ion-edit"></i></a>' . ' '
                    . '<a onclick="return confirmDelete()" href="loggedIn.php?action=delete&id=' . $element['ID'] . '"><i class="ion-close-round"></i></a>';
                if ($element['hasChild'] == 1) {
                    $structure .= $this->buildTree($elements, $element['ID']);
                }
                $structure .= "</li>";
            }
        }
        $structure .= "</ul>";
        return $structure;
    }

    // Return all the nodes except node with ID = 1
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
    
    // Recursive function to retrieve all the ids of children elements of clicked item. ParentId is just ID of clicked element
    // $nodes is all the nodes from function getAllNodes
    public function toBeDeleted($nodes, $parentId)
    {   
        foreach ($nodes as $node) {
            if ($node['parentID'] == $parentId) {
                array_push($this->toDelete, $node["ID"]);
                if ($node['hasChild'] == 1) {
                    $this->toBeDeleted($nodes, $node['ID']);
                }
            }
        }
    }

    function deleteNodes($ids){
        $db = new Database();
        $sql = "DELETE FROM nodes WHERE ID = :id";
        foreach ($ids as $id) {
            $db->executeWithParam($sql, array(array(':id', $id)));
        }
        $db = null;
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
  
    // Add new node
    function addNode($parentId, $content, $button){ 
        $db = new Database();

        // Insert new node
        $sql = 'INSERT INTO nodes(content, parentId, button)
        VALUES (:content, :parentId, :button)';
        $result = $db->executeWithParam($sql, array(array(':content', $content), array(':parentId', $parentId), array(':button', $button)));
        
        // Update current element to child = 1 in database
        $sql= "update nodes set hasChild = '1' where ID = :id";
        $db->executeWithParam($sql, array(array(':id', $parentId)));
        
        $db = null;
        return $result;
    }
}

   
