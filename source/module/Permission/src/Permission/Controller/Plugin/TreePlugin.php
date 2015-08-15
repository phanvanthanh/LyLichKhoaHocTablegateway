<?php
namespace Permission\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
 
class TreePlugin extends AbstractPlugin{
	// hàm lấy cấp của taxonomy
    private $level=0;
    private $mangTam=array();
    public function outputTree($tree, $root = null) {          
        foreach($tree as $i=>$child) {           
            $parent = $child['parent_id'];
            if($parent == $root) {
                unset($tree[$i]);
                $child['level']=$this->level; 
                $this->mangTam[]=$child;               
                $this->level++;
                $this->outputTree($tree, $child['resource_id']);
                $this->level--;
            } 
            
        }
        return $this->mangTam; 
    }

    public function outputActionInOneBranchOfTree($tree, $root = null) {          
        foreach($tree as $i=>$child) {           
            $parent = $child['parent_id'];
            if($parent == $root) {
                unset($tree[$i]);
                $child['level']=$this->level; 
                if($child['resource_type']=='Action'){
                	$this->mangTam[]=$child;
                }               
                $this->level++;
                $this->outputActionInOneBranchOfTree($tree, $child['resource_id']);
                $this->level--;
            } 
            
        }
        return $this->mangTam; 
    }
}
?>