<?php

class Params {
	public function __construct() { ;
		;
	}
	private $»dynamics = array();
	public function &__get($n) {
		if(isset($this->»dynamics[$n]))
			return $this->»dynamics[$n];
	}
	public function __set($n, $v) {
		$this->»dynamics[$n] = $v;
	}
	public function __call($n, $a) {
		if(is_callable($this->»dynamics[$n]))
			return call_user_func_array($this->»dynamics[$n], $a);
		throw new HException("Unable to call «".$n."»");
	}
	function __toString() { return 'Params'; }
}
