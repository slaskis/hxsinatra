package sinatra;

import sinatra.Request;
import sinatra.utils.EnumHash;

class Base implements haxe.Public {
	
	private static var _routes : EnumHash<HTTPMethod,List<Route>>;
	static var request : Request;
	
	static function __init__() {
		_routes = new EnumHash<HTTPMethod,List<Route>>();
		_routes.set( HTTPMethod.GET , new List<Route>() );
		_routes.set( HTTPMethod.POST , new List<Route>() );
		_routes.set( HTTPMethod.PUT , new List<Route>() );
		_routes.set( HTTPMethod.DELETE , new List<Route>() );
	}
	
	/**
	 * Abstract method, called before a route. 
	 */
	function before();
	
	/**
	 * Abstract method, called after a route. 
	 */
	function after();
	
	/**
	 * Set a GET route.
	 * TODO Allow EReg routes as well.
	 */
	function get( route , scope , func ) _routes.get( HTTPMethod.GET ).add( Route.get( route , scope , func ) )
	
	/**
	 * Set a POST route.
	 * TODO Allow EReg routes as well.
	 */
	function post( route , scope , func ) _routes.get( HTTPMethod.POST ).add( Route.post( route , scope , func ) )
	
	/**
	 * Set a PUT route.
	 * TODO Allow EReg routes as well.
	 */
	function put( route , scope , func ) _routes.get( HTTPMethod.PUT ).add( Route.put( route , scope , func ) )
	
	/**
	 * Set a DELETE route.
	 * TODO Allow EReg routes as well.
	 */
	function delete( route , scope , func ) _routes.get( HTTPMethod.DELETE ).add( Route.delete( route , scope , func ) )
	
	public static function run( app : sinatra.Base ) {
		// Initializes a Request (which sets up sessions, cookies, post/get params)
		request = new Request();
		trace( request );
		
		// Goes through the _routes hash to see which one matches the request
		var route : Route = null;
		for( r in _routes.get( request.method ) ) {
			if( Route.match( r.route , request.path ) ) {
				route = r;
				break;
			}
		}
		
		if( route == null ) 
			throw "Found no route matching \""+ request.path + "\"";
		
		// Calls the route method
		// Wrap the call in try/catch to see if there's any 404 or other return codes or errors.
		var view : View = null;
		try {
			view = route.call();
		} catch( code : Int ) {
			trace( "CODE:" + Std.string( code ) );
		} catch( err : String ) {
			trace( "ERR:" + err + " stack: " + haxe.Stack.toString( haxe.Stack.exceptionStack() ) );
		} catch( other : Dynamic ) {
			trace( "WARN:" + Std.string( other ) );
		}
		
		// Call #render on the view returned from the route
		if( view != null )
			view.render();
		
		return 0;
	}
}