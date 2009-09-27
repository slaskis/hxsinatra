class Application extends sinatra.Base {

	public function new() {
		// Can i make these routes compile-safe? I'd rather not use strings as the methods...
		get( "/" , controller.Home , "index" );
		get( "/user/:id.:format" , controller.User , "get" );
		get( "/user/(\\d+)" , controller.User , "get" );
		get( "/user/**/*.xml" , controller.User , "get" );
		post( "/user" , controller.User , "update" );
		put( "/user" , controller.User , "create" );
		delete( "/user" , controller.User , "delete" );
		
		/* Quick syntax?
		get( "/quick" , function( request ) {
			return "Echo!";
		} );
		*/
		
		var p = new Params();
		p.id = "123";
		p[0] = "321";
		
		trace( p );
	}
	
	public static function main() {
		sinatra.Base.run( new Application() );
	}
	
}

class Params<T> implements Dynamic<T>, implements ArrayAccess<T> {
	
	public function new() {
		
	}
	
}