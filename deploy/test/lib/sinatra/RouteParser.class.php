<?php

class sinatra_RouteParser {
	public function __construct($route) {
		if( !php_Boot::$skip_constructor ) {
		$this->str = $route;
	}}
	public $str;
	public function match($path) {
		$ereg = $this->parse();
		$matched = $ereg->match($path);
		if($matched) {
			;
		}
		return $matched;
	}
	public function parse() {
		if(_hx_deref(new EReg("\\*|\\?", ""))->match($this->str)) {
			return $this->glob();
		}
		if(_hx_deref(new EReg(":\\w+", ""))->match($this->str)) {
			return $this->key();
		}
		return new EReg("^" . $this->str . "\$", "i");
	}
	public function key() {
		$reg = "^";
		$chars = _hx_explode("", $this->str);
		$ch = "";
		$inKey = false;
		$keyName = "";
		$matchIndex = 0;
		$keys = new Hash();
		while(($ch = $chars->shift()) !== null) {
			if($ch == ":") {
				$matchIndex++;
				$keyName = "";
				$inKey = true;
			}
			else {
				if($inKey && _hx_deref(new EReg("[^a-z]", "i"))->match($ch)) {
					$inKey = false;
					$keys->set($keyName, $matchIndex);
					$reg .= "([a-zA-Z0-9]+)" . $this->escape($ch);
				}
				else {
					if($inKey) {
						$keyName .= $ch;
					}
					else {
						$reg .= $this->escape($ch);
					}
				}
			}
			;
		}
		if($inKey) {
			$keys->set($keyName, $matchIndex);
			$reg .= "([a-zA-Z0-9]+)";
		}
		$reg .= "\$";
		haxe_Log::trace("(key) From pattern: " . $this->str . " we created expression: " . $reg . " and found these keys: " . $keys, _hx_anonymous(array("fileName" => "Route.hx", "lineNumber" => 144, "className" => "sinatra.RouteParser", "methodName" => "key")));
		return new EReg($reg, "");
	}
	public function escape($ch) {
		return eval("if(isset(\$this)) \$»this =& \$this;switch(\$ch) {
			case \".\":case \"+\":case \"*\":{
				\$»r = \"\\\\\" . \$ch;
			}break;
			default:{
				\$»r = \$ch;
			}break;
			}
			return \$»r;
		");
	}
	public function glob() {
		$reg = "^";
		$chars = _hx_explode("", $this->str);
		$ch = "";
		$wild = 0;
		$single = 0;
		$or = false;
		while(true) {
			switch($ch) {
			case "*":{
				$wild++;
			}break;
			case "?":{
				$single++;
			}break;
			case "{":{
				$reg .= "(?:";
				$or = true;
			}break;
			case ",":{
				if($or) {
					$reg .= "|";
				}
				else {
					$reg .= $ch;
				}
			}break;
			case "}":{
				$reg .= ")";
				$or = false;
			}break;
			default:{
				if($single > 0) {
					$reg .= "[^/]{" . $single . "}";
					$single = 0;
				}
				else {
					if($wild === 1) {
						$reg .= "[^/]*";
						$wild = 0;
					}
					else {
						if($wild === 2) {
							$reg .= ".*";
							$wild = 0;
						}
					}
				}
				if($ch !== null) {
					$reg .= $ch;
				}
			}break;
			}
			if($ch === null) {
				break;
			}
			$ch = $chars->shift();
			;
		}
		$reg .= "\$";
		haxe_Log::trace("(glob) From pattern: " . $this->str . " we created expression: " . $reg, _hx_anonymous(array("fileName" => "Route.hx", "lineNumber" => 211, "className" => "sinatra.RouteParser", "methodName" => "glob")));
		return new EReg($reg, "");
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	function __toString() { return 'sinatra.RouteParser'; }
}
