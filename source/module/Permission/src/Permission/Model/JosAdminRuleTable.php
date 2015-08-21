<?php
namespace Permission\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Permission\Model\Entity\JosAdminRule;

class JosAdminRuleTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Permission/Controller/Permission indexAction
    */
    public function deleteRuleByRoleId($role_id)
    {
        $this->tableGateway->delete(array(
            'role_id' => $role_id
        ));
    }

    /*
        sử dụng trong Permission/Controller/Permission indexAction
    */
    public function saveResource(JosAdminRule $rule)
    {
        $data = array(
            'rule_id' => $rule->getRuleId(),
            'role_id' => $rule->getRoleId(),
            'resource_id' => $rule->getResourceId()            
        );
        
        $rule_id = (int) $rule->getRuleId();
        if ($rule_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getRuleByArrayConditionAndArrayColumn(array('rule_id'=>$rule_id), array('resource_id'))) {
                $this->tableGateway->update($data, array(
                    'rule_id' => $rule_id
                ));
            } else {
                return false;
            }
        }
        return true;
    }

    /*
        sử dụng trong saveResource
    */
    public function getRuleByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_admin_rule'));
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