<?php

class Node
{
    private $ID;
    private $content;
    private $parentID;
    private $button;
    private $hasChild;

    /**
     * Node constructor.
     * @param $ID
     * @param $content
     * @param $parentID
     * @param $button
     * @param $hasChild
     */
    public function __construct($ID, $content, $parentID, $button, $hasChild)
    {
        $this->ID = $ID;
        $this->content = $content;
        $this->parentID = $parentID;
        $this->button = $button;
        $this->hasChild = $hasChild;
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getParentID()
    {
        return $this->parentID;
    }

    /**
     * @param mixed $parentID
     */
    public function setParentID($parentID): void
    {
        $this->parentID = $parentID;
    }

    /**
     * @return mixed
     */
    public function getButton()
    {
        return $this->button;
    }

    /**
     * @param mixed $button
     */
    public function setButton($button): void
    {
        $this->button = $button;
    }

    /**
     * @return mixed
     */
    public function getHasChild()
    {
        return $this->hasChild;
    }

    /**
     * @param mixed $hasChild
     */
    public function setHasChild($hasChild): void
    {
        $this->hasChild = $hasChild;
    }


}