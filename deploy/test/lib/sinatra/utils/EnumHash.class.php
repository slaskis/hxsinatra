<?php

class sinatra_utils_EnumHash {
	public function __construct() {
		if( !php_Boot::$skip_constructor ) {
		$this->_hash = new Hash();
	}}
	public $_hash;
	public function set($key, $value) {
		$this->_hash->set(Type::getEnumName(Type::getEnum($key)), $value);
	}
	public function get($key) {
		return $this->_hash->get(Type::getEnumName(Type::getEnum($key)));
	}
	public function exists($key) {
		return $this->_hash->exists(Type::getEnumName(Type::getEnum($key)));
	}
	public function remove($key) {
		return $this->_hash->remove(Type::getEnumName(Type::getEnum($key)));
	}
	public function keys() {
		return $this->_hash->keys();
	}
	public function iterator() {
		return $this->_hash->iterator();
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	function __toString() { return 'sinatra.utils.EnumHash'; }
}
