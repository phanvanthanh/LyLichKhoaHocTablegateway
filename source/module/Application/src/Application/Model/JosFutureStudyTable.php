<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\JosFutureStudy;

class JosFutureStudyTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 

    public function getFutureStudyByArrayConditionAndArrayColumns($array_conditions=array(), $array_columns=array()){
         /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_future_study'));
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
    

    public function saveJosFutureStudy(JosFutureStudy $jos_future_study)
    {
        $data = array(
            
            'user_id'                   => $jos_future_study->getUserId(),
            'year_id'                   => $jos_future_study->getYearId(),
            'subject_name'              => $jos_future_study->getSubjectName(),
            'address'                   => $jos_future_study->getAddress(),
            'time_from'                 => $jos_future_study->getTimeFrom(),
            'time_to'                   => $jos_future_study->getTimeTo(),
            'note'                      => $jos_future_study->getNote(),           
        );   
        $value_id = (int) $jos_future_study->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getFutureStudyByArrayConditionAndArrayColumns(array('value_id'=>$value_id), array('user_id'))) {
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
    public function deleteFutureStudyById($id)
    {
        $this->tableGateway->delete(array(
            'value_id' => $id
        ));
    }   

    
}