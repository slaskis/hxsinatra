<?php

class sinatra_Route {
	public function __construct($method, $route, $scope, $func) {
		if( !php_Boot::$skip_constructor ) {
		$this->method = $method;
		$this->route = $route;
		$this->scope = $scope;
		$this->func = $func;
	}}
	public $method;
	public $route;
	public $scope;
	public $func;
	public function call() {
		$obj = Type::createEmptyInstance($this->scope);
		$method = Reflect::field($obj, $this->func);
		if($method === null) {
			throw new HException($obj . " does not contain " . $this->func);
		}
		if(!Reflect::isFunction($method)) {
			throw new HException($this->func . " is not a method of " . $obj);
		}
		$ret = Reflect::callMethod($obj, $method, new _hx_array(array()));
		haxe_Log::trace("Returned: " . $ret, _hx_anonymous(array("fileName" => "Route.hx", "lineNumber" => 28, "className" => "sinatra.Route", "methodName" => "call")));
		return (Std::is($ret, _hx_qtype("String")) ? new sinatra_View($ret, null) : eval("if(isset(\$this)) \$»this =& \$this;\$tmp = \$ret;
			\$»r = (Std::is(\$tmp, _hx_qtype(\"sinatra.View\")) ? \$tmp : eval(\"if(isset(\\\$this)) \\\$»this =& \\\$this;throw new HException(\\\"Class cast error\\\");
				return \\\$»r2;
			\"));
			return \$»r;
		"));
	}
	public function toString() {
		return "[Route method:" . $this->method . " at:" . $this->route . " to:" . Type::getClassName($this->scope) . "#" . $this->func . "]";
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	static function get($route, $scope, $func) {
		return new sinatra_Route(sinatra_HTTPMethod::$GET, $route, $scope, $func);
	}
	static function post($route, $scope, $func) {
		return new sinatra_Route(sinatra_HTTPMethod::$POST, $route, $scope, $func);
	}
	static function put($route, $scope, $func) {
		return new sinatra_Route(sinatra_HTTPMethod::$PUT, $route, $scope, $func);
	}
	static function delete($route, $scope, $func) {
		return new sinatra_Route(sinatra_HTTPMethod::$DELETE, $route, $scope, $func);
	}
	static function match($route, $path) {
		$parser = new sinatra_RouteParser($route);
		$matched = $parser->match($path);
		haxe_Log::trace("Matched? " . $matched . " " . $route . " " . $path, _hx_anonymous(array("fileName" => "Route.hx", "lineNumber" => 70, "className" => "sinatra.Route", "methodName" => "match")));
		if($matched) {
			;
		}
		return $matched;
	}
	function __toString() { return $this->toString(); }
}
