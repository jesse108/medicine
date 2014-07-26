<?php
class Foo{
	public function echoData(){
		$data = $this->getData();
		echo $data;
	}
	
	public function getData(){
		return "Foo";
	}
	
}


class Soo extends Foo{
	public function getData(){
		return 'Soo';
	}
}


$obj = new Soo();
$obj->echoData();