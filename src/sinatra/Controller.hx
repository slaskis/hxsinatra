package sinatra;

class Controller implements haxe.Public {
	
	var request(getRequest,null) : Request;
	var params(getParams,null) : Dynamic;
	var session(getSession,null) : Dynamic;
	var cookies(getCookies,null) : Dynamic;
	
	function redirect( route ) request.redirect( route )

	private function getRequest() return Base.request
	private function getParams() return Base.request.params
	private function getSession() return Base.request.session
	private function getCookies() return Base.request.cookies
	
}