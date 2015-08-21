<?php
namespace MonHoc\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use MonHoc\Model\Entity\JosSubject;

class JosSubjectTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong MonHoc\Controller\MonHoc addAction
        sử dụng trong saveSubject
    */
    public function getSubjectByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_subject'));
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
        sử dụng trong MonHoc\Controller\MonHoc indexAction
    */
    public function getSubjectByYearActive($array_columns=array()){
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_subject'));
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
        sử dụng trong MonHoc/Controller/MonHoc deleteAction
    */
    public function deleteSubjectById($id)
    {
        $this->tableGateway->delete(array(
            'value_id' => $id
        ));
    }

    /*
        Sử dụng trong MonHoc/Controller/MonHoc addAction
    */

    public function saveSubject(JosSubject $subject)
    {
        $data = array(
            'name' => $subject->getName(),
            'year_id' => $subject->getYearId()            
        );        
        $value_id = (int) $subject->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getSubjectByArrayConditionAndArrayColumn(array('value_id'=>$value_id), array('name'))) {
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