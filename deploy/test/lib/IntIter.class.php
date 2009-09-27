<?php

class IntIter {
	public function __construct($min, $max) {
		if( !php_Boot::$skip_constructor ) {
		$this->min = $min;
		$this->max = $max;
	}}
	public $min;
	public $max;
	public function hasNext() {
		return $this->min < $this->max;
	}
	public function next() {
		return $this->min++;
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->�dynamics[$m]) && is_callable($this->�dynamics[$m]))
			return call_user_func_array($this->�dynamics[$m], $a);
		else
			throw new HException('Unable to call �'.$m.'�');
	}
	function __toString() { return 'IntIter'; }
}
