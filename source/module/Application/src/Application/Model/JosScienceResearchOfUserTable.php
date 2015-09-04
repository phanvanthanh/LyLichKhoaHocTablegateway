<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Application\Model\Entity\JosScienceResearchOfUser;

class JosScienceResearchOfUserTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 


    public function getScienceResearchByArrayConditionAndArrayColumns($array_conditions=array(), $array_columns=array()){
         /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_science_research_of_user'));
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
    public function getScienceResearchAndScienceActivityByArrayConditionAndArrayColumns($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array()){
         /*
            chuyền vào 3 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột bảng thứ nhất cần lấy ra,
                                    1 tham số là cột bảng thứ 2 cần lấy
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_science_research_of_user'));
        $sqlSelect->join(array('t2'=>'jos_science_activity'), 't1.science_activity_id=t2.value_id', $array_columns_2, 'LEFT');
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

    public function saveJosScienceResearch(JosScienceResearchOfUser $Jos_science_research_of_user)
    {
        $data = array(
            'science_activity_id'       => $Jos_science_research_of_user->getScienceActivityId(),
            'user_id'                   => $Jos_science_research_of_user->getUserId(),
            'time_from'                 => $Jos_science_research_of_user->getTimeFrom(),
            'time_to'                   => $Jos_science_research_of_user->getTimeTo(),
            'note'                      => $Jos_science_research_of_user->getNote(),           
        );   
        $value_id = (int) $Jos_science_research_of_user->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getScienceResearchByArrayConditionAndArrayColumns(array('value_id'=>$value_id), array('user_id'))) {
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
    public function deleteScienceResearchById($id)
    {
        $this->tableGateway->delete(array(
            'value_id' => $id
        ));
    }

    

    
}