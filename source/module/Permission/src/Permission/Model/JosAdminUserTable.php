<?php
namespace Permission\Model;

use Zend\Db\TableGateway\TableGateway;
use Permission\Model\Entity\JosAdminUser;

class JosAdminUserTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    
}