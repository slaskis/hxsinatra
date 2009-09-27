package sinatra.utils;

class URI {
	
	static var SCHEME_DEFAULT_PORT = {
		http: 80,
		https: 443,
		ftp: 21,
		ssh: 22
	};
	
	public var scheme : String;
	public var opaque : String;
	public var userinfo : String;
	public var user : String;
	public var pass : String;
	public var host : String;
	public var port : String;
	public var registry : String;
	public var segment : String;
	public var path : String;
	public var query : String;
	public var fragment : String;
	public var isAbsolute : Bool;
	
	private function new( ereg , absolute ) {
		isAbsolute = absolute;
		
		if( isAbsolute ) {
			scheme = ereg.matched( 1 );
			opaque = ereg.matched( 2 );
			userinfo = ereg.matched( 3 );
			host = ereg.matched( 4 );
			port = ereg.matched( 5 );
			registry = ereg.matched( 6 );
			path = ereg.matched( 7 );
			query = ereg.matched( 8 );
			fragment = ereg.matched( 9 );
		} else {
			userinfo = ereg.matched( 1 );
			host = ereg.matched( 2 );
			port = ereg.matched( 3 );
			registry = ereg.matched( 4 );
			segment = ereg.matched( 5 );
			path = ereg.matched( 6 );
			query = ereg.matched( 7 );
			fragment = ereg.matched( 8 );
		}
		
		// TODO Extract user/pass from userinfo
		if( port == null && scheme != null ) {
			port = Reflect.field( SCHEME_DEFAULT_PORT , scheme );
		}
		
	}
	
	/**
	 * Pattern for an absolute URI. Copied from rubys URI class, see 
	 * it for a much more readable version: 
	 * http://github.com/shyouhei/ruby/blob/trunk/lib/uri/common.rb)
	 *
	 * Matches:
	 *	1: scheme
	 *	2: opaque
	 *	3: userinfo
	 *	4: host
	 *	5: port
	 *	6: registry
	 *	7: path
	 *	8: query
	 *	9: fragment
	 */
	static var PATTERN_ABS_URI = "
	        ([a-zA-Z][-+.a-zA-Z\\d]*):
	        (?:
	           ((?:[-_.!~*'()a-zA-Z\\d;?:@&=+$,]|%[a-fA-F\\d]{2})(?:[-_.!~*'()a-zA-Z\\d;/?:@&=+$,\\[\\]]|%[a-fA-F\\d]{2})*)
	        |
	           (?:(?:
	             //(?:
	                 (?:(?:((?:[-_.!~*'()a-zA-Z\\d;:&=+$,]|%[a-fA-F\\d]{2})*)@)?
	                   (?:((?:(?:(?:[a-zA-Z\\d](?:[-a-zA-Z\\d]*[a-zA-Z\\d])?)\\.)*(?:[a-zA-Z](?:[-a-zA-Z\\d]*[a-zA-Z\\d])?)\\.?|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}|\\[(?:(?:[a-fA-F\\d]{1,4}:)*(?:[a-fA-F\\d]{1,4}|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3})|(?:(?:[a-fA-F\\d]{1,4}:)*[a-fA-F\\d]{1,4})?::(?:(?:[a-fA-F\\d]{1,4}:)*(?:[a-fA-F\\d]{1,4}|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}))?)\\]))(?::(\\d*))?))?
	               |
	                 ((?:[-_.!~*'()a-zA-Z\\d$,;:@&=+]|%[a-fA-F\\d]{2})+)
	               )
	             |
	             (?!//))
	             (/(?:[-_.!~*'()a-zA-Z\\d:@&=+$,]|%[a-fA-F\\d]{2})*(?:;(?:[-_.!~*'()a-zA-Z\\d:@&=+$,]|%[a-fA-F\\d]{2})*)*(?:/(?:[-_.!~*'()a-zA-Z\\d:@&=+$,]|%[a-fA-F\\d]{2})*(?:;(?:[-_.!~*'()a-zA-Z\\d:@&=+$,]|%[a-fA-F\\d]{2})*)*)*)?
	           )(?:\\?((?:[-_.!~*'()a-zA-Z\\d;/?:@&=+$,\\[\\]]|%[a-fA-F\\d]{2})*))?
	        )
	        (?:\\#((?:[-_.!~*'()a-zA-Z\\d;/?:@&=+$,\\[\\]]|%[a-fA-F\\d]{2})*))?
	      ";
	
	/**
	 * Pattern for a relative URI. Copied from rubys URI class, see 
	 * it for a much more readable version: 
	 * http://github.com/shyouhei/ruby/blob/trunk/lib/uri/common.rb)
	 *
	 * Matches:
	 *	1: userinfo
	 *	2: host
	 *	3: port
	 *	4: registry
	 *	5: rel_segment
	 *	6: abs_path
	 *	7: query
	 *	8: fragment
	 */
	static var PATTERN_REL_URI = "
	        (?:
	          (?:
	            //
	            (?:
	              (?:((?:[-_.!~*'()a-zA-Z\\d;:&=+$,]|%[a-fA-F\\d]{2})*)@)?
	                ((?:(?:(?:[a-zA-Z\\d](?:[-a-zA-Z\\d]*[a-zA-Z\\d])?)\\.)*(?:[a-zA-Z](?:[-a-zA-Z\\d]*[a-zA-Z\\d])?)\\.?|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}|\\[(?:(?:[a-fA-F\\d]{1,4}:)*(?:[a-fA-F\\d]{1,4}|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3})|(?:(?:[a-fA-F\\d]{1,4}:)*[a-fA-F\\d]{1,4})?::(?:(?:[a-fA-F\\d]{1,4}:)*(?:[a-fA-F\\d]{1,4}|\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}))?)\\]))?(?::(\\d*))?
	            |
	              ((?:[-_.!~*'()a-zA-Z\\d$,;:@&=+]|%[a-fA-F\\d]{2})+)
	            )
	          )
	        |
	          ((?:[-_.!~*'()a-zA-Z\\d;@&=+$,]|%[a-fA-F\\d]{2})+)
	        )?
	        (/(?:[-_.!~*'()a-zA-Z\\d:@&=+$,]|%[a-fA-F\\d]{2})*(?:;(?:[-_.!~*'()a-zA-Z\\d:@&=+$,]|%[a-fA-F\\d]{2})*)*(?:/(?:[-_.!~*'()a-zA-Z\\d:@&=+$,]|%[a-fA-F\\d]{2})*(?:;(?:[-_.!~*'()a-zA-Z\\d:@&=+$,]|%[a-fA-F\\d]{2})*)*)*)?
	        (?:\\?((?:[-_.!~*'()a-zA-Z\\d;/?:@&=+$,\\[\\]]|%[a-fA-F\\d]{2})*))?
	        (?:\\#((?:[-_.!~*'()a-zA-Z\\d;/?:@&=+$,\\[\\]]|%[a-fA-F\\d]{2})*))?
	      ";
	
	static var PATTERN_REMOVE_WHITESPACE = ~/\s*|\n/g;
	
	public static function parse( str ) {
		var abs = new EReg( "^" + PATTERN_REMOVE_WHITESPACE.replace( PATTERN_ABS_URI , "" ) + "$" , "" );
		if( abs.match( str ) )
			return new URI( abs , true );
		
		var rel = new EReg( "^" + PATTERN_REMOVE_WHITESPACE.replace( PATTERN_REL_URI , "" ) + "$" , "" );
		if( rel.match( str ) )
			return new URI( rel , false );
			
		throw "Invalid URI";
	}
	
	public function toString() {
		var str = "";
		if( scheme != null ) 
			str += scheme;
		if( opaque != null )
			str += opaque;
		else {
			if( registry != null )
				str += registry;
			else {
				if( host != null )
					str += "//";
				if( userinfo != null )
					str += userinfo + "@";
				if( host != null )
					str += host;
				if( port != null && ( scheme != null && port != Reflect.field( SCHEME_DEFAULT_PORT , scheme ) ) )
					str += ":" + Std.string( port );
			}
			str += path;
			if( query != null )
				str += "?" + query;
		}
		if( fragment != null )
			str += "#" + fragment;
		return str;
	}
}