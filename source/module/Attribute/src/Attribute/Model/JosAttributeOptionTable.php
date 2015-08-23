<?php
namespace Attribute\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Attribute\Model\Entity\JosAttributeOption;

class JosAttributeOptionTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Attribute/Controller/Attribute addAction
        sử dụng trong Application/Form/EditInforForm
        sử dụng trong Attribute/Controller/Attribute editOptionAction
    */
    public function getAttributeOptionByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_attribute_option'));
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

   

   /*
        chưa sử dụng
    */
    public function deleteAttributeOptionById($id)
    {
        $this->tableGateway->delete(array(
            'value_id' => $id
        ));
    }

    /*
        sử dụng trong Attribute/Controller/Attribute editAction
        sử dụng trong Attribute/Controller/Attribute editOptionAction
    */
    public function deleteAttributeOptionByAttributeId($attribute_id)
    {
        $this->tableGateway->delete(array(
            'attribute_id' => $attribute_id
        ));
    }

   /*
        sử dụng trong Attribute/Controller/Attribute addAction
        sử dụng trong Attribute/Controller/Attribute editAction
        sử dụng trong Attribute/Controller/Attribute editOptionAction
    */

    public function saveAttributeOption(JosAttributeOption $attribute_option)
    {
        $data = array(
            'attribute_id'    => $attribute_option->getAttributeId(),
            'key'           => $attribute_option->getKey(),
            'label'    => $attribute_option->getLabel()                    
        );   
        $value_id = (int) $attribute_option->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAttributeOptionByArrayConditionAndArrayColumn(array('value_id'=>$value_id), array('key', 'value'))) {
                $this->tableGateway->update($data, array(
                    'value_id' => $value_id
                ));
            } else {
                return false;
            }
        }
        return true;
    }
   	
}