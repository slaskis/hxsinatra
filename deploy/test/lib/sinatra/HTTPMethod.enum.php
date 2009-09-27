<?php

class sinatra_HTTPMethod extends Enum {
		public static $DELETE;
		public static $GET;
		public static $POST;
		public static $PUT;
	}
	sinatra_HTTPMethod::$DELETE = new sinatra_HTTPMethod("DELETE", 3);
	sinatra_HTTPMethod::$GET = new sinatra_HTTPMethod("GET", 0);
	sinatra_HTTPMethod::$POST = new sinatra_HTTPMethod("POST", 1);
	sinatra_HTTPMethod::$PUT = new sinatra_HTTPMethod("PUT", 2);
