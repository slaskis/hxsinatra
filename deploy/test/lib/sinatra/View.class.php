<?php

class sinatra_View {
	public function __construct($template, $layout) {
		if( !php_Boot::$skip_constructor ) {
		if($layout !== null) {
			$this->useLayout = sinatra_View::$defaultLayout;
		}
	}}
	public $useLayout;
	public function render() {
		;
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	static $defaultLayout;
	function __toString() { return 'sinatra.View'; }
}
