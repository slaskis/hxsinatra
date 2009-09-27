package sinatra;

class View {
	
	public static var defaultLayout : sinatra.View;
	
	public var useLayout : sinatra.View;
	
	public function new( template : String , layout : sinatra.View ) {
		// If template is a file, load that, otherwise it's the return string.
		
		// How to skip using a layout?
		if( layout != null )
			useLayout = defaultLayout;
	}
	
	public function render() {
		
	}
}