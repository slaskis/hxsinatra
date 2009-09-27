package sinatra.utils;

class EnumHash<E,T> {
	
	var _hash : Hash<T>;
	
	public function new() {
		_hash = new Hash<T>();
	}
	
	public function set( key : E , value : T ) {
		_hash.set( Type.getEnumName( Type.getEnum( key ) ) , value );
	}
	
	public function get( key : E ) {
		return _hash.get( Type.getEnumName( Type.getEnum( key ) ) );
	}
	
	public function exists( key : E ) {
		return _hash.exists( Type.getEnumName( Type.getEnum( key ) ) );
	}
	
	public function remove( key : E ) {
		return _hash.remove( Type.getEnumName( Type.getEnum( key ) ) );
	}
	
	public function keys() {
		return _hash.keys();
	}
	
	public function iterator() {
		return _hash.iterator();
	}
}