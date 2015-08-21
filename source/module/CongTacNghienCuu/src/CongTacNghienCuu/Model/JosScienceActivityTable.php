<?php
namespace CongTacNghienCuu\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use CongTacNghienCuu\Model\Entity\JosScienceActivity;

class JosScienceActivityTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong hàm saveScienceActivity
        sử dụng trong CongTacNghienCuu/Controller/CongTacNghienCuu addAction
        sử dụng trong CongTacNghienCuu/Controller/CongTacNghienCuu editAction
        sử dụng trong CongTacNghienCuu/Controller/CongTacNghienCuu deleteAction
    */
    public function getScienceActivityByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_science_activity'));
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
        sử dụng trong CongTacNghienCuu/Controller/CongTacNghienCuu indexAction
    */
    public function getScienceActivityByYearActive($array_columns=array()){
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_science_activity'));
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
        sử dụng trong CongTacNghienCuu/Controller/CongTacNghienCuu addAction
        sử dụng trong CongTacNghienCuu/Controller/CongTacNghienCuu editAction
    */
    public function saveScienceActivity(JosScienceActivity $josScienceActivity){
        $data = array(
            'name' => $josScienceActivity->getName(),
            'year_id' => $josScienceActivity->getYearId(),            
        );
        
        $value_id = (int) $josScienceActivity->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getScienceActivityByArrayConditionAndArrayColumn(array('value_id'=>$value_id),array('value_id'))) {
                $this->tableGateway->update($data, array(
                    'value_id' => $value_id
                ));
            } else {
                return false;
            }
        }
        return true;
    }

    /*
        sử dụng trong CongTacNghienCuu/Controller/CongTacNghienCuu deleteAction
    */
    public function deleteScienceActivityById($id)
    {
        $this->tableGateway->delete(array(
            'value_id' => $id
        ));
    }

   	
}