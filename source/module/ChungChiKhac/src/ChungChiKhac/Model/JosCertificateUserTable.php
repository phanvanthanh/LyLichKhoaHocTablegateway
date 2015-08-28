<?php
namespace ChungChiKhac\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use ChungChiKhac\Model\Entity\JosCertificateUser;

class JosCertificateUserTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /*
        sử dụng trong Application\Controller\IndexController editAction
    */
    public function getCertificateUserAndCertificateByArrayConditionAndArrayColumns($array_conditions=array(), $array_columns_1=array(), $array_columns_2=array()){
         /*
            chuyền vào 3 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột bảng thứ nhất cần lấy ra,
                                    1 tham số là cột bảng thứ 2 cần lấy
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_certificate_user'));
        $sqlSelect->join(array('t2'=>'jos_certificate'), 't1.certificate_id=t2.value_id', $array_columns_2, 'LEFT');
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
   	
}