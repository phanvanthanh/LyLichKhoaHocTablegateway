<?php
namespace Permission\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use Permission\Model\Entity\JosUserLasttimeLogin;

class JosUserLasttimeLoginTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Permission\Controller\User loginAction
    */
    public function getJosUserLasttimeLoginByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_user_lasttime_login'));
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
        sử dụng trong Permission\Controller\User loginAction
    */
    public function saveJosUserLasttimeLogin(JosUserLasttimeLogin $jos_user_lasttime_login)
    {
        $data = array(
            'user_id' => $jos_user_lasttime_login->getUserId(),
            'lasttime_login' => $jos_user_lasttime_login->getLasttimeLogin(),
        );
        
        $value_id = (int) $jos_user_lasttime_login->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getJosUserLasttimeLoginByArrayConditionAndArrayColumn(array('value_id'=>$value_id), array())) {
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