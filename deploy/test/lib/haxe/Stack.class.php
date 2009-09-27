<?php

class haxe_Stack {
	public function __construct(){}
	static function callStack() {
		return haxe_Stack::makeStack("%s");
	}
	static function exceptionStack() {
		return haxe_Stack::makeStack("%e");
	}
	static function toString($stack) {
		$b = new StringBuf();
		{
			$_g = 0;
			while($_g < $stack->length) {
				$s = $stack[$_g];
				++$_g;
				$b->b .= "\x0ACalled from ";
				haxe_Stack::itemToString($b, $s);
				unset($s);
			}
		}
		return $b->b;
	}
	static function itemToString($b, $s) {
		$�t = ($s);
		switch($�t->index) {
		case 0:
		{
			$b->b .= "a C function";
		}break;
		case 1:
		$m = $�t->params[0];
		{
			$b->b .= "module ";
			$b->b .= $m;
		}break;
		case 2:
		$line = $�t->params[2]; $file = $�t->params[1]; $s1 = $�t->params[0];
		{
			if($s1 !== null) {
				haxe_Stack::itemToString($b, $s1);
				$b->b .= " (";
			}
			$b->b .= $file;
			$b->b .= " line ";
			$b->b .= $line;
			if($s1 !== null) {
				$b->b .= ")";
			}
		}break;
		case 3:
		$meth = $�t->params[1]; $cname = $�t->params[0];
		{
			$b->b .= $cname;
			$b->b .= ".";
			$b->b .= $meth;
		}break;
		case 4:
		$n = $�t->params[0];
		{
			$b->b .= "local function #";
			$b->b .= $n;
		}break;
		}
	}
	static function makeStack($s) {
		$a = $GLOBALS[$s];
		$m = new _hx_array(array());
		{
			$_g1 = 0; $_g = $a->length - ((($s == "%s") ? 2 : 0));
			while($_g1 < $_g) {
				$i = $_g1++;
				$d = _hx_explode("::", $a[$i]);
				$m->unshift(haxe_StackItem::Method($d[0], $d[1]));
				unset($i,$d);
			}
		}
		return $m;
	}
	function __toString() { return 'haxe.Stack'; }
}
