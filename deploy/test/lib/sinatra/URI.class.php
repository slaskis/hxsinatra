<?php

class sinatra_URI {
	public function __construct($ereg, $absolute) {
		if( !php_Boot::$skip_constructor ) {
		$this->isAbsolute = $absolute;
		if($this->isAbsolute) {
			$this->schema = $ereg->matched(1);
			$this->opaque = $ereg->matched(2);
			$this->userinfo = $ereg->matched(3);
			$this->host = $ereg->matched(4);
			$this->port = $ereg->matched(5);
			$this->registry = $ereg->matched(6);
			$this->path = $ereg->matched(7);
			$this->query = $ereg->matched(8);
			$this->fragment = $ereg->matched(9);
		}
		else {
			$this->userinfo = $ereg->matched(1);
			$this->host = $ereg->matched(2);
			$this->port = $ereg->matched(3);
			$this->registry = $ereg->matched(4);
			$this->segment = $ereg->matched(5);
			$this->path = $ereg->matched(6);
			$this->query = $ereg->matched(7);
			$this->fragment = $ereg->matched(8);
		}
		if($this->port === null && $this->schema !== null) {
			$this->port = Reflect::field(sinatra_URI::$SCHEMA_DEFAULT_PORT, $this->schema);
		}
	}}
	public $schema;
	public $opaque;
	public $userinfo;
	public $user;
	public $pass;
	public $host;
	public $port;
	public $registry;
	public $segment;
	public $path;
	public $query;
	public $fragment;
	public $isAbsolute;
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->�dynamics[$m]) && is_callable($this->�dynamics[$m]))
			return call_user_func_array($this->�dynamics[$m], $a);
		else
			throw new HException('Unable to call �'.$m.'�');
	}
	static $SCHEMA_DEFAULT_PORT;
	static $PATTERN_ABS_URI = "\x0A\x09        ([a-zA-Z][-+.a-zA-Z\\d]*):\x0A\x09        (?:\x0A\x09           ((?:[-_.!~*'()a-zA-Z\\d;?:@&=+\$,]|%[a-fA-F\\d]{2})(?:[-_.!~*'()a-zA-Z\\d;/?:@&=+\$,\\[\\]]|%[a-fA-F\\d]{2})*)\x0A\x09        |\x0A\x09           (?:(?:\x0A\x09             //(?:\x0A\x09                 (?:(?:((?:[-_.!~*'()a-zA-Z\\d;:&=+\$,]|%[a-fA-F\\d]{2})*)@)?\x0A\x09                   (?:((?:(?:(?:[a-zA-Z\\d](?:[-a-zA-Z\\d]*[a-zA-Z\\d])?)\\.)*(?:[a-zA-Z](?:[-a-zA-Z\\d]*[a-zA-Z\\d])?)\\.?|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}|\\[(?:(?:[a-fA-F\\d]{1,4}:)*(?:[a-fA-F\\d]{1,4}|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3})|(?:(?:[a-fA-F\\d]{1,4}:)*[a-fA-F\\d]{1,4})?::(?:(?:[a-fA-F\\d]{1,4}:)*(?:[a-fA-F\\d]{1,4}|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}))?)\\]))(?::(\\d*))?))?\x0A\x09               |\x0A\x09                 ((?:[-_.!~*'()a-zA-Z\\d\$,;:@&=+]|%[a-fA-F\\d]{2})+)\x0A\x09               )\x0A\x09             |\x0A\x09             (?!//))\x0A\x09             (/(?:[-_.!~*'()a-zA-Z\\d:@&=+\$,]|%[a-fA-F\\d]{2})*(?:;(?:[-_.!~*'()a-zA-Z\\d:@&=+\$,]|%[a-fA-F\\d]{2})*)*(?:/(?:[-_.!~*'()a-zA-Z\\d:@&=+\$,]|%[a-fA-F\\d]{2})*(?:;(?:[-_.!~*'()a-zA-Z\\d:@&=+\$,]|%[a-fA-F\\d]{2})*)*)*)?\x0A\x09           )(?:\\?((?:[-_.!~*'()a-zA-Z\\d;/?:@&=+\$,\\[\\]]|%[a-fA-F\\d]{2})*))?\x0A\x09        )\x0A\x09        (?:\\#((?:[-_.!~*'()a-zA-Z\\d;/?:@&=+\$,\\[\\]]|%[a-fA-F\\d]{2})*))?\x0A\x09      ";
	static $PATTERN_REL_URI = "\x0A\x09        (?:\x0A\x09          (?:\x0A\x09            //\x0A\x09            (?:\x0A\x09              (?:((?:[-_.!~*'()a-zA-Z\\d;:&=+\$,]|%[a-fA-F\\d]{2})*)@)?\x0A\x09                ((?:(?:(?:[a-zA-Z\\d](?:[-a-zA-Z\\d]*[a-zA-Z\\d])?)\\.)*(?:[a-zA-Z](?:[-a-zA-Z\\d]*[a-zA-Z\\d])?)\\.?|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}|\\[(?:(?:[a-fA-F\\d]{1,4}:)*(?:[a-fA-F\\d]{1,4}|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3})|(?:(?:[a-fA-F\\d]{1,4}:)*[a-fA-F\\d]{1,4})?::(?:(?:[a-fA-F\\d]{1,4}:)*(?:[a-fA-F\\d]{1,4}|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}))?)\\]))?(?::(\\d*))?\x0A\x09            |\x0A\x09              ((?:[-_.!~*'()a-zA-Z\\d\$,;:@&=+]|%[a-fA-F\\d]{2})+)\x0A\x09            )\x0A\x09          )\x0A\x09        |\x0A\x09          ((?:[-_.!~*'()a-zA-Z\\d;@&=+\$,]|%[a-fA-F\\d]{2})+)\x0A\x09        )?\x0A\x09        (/(?:[-_.!~*'()a-zA-Z\\d:@&=+\$,]|%[a-fA-F\\d]{2})*(?:;(?:[-_.!~*'()a-zA-Z\\d:@&=+\$,]|%[a-fA-F\\d]{2})*)*(?:/(?:[-_.!~*'()a-zA-Z\\d:@&=+\$,]|%[a-fA-F\\d]{2})*(?:;(?:[-_.!~*'()a-zA-Z\\d:@&=+\$,]|%[a-fA-F\\d]{2})*)*)*)?\x0A\x09        (?:\\?((?:[-_.!~*'()a-zA-Z\\d;/?:@&=+\$,\\[\\]]|%[a-fA-F\\d]{2})*))?\x0A\x09        (?:\\#((?:[-_.!~*'()a-zA-Z\\d;/?:@&=+\$,\\[\\]]|%[a-fA-F\\d]{2})*))?\x0A\x09      ";
	static $PATTERN_REMOVE_WHITESPACE;
	static function parse($str) {
		haxe_Log::trace("Parsing URI from: " . $str, _hx_anonymous(array("fileName" => "URI.hx", "lineNumber" => 131, "className" => "sinatra.URI", "methodName" => "parse")));
		$abs = new EReg(sinatra_URI::$PATTERN_REMOVE_WHITESPACE->replace(sinatra_URI::$PATTERN_ABS_URI, ""), "");
		if($abs->match($str)) {
			haxe_Log::trace("IT'S AN ABSOLUTE URI!", _hx_anonymous(array("fileName" => "URI.hx", "lineNumber" => 135, "className" => "sinatra.URI", "methodName" => "parse")));
			return new sinatra_URI($abs, true);
		}
		$rel = new EReg(sinatra_URI::$PATTERN_REMOVE_WHITESPACE->replace(sinatra_URI::$PATTERN_REL_URI, ""), "");
		if($rel->match($str)) {
			haxe_Log::trace("IT'S A RELATIVE URI!", _hx_anonymous(array("fileName" => "URI.hx", "lineNumber" => 141, "className" => "sinatra.URI", "methodName" => "parse")));
			return new sinatra_URI($rel, false);
		}
		haxe_Log::trace("Invalid URI", _hx_anonymous(array("fileName" => "URI.hx", "lineNumber" => 145, "className" => "sinatra.URI", "methodName" => "parse")));
		return null;
	}
	function __toString() { return 'sinatra.URI'; }
}
sinatra_URI::$SCHEMA_DEFAULT_PORT = _hx_anonymous(array("http" => 80, "https" => 443, "ftp" => 21, "ssh" => 22));
sinatra_URI::$PATTERN_REMOVE_WHITESPACE = new EReg("\\s*|\\n", "g");
