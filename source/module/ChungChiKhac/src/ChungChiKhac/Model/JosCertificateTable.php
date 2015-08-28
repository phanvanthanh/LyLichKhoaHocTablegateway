<?php
namespace ChungChiKhac\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

use ChungChiKhac\Model\Entity\JosCertificate;

class JosCertificateTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }



    /*
    	Sử dụng trong ChungChiKhac/Controller/ChungChiKhac deleteAction
        Sử dụng trong ChungChiKhac/Controller/ChungChiKhac editAction
    */
    public function getCertificateByArrayConditionAndArrayColumn($array_conditions=array(), $array_columns=array()){
        /*
            chuyền vào 2 tham số:   1 tham số là mảng điều kiện, 
                                    1 tham số là mảng cột cần lấy ra
        */
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_certificate'));
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
        Sử dụng trong ChungChiKhac/Controller/ChungChiKhac indexAction
        Sử dụng trong Application/Controller/IndexController indexAction
        Sử dụng trong Application/Controller/IndexController editAction
        Sử dụng trong Application/Controller/IndexController editCertificateAction
    */
    public function getCertificateByYearActive($array_columns=array()){
        $adapter = $this->tableGateway->adapter;
        $sql = new Sql($adapter);        
        // select
        $sqlSelect = $sql->select();
        $sqlSelect->from(array('t1'=>'jos_certificate'));
        if($array_columns){
            $sqlSelect->columns($array_columns);
        }
        $sqlSelect->join(array('t2'=>'jos_year'), 't1.year_id=t2.year_id', array(), 'LEFT');
        $sqlSelect->where(array('t2.is_active'=>1));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSets = $statement->execute();
        $allRow = array();
        foreach ($resultSets as $key => $resultSet) {
            $allRow[] = $resultSet;
        }
        return $allRow;
    }

    /*
        Sử dụng trong ChungChiKhac/Controller/ChungChiKhac deleteAction
    */
    public function deleteCertificateById($id)
    {
        $this->tableGateway->delete(array(
            'value_id' => $id
        ));
    }

    /*
        Sử dụng trong ChungChiKhac/Controller/ChungChiKhac addAction
        Sử dụng trong ChungChiKhac/Controller/ChungChiKhac editAction
    */

    public function saveCertificate(JosCertificate $certificate)
    {
        $data = array(
            'name' => $certificate->getName(),
            'year_id' => $certificate->getYearId()            
        );        
        $value_id = (int) $certificate->getValueId();
        if ($value_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCertificateByArrayConditionAndArrayColumn(array('value_id'=>$value_id), array('name'))) {
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