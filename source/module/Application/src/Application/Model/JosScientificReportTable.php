<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\JosScientificReport;

class JosScientificReportTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 


    public function getScientificReportByArrayConditionAndArrayColumns($array_conditions=array(), $array_columns=array()){
         /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_scientific_report'));
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
    

    public function saveJosScientificReport(JosScientificReport $jos_scientific_report)
    {
        $data = array(
            'name'                      => $jos_scientific_report->getName(),
            'user_id'                   => $jos_scientific_report->getUserId(),
            'year_id'                   => $jos_scientific_report->getYearId(),
            'publish_date'              => $jos_scientific_report->getPublishDate(),
            'publish_place'             => $jos_scientific_report->getPublishPlace(),
            'note'                      => $jos_scientific_report->getNote(),           
        );   
        $value_id = (int) $jos_scientific_report->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getScientificReportByArrayConditionAndArrayColumns(array('value_id'=>$value_id), array('user_id'))) {
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
        chưa sử dụng
    */
    public function deleteScientificReportById($id)
    {
        $this->tableGateway->delete(array(
            'value_id' => $id
        ));
    }

    

    
}