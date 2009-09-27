package sinatra;

import sinatra.utils.URI;

#if neko
typedef Web = neko.Web;
#elseif php
typedef Web = php.Web;
#else
throw "Unsupported platform."
#end

enum HTTPMethod {
	GET;
	POST;
	PUT;
	DELETE;
}


/**
 * Should do all HTTP request magic.
 * The only file that should need platform specific attention.
 */

class Request {
	
	public var uri : URI;
	public var path : String;
	public var headers : Hash<String>;
	public var session : Hash<String>; 
	public var cookies : Dynamic; 
	public var params : Hash<String>;
	public var method : HTTPMethod;
	
	public function new() {
		method = switch( Web.getMethod().toUpperCase() ) {
			case "GET": GET;
			case "POST": POST;
			case "PUT": PUT;
			case "DELETE": DELETE;
			default: throw "Invalid HTTP Method";
		}
		params = Web.getParams();
		// TODO Also include Web.getMultiPart in the params. If it isn't already.
		
		uri = URI.parse( Web.getURI() );
		path = uri.path;
		
		headers = new Hash<String>();
		for( h in Web.getClientHeaders() ) 
			headers.set( h.header , h.value );
	}
	
	public function toString() {
		return "[Request method:"+method+" uri:"+uri+" headers:"+headers+"]";
	}
	
	public function redirect( route ) Web.redirect( route )

}