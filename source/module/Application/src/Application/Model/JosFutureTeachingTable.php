<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\JosFutureTeaching;

class JosFutureTeachingTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 

    public function getFutureTeachingByArrayConditionAndArrayColumns($array_conditions=array(), $array_columns=array()){
         /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_future_teaching'));
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
        sử dụng trong Application/Controller/Index indexAction
    */
    public function getFutureTeachingAndSubjectByArrayConditionAndArrayColumns($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array()){
         /*
            chuyền vào 3 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột bảng thứ nhất cần lấy ra,
                                    1 tham số là cột bảng thứ 2 cần lấy
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_future_teaching'));
        $sqlSelect->join(array('t2'=>'jos_subject'), 't1.subject_id=t2.value_id', $array_columns_2, 'LEFT');
        if($array_columns_1){
            $sqlSelect->columns($array_columns_1);
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

    public function saveJosFutureTeaching(JosFutureTeaching $jos_future_teaching)
    {
        $data = array(
            'subject_id'        => $jos_future_teaching->getSubjectId(),
            'user_id'           => $jos_future_teaching->getUserId(),
            'lesson_number'     => $jos_future_teaching->getLessonNumber(),
            'qualifications'    => $jos_future_teaching->getQualifications(),
            'edu_system'        => $jos_future_teaching->getEduSystem(),
            'note'              => $jos_future_teaching->getNote(),           
        );   
        $value_id = (int) $jos_future_teaching->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getFutureTeachingByArrayConditionAndArrayColumns(array('value_id'=>$value_id), array('user_id'))) {
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
    public function deleteFutureTeachingById($id)
    {
        $this->tableGateway->delete(array(
            'value_id' => $id
        ));
    }

    
}