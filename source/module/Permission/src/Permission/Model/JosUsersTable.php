<?php
namespace Permission\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Permission\Model\Entity\JosUsers;

class JosUsersTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Application/View/Helper/Layout.php
    */
    public function getDanhSachGiangVien($array=array()){
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);
        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_users'));
        $sqlSelect->columns(array('id', 'name'));
        //$sqlSelect->where('t1.usertype!="Super Administrator"');        
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }

    public function getGiangVienByArrayConditionAndArrayColumns($array_conditions, $array_columns){
         /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_users'));
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