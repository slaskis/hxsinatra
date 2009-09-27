<?php

class Application extends sinatra_Base {
	public function __construct() { if( !php_Boot::$skip_constructor ) {
		$this->get("/", _hx_qtype("controller.Home"), "index");
		$this->get("/user/:id.:format", _hx_qtype("controller.User"), "get");
		$this->get("/user/(\\d+)", _hx_qtype("controller.User"), "get");
		$this->get("/user/**/*.xml", _hx_qtype("controller.User"), "get");
		$this->post("/user", _hx_qtype("controller.User"), "update");
		$this->put("/user", _hx_qtype("controller.User"), "create");
		$this->delete("/user", _hx_qtype("controller.User"), "delete");
		$p = new Params();
		$p->id = "123";
		$p[0] = "321";
		haxe_Log::trace($p, _hx_anonymous(array("fileName" => "Application.hx", "lineNumber" => 23, "className" => "Application", "methodName" => "new")));
	}}
	static function main() {
		sinatra_Base::run(new Application());
	}
	function __toString() { return 'Application'; }
}
