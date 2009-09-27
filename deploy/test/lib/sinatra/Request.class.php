<?php

class sinatra_Request {
	public function __construct() {
		if( !php_Boot::$skip_constructor ) {
		$this->method = eval("if(isset(\$this)) \$»this =& \$this;switch(strtoupper(php_Web::getMethod())) {
			case \"GET\":{
				\$»r = sinatra_HTTPMethod::\$GET;
			}break;
			case \"POST\":{
				\$»r = sinatra_HTTPMethod::\$POST;
			}break;
			case \"PUT\":{
				\$»r = sinatra_HTTPMethod::\$PUT;
			}break;
			case \"DELETE\":{
				\$»r = sinatra_HTTPMethod::\$DELETE;
			}break;
			default:{
				\$»r = eval(\"if(isset(\\\$this)) \\\$»this =& \\\$this;throw new HException(\\\"Invalid HTTP Method\\\");
					return \\\$»r2;
				\");
			}break;
			}
			return \$»r;
		");
		$this->params = php_Web::getParams();
		$this->uri = sinatra_utils_URI::parse(php_Web::getURI());
		$this->path = $this->uri->path;
		$this->headers = new Hash();
		$»it = php_Web::getClientHeaders()->iterator();
		while($»it->hasNext()) {
		$h = $»it->next();
		$this->headers->set($h->header, $h->value);
		}
	}}
	public $uri;
	public $path;
	public $headers;
	public $session;
	public $cookies;
	public $params;
	public $method;
	public function toString() {
		return "[Request method:" . $this->method . " uri:" . $this->uri . " headers:" . $this->headers . "]";
	}
	public function redirect($route) {
		php_Web::redirect($route);
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	function __toString() { return $this->toString(); }
}
