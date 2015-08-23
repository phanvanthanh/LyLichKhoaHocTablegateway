<?php
namespace NamHoc\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use NamHoc\Model\Entity\JosYear;

class JosYearTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong CongTacNghienCuu/Controller/CongTacNghienCuu addAction
        sử dụng trong NamHoc/Controller/NamHoc indexAction
        sử dụng trong NamHoc/Controller/NamHoc kichHoatAction
        sử dụng trong MonHoc/Controller/MonHoc addAction
        sử dụng trong saveYear
        sử dụng trong ChungChiKhac/Controller/ChungChiKhac AddAction
        sử dụng trong ChungChiKhac/Controller/ChungChiKhac editAction
        sử dụng trong Attribute/Controller/Attribute addAction
        sử dụng trong Attribute/Controller/Attribute editAction
        sử dụng trong Attribute/Controller/Attribute editInforAction
    */
    public function getYearByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_year'));
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
        sử dụng trong NamHoc/Controller/NamHoc kichHoatAction
    */
    public function saveYear(JosYear $jos_year){
        $data = array(
            'is_active' => $jos_year->getIsActive(),
            'year_id'   => $jos_year->getYearId(),                       
        );
        
        $year_id = (int) $jos_year->getYearId();        
        if ($this->getYearByArrayConditionAndArrayColumn(array('year_id'=>$year_id),array('year_id'))) {
            $this->tableGateway->update($data, array(
                'year_id' => $year_id
            ));
        } else {
            $this->tableGateway->insert($data);
        }
        
    }

    /*
        sử dụng trong NamHoc/Controller/NamHoc deleteAction
    */
    public function deleteYearByYearId($year_id)
    {
        $this->tableGateway->delete(array(
            'year_id' => $year_id
        ));
    }
   	
}