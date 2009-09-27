<?php

class Reflect {
	public function __construct(){}
	static function hasField($o, $field) {
		return _hx_has_field($o, $field);
	}
	static function field($o, $field) {
		return _hx_field($o, $field);
	}
	static function setField($o, $field, $value) {
		$o->{$field} = $value;
	}
	static function callMethod($o, $func, $args) {
		if(is_string($o)) {
			if($args->length === 0) {
				return call_user_func(Reflect::field($o, $func));
			}
			else {
				if($args->length === 1) {
					return call_user_func(Reflect::field($o, $func), $args[0]);
				}
				else {
					return call_user_func(Reflect::field($o, $func), $args[0], $args[1]);
				}
			}
		}
		return call_user_func_array(is_callable($func) ? $func : array($o, $func) , $args == null ? array() : $args->�a);
	}
	static function fields($o) {
		if($o === null) {
			return new _hx_array(array());
		}
		return ($o instanceof _hx_array ? new _hx_array(array('concat','copy','insert','iterator','length','join','pop','push','remove','reverse','shift','slice','sort','splice','toString','unshift')) : ((is_string($o) ? new _hx_array(array('charAt','charCodeAt','indexOf','lastIndexOf','length','split','substr','toLowerCase','toString','toUpperCase')) : new _hx_array(array_keys(get_object_vars($o))))));
	}
	static function isFunction($f) {
		return (is_array($f) && is_callable($f)) || _hx_is_lambda($f) || (is_array($f) && _hx_has_field($f[0], $f[1]) && $f[1] != "length");
	}
	static function compare($a, $b) {
		return (($a === $b) ? 0 : (((($a) > ($b)) ? 1 : -1)));
	}
	static function compareMethods($f1, $f2) {
		if(_hx_equal($f1, $f2)) {
			return true;
		}
		if(!Reflect::isFunction($f1) || !Reflect::isFunction($f2)) {
			return false;
		}
		if(is_array($f1) && is_array($f1)) {
			return $f1[0] === $f2[0] && $f1[1] == $f2[1];
		}
		if(is_string($f1) && is_string($f2)) {
			return _hx_equal($f1, $f2);
		}
		return false;
	}
	static function isObject($v) {
		if($v === null) {
			return false;
		}
		if(is_object($v)) {
			return $v instanceof _hx_anonymous || Type::getClass($v) !== null;
		}
		if(is_string($v) && !_hx_is_lambda($v)) {
			return true;
		}
		return false;
	}
	static function deleteField($o, $f) {
		if(!_hx_has_field($o, $f)) {
			return false;
		}
		unset($o->$f);
		return true;
	}
	static function copy($o) {
		if(is_string($o)) {
			return $o;
		}
		$o2 = _hx_anonymous(array());
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$o2->{$f} = Reflect::field($o, $f);
				unset($f);
			}
		}
		return $o2;
	}
	static function makeVarArgs($f) {
		return array(new _hx_lambda(array('f' => &$f), null, array('args'), 'return call_user_func($f, new _hx_array($args));'), 'makeArgs');
	}
	function __toString() { return 'Reflect'; }
}
