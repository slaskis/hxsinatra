class Application extends sinatra.Base {

	public function new() {
		get( "/" , controller.Home , "index" );
		get( "/user/:id" , controller.User , "get" );
		get( "/user" , controller.User , "get" );
		post( "/user" , controller.User , "update" );
		put( "/user" , controller.User , "create" );
		delete( "/user" , controller.User , "delete" );
		
		/* Quick syntax
		get( "/quick" , function( request ) {
			return "Echo!";
		} );
		*/
	}
	
	public static function main() {
		sinatra.Base.run( new Application() );
	}
	
}