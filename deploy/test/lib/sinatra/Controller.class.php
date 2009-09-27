<?php

class sinatra_Controller implements haxe_Public{
	public function __construct(){}
	public $request;
	public $params;
	public $session;
	public $cookies;
	public function redirect($route) {
		$this->getRequest()->redirect($route);
	}
	public function getRequest() {
		return sinatra_Base::$request;
	}
	public function getParams() {
		return sinatra_Base::$request->params;
	}
	public function getSession() {
		return sinatra_Base::$request->session;
	}
	public function getCookies() {
		return sinatra_Base::$request->cookies;
	}
	function __toString() { return 'sinatra.Controller'; }
}
