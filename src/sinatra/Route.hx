package sinatra;

import sinatra.Request;

class Route {
	
	public var method : HTTPMethod;
	public var route : Dynamic; // TODO Type this when that feature comes...
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
	 * 	2. An EReg expression like: ~/\/user/(\d+)/i
	 *
	 * TODO Type this when the multitypes feature is available
	 * TODO The matched groups of the final pattern should be available in Request#params
	 */
	public static function match( route , path ) {
		var pattern = Std.is( route , EReg ) ? cast( route , EReg ) : parse( route );
		var matched = pattern.match( path );
		if( matched ) {
			// Store all available matches in Request#params, using the keys (if available in the string) or index.
		}
		return matched;
	}
	
	static function parse( str ) {
		// TODO Parse "/user/:id" into ~/\/user/(\w+)/i and save its key "id" to the index of the match
		return new EReg( str , "i" );
	}
	
	public function toString() {
		return "[Route method:"+method+" at:"+route+" to:"+Type.getClassName(scope)+"#"+func+"]";
	}
	
}