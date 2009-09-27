package sinatra;

import sinatra.Request;

class Route {
	
	public var method : HTTPMethod;
	public var route : String;
	public var scope : Class<Dynamic>;
	public var func : String;

	public function new( method : HTTPMethod , route : Dynamic , scope : Class<Dynamic>, func : String ) {
		this.method = method;
		this.route = route;
		this.scope = scope;
		this.func = func;
	}
	
	public function call() : View {
		var obj = Type.createEmptyInstance( scope );
		var method = Reflect.field( obj , func );
		if( method == null )
			throw obj + " does not contain " + func;
		if( !Reflect.isFunction( method ) )
			throw func + " is not a method of " + obj;
		// May return a sintra.View, a file path or a string.
		var ret = Reflect.callMethod( obj , method , [] );
		trace( "Returned: " + ret );
		// If the return is a string, create a View of it.
		return Std.is( ret , String ) ? new sinatra.View( ret , null ) : cast( ret , View );
	}
	
	public static function get( route , scope , func ) return new Route( GET , route , scope , func )
	public static function post( route , scope , func ) return new Route( POST , route , scope , func )
	public static function put( route , scope , func ) return new Route( PUT , route , scope , func )
	public static function delete( route , scope , func ) return new Route( DELETE , route , scope , func )
	
	/**
	 * Tests a route if it matches a path.
	 * 
	 * A route may be:
	 * 	1. A string like: "/user/:id"
	 *	2. A glob pattern like: "/user/*" or "/h?llo"
	 * 	3. Any string that can be converted into a regexp: "/user/(\d+)"
	 *
	 * TODO The matches in the route should be available in Request#params
	 * TODO Should we allow combinations? Technically 1 and 3 or 2 and 3 can already be combined...
	 * TODO Can Dynamic and ArrayAccess be combined?
	 *
	 *   Params should be used like:
	 *
	 *   	"/*.xml" - "/hello.xml"
	 *   	params[0] = "hello"
	 *
	 *   	"/:id" - "/bob"
	 *   	params.id = "bob"
	 *
	 *   	"/user/(\d+)/*" - "/user/123/bob"
	 *   	params[0] = "123"
	 *   	params[1] = "bob"
	 *   
	 *   	"/user/:id/:name" - "/user/123/bob"
	 *   	params.id = "123"
	 *   	params.name = "bob"
	 *
	 */
	public static function match( route , path ) {
		var parser = new RouteParser( route );
		var matched = parser.match( path );
		trace( "Matched? " + matched + " " + route + " " + path );
		if( matched ) {
			// Store all available matches in Request#params, using the keys (if available in the string) or index.
		}
		return matched;
	}
	
	public function toString() {
		return "[Route method:"+method+" at:"+route+" to:"+Type.getClassName(scope)+"#"+func+"]";
	}
	
}

class RouteParser {
	
	var str : String;
	
	public function new( route ) {
		this.str = route;
	}
	
	public function match( path ) {
		var ereg = parse();
		
		var matched = ereg.match( path );
		if( matched ) {
			// Store all the found keys and indices
			// so they may be retrieved by the Request
		}
		return matched;
	}
	
	public function parse() {
		// if the string contains * or ? it's probably a glob pattern
		if( ~/\*|\?/.match( str ) )
			return glob();
		
		// if if contains :\w+ it's probably a keyed-url
		if( ~/:\w+/.match( str ) )
			return key();
		
		// or it's just a string to match against
		return new EReg( "^" + str + "$" , "i" );
	}
	
	function key() {
		var reg = "^";
		var chars = str.split("");
		var ch = "";
		var inKey = false;
		var keyName = "";
		var matchIndex = 0;
		var keys = new Hash<Int>();
		while( ( ch = chars.shift() ) != null ) {
			if( ch == ":" ) {
				matchIndex++;
				keyName = "";
				inKey = true;
			} else if( inKey && ~/[^a-z]/i.match( ch ) ) {
				inKey = false;
				keys.set( keyName , matchIndex );
				reg += "([a-zA-Z0-9]+)" + escape( ch );
			} else if( inKey ) {
				keyName += ch;
			} else {
				reg += escape( ch );
			}
		}
		if( inKey ) {
			keys.set( keyName , matchIndex );
			reg += "([a-zA-Z0-9]+)";
		}
		reg += "$";
		
		trace( "(key) From pattern: " + str + " we created expression: " + reg + " and found these keys: " + keys );
		
		return new EReg( reg , "" );
	}
	
	function escape( ch ) {
		return switch( ch ) {
			case ".","+","*": "\\" + ch;
			default: ch;
		}
	}
	
	function glob() {
		/* Example:
			pattern = "**\/*.as"
			reg = "^.*\.as$"
	
			pattern = "*.as"
			reg = "^[^/]*\.as$"
	
			pattern = "*.r??"
			reg = "^[^/]*?.r.{2}$"
	
			pattern = "*\/*.hx"
			reg = "^[^/]*\/[^/]*.hx$"
		*/
		var reg = "^";
		var chars = str.split("");
		var ch = "";
		var wild = 0;
		var single = 0;
		var or = false;
		while( true ) {
			switch( ch ) {
				case "*":
					wild++;
				case "?":
					single++;
				case "{":
					reg += "(?:";
					or = true;
				case ",":
					if( or ) reg += "|";
					else reg += ch;
				case "}":
					reg += ")";
					or = false;
				default:
					if( single > 0 ) {
						reg += "[^/]{"+single+"}";
						single = 0;
					} else if( wild == 1 ) {
						reg += "[^/]*";
						wild = 0;
					} else if( wild == 2 ) {
						reg += ".*";
						wild = 0;
					}
					if( ch != null )
						reg += ch;
			}
			if( ch == null ) 
				break;
			ch = chars.shift();
		}
		reg += "$";

		trace( "(glob) From pattern: " + str + " we created expression: " + reg );
		return new EReg( reg , "" );
	}
	
}