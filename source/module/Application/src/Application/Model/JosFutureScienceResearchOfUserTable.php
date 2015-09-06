<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\JosFutureScienceResearchOfUser;

class JosFutureScienceResearchOfUserTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 


    public function getFutureScienceResearchByArrayConditionAndArrayColumns($array_conditions=array(), $array_columns=array()){
         /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_future_science_research_of_user'));
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
    

    public function saveJosFutureScienceResearch(JosFutureScienceResearchOfUser $Jos_future_science_research_of_user)
    {
        $data = array(
            'science_activity_name'     => $Jos_future_science_research_of_user->getScienceActivityName(),
            'user_id'                   => $Jos_future_science_research_of_user->getUserId(),
            'year_id'                   => $Jos_future_science_research_of_user->getYearId(),
            'time_from'                 => $Jos_future_science_research_of_user->getTimeFrom(),
            'time_to'                   => $Jos_future_science_research_of_user->getTimeTo(),
            'note'                      => $Jos_future_science_research_of_user->getNote(),           
        );   
        $value_id = (int) $Jos_future_science_research_of_user->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getFutureScienceResearchByArrayConditionAndArrayColumns(array('value_id'=>$value_id), array('user_id'))) {
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
    public function deleteFutureScienceResearchById($id)
    {
        $this->tableGateway->delete(array(
            'value_id' => $id
        ));
    }

    

    
}