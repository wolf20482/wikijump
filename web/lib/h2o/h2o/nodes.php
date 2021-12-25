<?php
/*
		Nodes
*/

class H2o_Node {
    var $position;
	function __construct($argstring) {}

	function render($context, $stream) {}
}

class NodeList extends H2o_Node implements IteratorAggregate  {
	var $list;

	function __construct(&$parser, $initial = null, $position = 0) {
	    if ($initial === null)
            $initial = [];
        $this->list = $initial;
        $this->position = $position;
	}

	function render($context, $stream) {
		foreach($this->list as $node) {
			$node->render($context, $stream);
		}
	}

    function append($node) {
        array_push($this->list, $node);
    }

    function extend($nodes) {
        array_merge($this->list, $nodes);
    }

    function getLength() {
        return is_countable($this->list) ? count($this->list) : 0;
    }

    function getIterator() {
        return new ArrayIterator( $this->list );
    }
}

class VariableNode extends H2o_Node {
    private array $filters = array();

	function __construct($variable, $filters, $position = 0) {
        if (!empty($filters))
            $this->filters = $filters;
	}

	function render($context, $stream) {
        $value = $context->resolve($this->variable);
        $value = $context->escape($value, $this->variable);
        $stream->write($value);
	}
}

class CommentNode extends H2o_Node {}

class TextNode extends H2o_Node {
    function __construct($content, $position = 0) {
		$this->position = $position;
	}

	function render($context, $stream) {
		$stream->write($this->content);
	}

	function is_blank() {
	    return strlen(trim($this->content));
	}
}


?>
