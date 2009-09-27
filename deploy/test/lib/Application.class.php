<?php

class Application extends sinatra_Base {
	public function __construct() { if( !php_Boot::$skip_constructor ) {
		$this->get("/", _hx_qtype("controller.Home"), "index");
		$this->get("/user/:id", _hx_qtype("controller.User"), "get");
		$this->get("/user", _hx_qtype("controller.User"), "get");
		$this->post("/user", _hx_qtype("controller.User"), "update");
		$this->put("/user", _hx_qtype("controller.User"), "create");
		$this->delete("/user", _hx_qtype("controller.User"), "delete");
	}}
	static function main() {
		sinatra_Base::run(new Application());
	}
	function __toString() { return 'Application'; }
}
