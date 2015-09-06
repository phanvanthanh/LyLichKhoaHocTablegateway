<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\JosFutureOrtherWork;

class JosFutureOrtherWorkTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 


    public function getFutureOrtherWorkByArrayConditionAndArrayColumns($array_conditions=array(), $array_columns=array()){
         /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_future_orther_work'));
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
    

    public function saveJosFutureOrtherWork(JosFutureOrtherWork $jos_future_orther_work)
    {
        $data = array(
            'content'                   => $jos_future_orther_work->getContent(),
            'user_id'                   => $jos_future_orther_work->getUserId(),
            'year_id'                   => $jos_future_orther_work->getYearId(),
            'time_from'                 => $jos_future_orther_work->getTimeFrom(),
            'time_to'                   => $jos_future_orther_work->getTimeTo(),
            'note'                      => $jos_future_orther_work->getNote(),           
        );   
        $value_id = (int) $jos_future_orther_work->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getFutureOrtherWorkByArrayConditionAndArrayColumns(array('value_id'=>$value_id), array('user_id'))) {
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
    public function deleteFutureOrtherWorkById($id)
    {
        $this->tableGateway->delete(array(
            'value_id' => $id
        ));
    }

    

    
}