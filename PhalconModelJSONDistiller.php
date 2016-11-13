<?php
use Phalcon\Mvc\Model;
class MyModel extends Model
{
   
   public function set($data){
		if (is_array($data)){
			distill($data);
		}
   }
   
   public function json($decoded_json){
		$this->distill($decoded_json);
   }
   
   private function distill($decoded_json, $type=null){
	try{
		
		if ($type !== null){
			$object = new get_class($type)();
		}else{
			$object = $this;
		}
		$child_classes = array();
		
		foreach ($decoded_json as $key => $value) {
			
			if (is_array($value)){
				$child_classes[$value] = array();
				foreach($value as $child){
					$child_classes[$value] = $this->distill($child, new $value());
				}				
			}else {
					$object->{$key} = $value;
			}			
		}		
		foreach($child_classes as $child_key => $child_value){
				$object->{$child_key} = $child_value;		
		}
	}catch($e){
		throw $e;
	}
	
	}
   
}
    