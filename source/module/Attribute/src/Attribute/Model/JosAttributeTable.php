<?php
namespace Attribute\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Attribute\Model\Entity\JosAttribute;

class JosAttributeTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Attribute/Controller/Attribute addAction
        sử dụng trong Attribute/Controller/Attribute deleteAction
        sử dụng trong Attribute/Controller/Attribute editAction
        sử dụng trong Attribute/Controller/Attribute editOptionAction
        sử dụng trong Application/Controller/IndexController editInforAction
    */
    public function getAttributeByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_attribute'));
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
        Attribute\Controller\AttributeController indexAction
        Application\Controller\IndexController indexAction
        Application\Controller\IndexController editAction
    */
    public function getAttributeByYearActive($array_columns=array()){
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_attribute'));
        if($array_columns){
            $sqlSelect->columns($array_columns);
        }
        $sqlSelect->join(array('t2'=>'jos_year'), 't1.year_id=t2.year_id', array(), 'LEFT');
        $sqlSelect->where(array('t2.is_active'=>1));
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
    public function deleteAttributeById($id)
    {
        $this->tableGateway->delete(array(
            'attribute_id' => $id
        ));
    }

   /*
        sử dụng trong Attribute/Controller/Attribute addAction
        sử dụng trong Attribute/Controller/Attribute editAction
    */

    public function saveAttribute(JosAttribute $attribute)
    {
        $data = array(
            'attribute_code'    => $attribute->getAttributeCode(),
            'year_id'           => $attribute->getYearId(),
            'frontend_input'    => $attribute->getFrontendInput(),
            'frontend_label'    => $attribute->getFrontendLabel(),
            'value_table'       => $attribute->getValueTable()            
        );   
        $attribute_id = (int) $attribute->getAttributeId();
        if ($attribute_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAttributeByArrayConditionAndArrayColumn(array('attribute_id'=>$attribute_id), array('attribute_code'))) {
                $this->tableGateway->update($data, array(
                    'attribute_id' => $attribute_id
                ));
            } else {
                return false;
            }
        }
        return true;
    }
   	
}