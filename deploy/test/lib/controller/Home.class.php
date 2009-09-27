<?php

class controller_Home extends sinatra_Controller {
	public function index() {
		return "view/Home.ehx";
	}
	function __toString() { return 'controller.Home'; }
}
