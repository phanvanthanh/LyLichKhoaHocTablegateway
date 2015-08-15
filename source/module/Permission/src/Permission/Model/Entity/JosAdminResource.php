<?php
namespace Permission\Model\Entity;

class JosAdminResource
{

    protected $resource_id;

    protected $parent_id;
    
    protected $resource;

    protected $resource_name;

    protected $resource_type;

    protected $resource_object;

    protected $is_white_list;

    protected $is_hidden;

    public function exchangeArray($data)
    {
        $this->resource_id = (isset($data['resource_id'])) ? $data['resource_id'] : null;
        $this->parent_id = (isset($data['parent_id'])) ? $data['parent_id'] : null;
        $this->resource = (isset($data['resource'])) ? $data['resource'] : null;
        $this->resource_name = (isset($data['resource_name'])) ? $data['resource_name'] : 'Resource New';
        $this->resource_type = (isset($data['resource_type'])) ? $data['resource_type'] : null;
        $this->resource_object = (isset($data['resource_object'])) ? $data['resource_object'] : "ACL";
        $this->is_white_list = (isset($data['is_white_list'])) ? $data['is_white_list'] : 0;
        $this->is_hidden = (isset($data['is_hidden'])) ? $data['is_hidden'] : 0;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setResourceId($resource_id)
    {
        $this->resource_id = $resource_id;
    }

    public function getResourceId()
    {
        return $this->resource_id;
    }

    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    public function getParentId()
    {
        return $this->parent_id;
    }

    public function setResourceUrl($resource_url)
    {
        $this->resource_url = $resource_url;
    }

    public function getResourceUrl()
    {
        return $this->resource_url;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setResourceName($resource_name)
    {
        $this->resource_name = $resource_name;
    }

    public function getResourceName()
    {
        return $this->resource_name;
    }

    public function setResourceType($resource_type)
    {
        $this->resource_type = $resource_type;
    }

    public function getResourceType()
    {
        return $this->resource_type;
    }

    public function setResourceObject($resource_object)
    {
        $this->resource_object = $resource_object;
    }

    public function getResourceObject()
    {
        return $this->resource_object;
    }

    public function setIsWhiteList($is_white_list){
        $this->is_white_list=$is_white_list;
    }
    public function getIsWhiteList(){
        return $this->is_white_list;
    }

    public function setIsHidden($is_hidden){
        $this->is_hidden=$is_hidden;
    }
    public function getIsHidden(){
        return $this->is_hidden;
    }
}
