<?php

class Xml {
	public function __construct() {
		;
		;
	}
	public $nodeType;
	//;
	//;
	public $parent;
	public $_nodeName;
	public $_nodeValue;
	public $_attributes;
	public $_children;
	public $_parent;
	public function getNodeName() {
		if($this->nodeType != Xml::$Element) {
			throw new HException("bad nodeType");
		}
		return $this->_nodeName;
	}
	public function setNodeName($n) {
		if($this->nodeType != Xml::$Element) {
			throw new HException("bad nodeType");
		}
		return $this->_nodeName = $n;
	}
	public function getNodeValue() {
		if($this->nodeType == Xml::$Element || $this->nodeType == Xml::$Document) {
			throw new HException("bad nodeType");
		}
		return $this->_nodeValue;
	}
	public function setNodeValue($v) {
		if($this->nodeType == Xml::$Element || $this->nodeType == Xml::$Document) {
			throw new HException("bad nodeType");
		}
		return $this->_nodeValue = $v;
	}
	public function getParent() {
		return $this->_parent;
	}
	public function get($att) {
		if($this->nodeType != Xml::$Element) {
			throw new HException("bad nodeType");
		}
		return $this->_attributes->get($att);
	}
	public function set($att, $value) {
		if($this->nodeType != Xml::$Element) {
			throw new HException("bad nodeType");
		}
		$this->_attributes->set($att, htmlspecialchars($value, ENT_COMPAT, "UTF-8"));
	}
	public function remove($att) {
		if($this->nodeType != Xml::$Element) {
			throw new HException("bad nodeType");
		}
		$this->_attributes->remove($att);
	}
	public function exists($att) {
		if($this->nodeType != Xml::$Element) {
			throw new HException("bad nodeType");
		}
		return $this->_attributes->exists($att);
	}
	public function attributes() {
		if($this->nodeType != Xml::$Element) {
			throw new HException("bad nodeType");
		}
		return $this->_attributes->keys();
	}
	public function iterator() {
		if($this->_children === null) {
			throw new HException("bad nodetype");
		}
		$me = $this;
		$it = null;
		$it = _hx_anonymous(array("cur" => 0, "x" => $me->_children, "hasNext" => array(new _hx_lambda(array("it" => &$it, "me" => &$me), null, array(), "{
			return \$it->cur < _hx_len(\$it->x);
		}"), 'execute0'), "next" => array(new _hx_lambda(array("it" => &$it, "me" => &$me), null, array(), "{
			return \$it->x[\$it->cur++];
		}"), 'execute0')));
		return $it;
	}
	public function elements() {
		if($this->_children === null) {
			throw new HException("bad nodetype");
		}
		$me = $this;
		$it = null;
		$it = _hx_anonymous(array("cur" => 0, "x" => $me->_children, "hasNext" => array(new _hx_lambda(array("it" => &$it, "me" => &$me), null, array(), "{
			\$k = \$it->cur;
			\$l = _hx_len(\$it->x);
			while(\$k < \$l) {
				if(_hx_array_get(\$it->x, \$k)->nodeType == Xml::\$Element) {
					break;
				}
				\$k += 1;
				;
			}
			\$it->cur = \$k;
			return \$k < \$l;
		}"), 'execute0'), "next" => array(new _hx_lambda(array("it" => &$it, "me" => &$me), null, array(), "{
			\$k = \$it->cur;
			\$l = _hx_len(\$it->x);
			while(\$k < \$l) {
				\$n = \$it->x[\$k];
				\$k += 1;
				if(\$n->nodeType == Xml::\$Element) {
					\$it->cur = \$k;
					return \$n;
				}
				unset(\$n);
			}
			return null;
		}"), 'execute0')));
		return $it;
	}
	public function elementsNamed($name) {
		if($this->_children === null) {
			throw new HException("bad nodetype");
		}
		$me = $this;
		$it = null;
		$it = _hx_anonymous(array("cur" => 0, "x" => $me->_children, "hasNext" => array(new _hx_lambda(array("it" => &$it, "me" => &$me, "name" => &$name), null, array(), "{
			\$k = \$it->cur;
			\$l = _hx_len(\$it->x);
			while(\$k < \$l) {
				\$n = \$it->x[\$k];
				if(\$n->nodeType == Xml::\$Element && \$n->_nodeName == \$name) {
					break;
				}
				\$k++;
				unset(\$n);
			}
			\$it->cur = \$k;
			return \$k < \$l;
		}"), 'execute0'), "next" => array(new _hx_lambda(array("it" => &$it, "me" => &$me, "name" => &$name), null, array(), "{
			\$k = \$it->cur;
			\$l = _hx_len(\$it->x);
			while(\$k < \$l) {
				\$n = \$it->x[\$k];
				\$k++;
				if(\$n->nodeType == Xml::\$Element && \$n->_nodeName == \$name) {
					\$it->cur = \$k;
					return \$n;
				}
				unset(\$n);
			}
			return null;
		}"), 'execute0')));
		return $it;
	}
	public function firstChild() {
		if($this->_children === null) {
			throw new HException("bad nodetype");
		}
		if($this->_children->length === 0) {
			return null;
		}
		return $this->_children[0];
	}
	public function firstElement() {
		if($this->_children === null) {
			throw new HException("bad nodetype");
		}
		$cur = 0;
		$l = $this->_children->length;
		while($cur < $l) {
			$n = $this->_children[$cur];
			if($n->nodeType == Xml::$Element) {
				return $n;
			}
			$cur++;
			unset($n);
		}
		return null;
	}
	public function addChild($x) {
		if($this->_children === null) {
			throw new HException("bad nodetype");
		}
		if($x->_parent !== null) {
			$x->_parent->_children->remove($x);
		}
		$x->_parent = $this;
		$this->_children->push($x);
	}
	public function removeChild($x) {
		if($this->_children === null) {
			throw new HException("bad nodetype");
		}
		$b = $this->_children->remove($x);
		if($b) {
			$x->_parent = null;
		}
		return $b;
	}
	public function insertChild($x, $pos) {
		if($this->_children === null) {
			throw new HException("bad nodetype");
		}
		if($x->_parent !== null) {
			$x->_parent->_children->remove($x);
		}
		$x->_parent = $this;
		$this->_children->insert($pos, $x);
	}
	public function toString() {
		if($this->nodeType == Xml::$PCData) {
			return $this->_nodeValue;
		}
		if($this->nodeType == Xml::$CData) {
			return "<![CDATA[" . $this->_nodeValue . "]]>";
		}
		if($this->nodeType == Xml::$Comment || $this->nodeType == Xml::$DocType || $this->nodeType == Xml::$Prolog) {
			return $this->_nodeValue;
		}
		$s = "";
		if($this->nodeType == Xml::$Element) {
			$s .= "<";
			$s .= $this->_nodeName;
			$�it = $this->_attributes->keys();
			while($�it->hasNext()) {
			$k = $�it->next();
			{
				$s .= " ";
				$s .= $k;
				$s .= "=\"";
				$s .= $this->_attributes->get($k);
				$s .= "\"";
				;
			}
			}
			if($this->_children->length === 0) {
				$s .= "/>";
				return $s;
			}
			$s .= ">";
		}
		$�it2 = $this->iterator();
		while($�it2->hasNext()) {
		$x = $�it2->next();
		$s .= $x->toString();
		}
		if($this->nodeType == Xml::$Element) {
			$s .= "</";
			$s .= $this->_nodeName;
			$s .= ">";
		}
		return $s;
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->�dynamics[$m]) && is_callable($this->�dynamics[$m]))
			return call_user_func_array($this->�dynamics[$m], $a);
		else
			throw new HException('Unable to call �'.$m.'�');
	}
	static $Element;
	static $PCData;
	static $CData;
	static $Comment;
	static $DocType;
	static $Prolog;
	static $Document;
	static $build;
	static function __start_element_handler($parser, $name, $attribs) {
		$node = Xml::createElement($name);
		while(list($k, $v) = each($attribs)) $node->set($k, $v);
		Xml::$build->addChild($node);
		Xml::$build = $node;
	}
	static function __end_element_handler($parser, $name) {
		Xml::$build = Xml::$build->getParent();
	}
	static function __character_data_handler($parser, $data) {
		$lc = ((Xml::$build->_children === null || Xml::$build->_children->length === 0) ? null : Xml::$build->_children[Xml::$build->_children->length - 1]);
		if($lc !== null && Xml::$PCData == $lc->nodeType) {
			$lc->setNodeValue($lc->getNodeValue() . htmlentities($data));
		}
		else {
			if((strlen($data) === 1 && htmlentities($data) != $data) || htmlentities($data) == $data) {
				Xml::$build->addChild(Xml::createPCData(htmlentities($data)));
			}
			else {
				Xml::$build->addChild(Xml::createCData($data));
			}
		}
	}
	static function __default_handler($parser, $data) {
		Xml::$build->addChild(Xml::createPCData($data));
	}
	static $xmlChecker;
	static function parse($str) {
		Xml::$build = Xml::createDocument();
		$xml_parser = xml_parser_create();
		xml_set_element_handler($xml_parser, isset(Xml::$__start_element_handler) ? Xml::$__start_element_handler: array("Xml", "__start_element_handler"), isset(Xml::$__end_element_handler) ? Xml::$__end_element_handler: array("Xml", "__end_element_handler"));
		xml_set_character_data_handler($xml_parser, isset(Xml::$__character_data_handler) ? Xml::$__character_data_handler: array("Xml", "__character_data_handler"));
		xml_set_default_handler($xml_parser, isset(Xml::$__default_handler) ? Xml::$__default_handler: array("Xml", "__default_handler"));
		xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($xml_parser, XML_OPTION_SKIP_WHITE, 0);
		$isComplete = Xml::$xmlChecker->match($str);
		if(!$isComplete) {
			$str = "<doc>" . $str . "</doc>";
		}
		if(xml_parse($xml_parser, $str, true) !== 1) {
			throw new HException("Xml parse error (" . xml_error_string($xml_parser) . ") line #" . xml_get_current_line_number($xml_parser));
		}
		xml_parser_free($xml_parser);
		if($isComplete) {
			return Xml::$build;
		}
		else {
			Xml::$build = Xml::$build->_children[0];
			Xml::$build->_parent = null;
			Xml::$build->_nodeName = null;
			Xml::$build->nodeType = Xml::$Document;
			return Xml::$build;
		}
	}
	static function createElement($name) {
		$r = new Xml();
		$r->nodeType = Xml::$Element;
		$r->_children = new _hx_array(array());
		$r->_attributes = new Hash();
		$r->setNodeName($name);
		return $r;
	}
	static function createPCData($data) {
		$r = new Xml();
		$r->nodeType = Xml::$PCData;
		$r->setNodeValue($data);
		return $r;
	}
	static function createCData($data) {
		$r = new Xml();
		$r->nodeType = Xml::$CData;
		$r->setNodeValue($data);
		return $r;
	}
	static function createComment($data) {
		$r = new Xml();
		$r->nodeType = Xml::$Comment;
		$r->setNodeValue($data);
		return $r;
	}
	static function createDocType($data) {
		$r = new Xml();
		$r->nodeType = Xml::$DocType;
		$r->setNodeValue($data);
		return $r;
	}
	static function createProlog($data) {
		$r = new Xml();
		$r->nodeType = Xml::$Prolog;
		$r->setNodeValue($data);
		return $r;
	}
	static function createDocument() {
		$r = new Xml();
		$r->nodeType = Xml::$Document;
		$r->_children = new _hx_array(array());
		return $r;
	}
	function __toString() { return $this->toString(); }
}
{
	Xml::$Element = "element";
	Xml::$PCData = "pcdata";
	Xml::$CData = "cdata";
	Xml::$Comment = "comment";
	Xml::$DocType = "doctype";
	Xml::$Prolog = "prolog";
	Xml::$Document = "document";
}
Xml::$xmlChecker = new EReg("\\s*(<\\?xml|<!DOCTYPE)", "mi");
