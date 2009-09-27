<?php

class sinatra_Base implements haxe_Public{
	public function __construct(){}
	public function before() {
		;
	}
	public function after() {
		;
	}
	public function get($route, $scope, $func) {
		sinatra_Base::$_routes->get(sinatra_HTTPMethod::$GET)->add(sinatra_Route::get($route, $scope, $func));
	}
	public function post($route, $scope, $func) {
		sinatra_Base::$_routes->get(sinatra_HTTPMethod::$POST)->add(sinatra_Route::post($route, $scope, $func));
	}
	public function put($route, $scope, $func) {
		sinatra_Base::$_routes->get(sinatra_HTTPMethod::$PUT)->add(sinatra_Route::put($route, $scope, $func));
	}
	public function delete($route, $scope, $func) {
		sinatra_Base::$_routes->get(sinatra_HTTPMethod::$DELETE)->add(sinatra_Route::delete($route, $scope, $func));
	}
	static $_routes;
	static $request;
	static function run($app) {
		sinatra_Base::$request = new sinatra_Request();
		haxe_Log::trace(sinatra_Base::$request, _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 56, "className" => "sinatra.Base", "methodName" => "run")));
		$route = null;
		$»it = sinatra_Base::$_routes->get(sinatra_Base::$request->method)->iterator();
		while($»it->hasNext()) {
		$r = $»it->next();
		{
			if(sinatra_Route::match($r->route, sinatra_Base::$request->path)) {
				$route = $r;
				break;
			}
			;
		}
		}
		if($route === null) {
			throw new HException("Found no route matching \"" . sinatra_Base::$request->path . "\"");
		}
		$view = null;
		try {
			$view = $route->call();
		}catch(Exception $»e) {
		$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
		;
		if(is_int($code = $_ex_)){
			haxe_Log::trace("CODE:" . Std::string($code), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 76, "className" => "sinatra.Base", "methodName" => "run")));
		}
		else if(is_string($err = $_ex_)){
			haxe_Log::trace("ERR:" . $err . " stack: " . haxe_Stack::toString(haxe_Stack::exceptionStack()), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 78, "className" => "sinatra.Base", "methodName" => "run")));
		}
		else { $other = $_ex_;
		{
			haxe_Log::trace("WARN:" . Std::string($other), _hx_anonymous(array("fileName" => "Base.hx", "lineNumber" => 80, "className" => "sinatra.Base", "methodName" => "run")));
		}}}
		if($view !== null) {
			$view->render();
		}
		return 0;
	}
	function __toString() { return 'sinatra.Base'; }
}
{
	sinatra_Base::$_routes = new sinatra_utils_EnumHash();
	sinatra_Base::$_routes->set(sinatra_HTTPMethod::$GET, new HList());
	sinatra_Base::$_routes->set(sinatra_HTTPMethod::$POST, new HList());
	sinatra_Base::$_routes->set(sinatra_HTTPMethod::$PUT, new HList());
	sinatra_Base::$_routes->set(sinatra_HTTPMethod::$DELETE, new HList());
}
