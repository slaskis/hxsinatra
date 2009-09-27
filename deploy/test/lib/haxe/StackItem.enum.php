<?php

class haxe_StackItem extends Enum {
		public static $CFunction;
		public static function FilePos($s, $file, $line) { return new haxe_StackItem("FilePos", 2, array($s, $file, $line)); }
		public static function Lambda($v) { return new haxe_StackItem("Lambda", 4, array($v)); }
		public static function Method($classname, $method) { return new haxe_StackItem("Method", 3, array($classname, $method)); }
		public static function Module($m) { return new haxe_StackItem("Module", 1, array($m)); }
	}
	haxe_StackItem::$CFunction = new haxe_StackItem("CFunction", 0);
