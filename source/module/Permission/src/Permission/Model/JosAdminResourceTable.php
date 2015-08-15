<?php
namespace Permission\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Permission\Model\Entity\JosAdminResource;

class JosAdminResourceTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Permission/Controller/User loginAction
    */

    public function getResourceByUsername($username)
    {
    	$adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_users'));
        $sqlSelect->columns(array());
        $sqlSelect->join(array('t2'=>'jos_admin_role'), 't1.usertype=t2.role_name', array('role_id'), 'LEFT');
        $sqlSelect->join(array('t3'=>'jos_admin_rule'), 't2.role_id=t3.role_id', array(), 'LEFT');
        $sqlSelect->join(array('t4'=>'jos_admin_resource'), 't3.resource_id=t4.resource_id', array('action'=>'resource', 'resource_id'), 'LEFT');
        $sqlSelect->join(array('t5'=>'jos_admin_resource'), 't4.parent_id=t5.resource_id', array('controller'=>'resource'), 'LEFT');
        $sqlSelect->where(array('username'=>$username));
	       
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = $this->getResourceByWhiteList(1);
        foreach ($resultSets as $key => $resultSet) {
            $allRow[$resultSet['resource_id']] = $resultSet;
        }
        return $allRow;
    }

    /*
        sử dụng trong getResourceByUsername
        sử dụng trong ACL/Module.php
    */
    public function getResourceByWhiteList($is_white_list)
    {
    	/*
			nếu $is_white_list==0 : lấy tất cả vs điều kiện columns is_white_list=0
			nếu $is_white_list==1 : lấy tất cả vs điều kiện columns is_white_list=1
			nếu $is_white_list==2 : lấy tất cả
    	*/
    	$adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_admin_resource'));
        $sqlSelect->columns(array('action'=>'resource', 'resource_id'));
        $sqlSelect->join(array('t2'=>'jos_admin_resource'), 't1.parent_id=t2.resource_id', array('controller'=>'resource'), 'LEFT');
        // điều kiện select
        $array_dieu_kien=array();
        $array_dieu_kien['t1.resource_type']='Action';
        if($is_white_list!=2){
        	$array_dieu_kien['t1.is_white_list']=$is_white_list;
        }
        $sqlSelect->where($array_dieu_kien);
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[$resultSet['resource_id']] = $resultSet;
        }
        return $allRow;
    }

    /*
        sử dụng trong Permission/Controller/Permission updateAction
        sử dụng trong Permission/Controller/Permission editAction
    */
    public function saveResource(JosAdminResource $resource)
    {
        $data = array(
            'resource_name' => $resource->getResourceName(),
            'parent_id' => $resource->getParentId(),
            'resource' => $resource->getResource(),
            'resource_type' => $resource->getResourceType(),
            'resource_object' => $resource->getResourceObject(),
            'is_white_list' => $resource->getIsWhiteList(),
            'is_hidden' => $resource->getIsHidden(),
        );
        
        $resource_id = (int) $resource->getResourceId();
        if ($resource_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getResourceByResourceId($resource_id)) {
                $this->tableGateway->update($data, array(
                    'resource_id' => $resource_id
                ));
            } else {
                return false;
            }
        }
        return true;
    }

    /*
        sử dụng trong hàm save
    */
    public function getResourceByResourceId($resource_id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(array(
            'resource_id' => $resource_id
        ));
        $select->columns(array(
            'resource_id',
            'parent_id',
            'resource',
            'resource_name',
            'resource_type'
        ));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
        $resultSets = $statement->execute();
        $row = $resultSets->current();
        if ($row)
            return $row;
        return false;
    }

    /*
        sử dụng trong Permission/Controller/Permission updateAction
    */
    public function getResourceByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_admin_resource'));
        if($array_columns){
            $sqlSelect->columns($array_columns);
        }
        if($array_conditions){
            $sqlSelect->where($array_conditions);
        }
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }
}