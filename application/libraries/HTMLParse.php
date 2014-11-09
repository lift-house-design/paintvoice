<?
class HTMLParse
{
	public $dom;
	public $xpath;

	public function __construct($str='')
	{

		$this->dom = new DomDocument(LIBXML_COMPACT|LIBXML_NOCDATA|LIBXML_NOBLANKS|LIBXML_NOWARNING|LIBXML_NOERROR);
		libxml_use_internal_errors(true);
		if($str)
			$this->load($str);
	}

	public function load($str)
	{
		$this->dom->loadHTML($str);
		$this->xpath = new DOMXPath($this->dom);
	}

	/* $url is used for returning absolute paths */
	public function getAnchorLinks($url='')
	{
		$out = array();
		$absolute_paths = (bool) $url;

		// get anchors
		$res = $this->xpath->query('//a');
		foreach($res as $node)
		{
			$tmp = array(
				'text' => trim($node->textContent),
				'url' => trim($node->getAttribute('href'))
			);
			if($absolute_paths)
				$tmp['url'] = $this->absoluteURL($url,$tmp['url']);
			$out[] = $tmp;
		}

		// get iframe links
		$res = $this->xpath->query('//iframe');
		foreach($res as $node)
		{
			$tmp = array(
				'text' => trim($node->getAttribute('title')),
				'url' => trim($node->getAttribute('src'))
			);
			if($absolute_paths)
				$tmp['url'] = $this->absoluteURL($url,$tmp['url']);
			$out[] = $tmp;
		}
		// remove duplicates (probably retard slow)
		$out = array_map("unserialize", array_unique(array_map("serialize", $out)));
		return $out;
	}

	public function getText()
	{
		$out = '';

		// remove meta / scripts / etc
		$res = $this->xpath->query("//head|//script|//button|//form|//style");
		foreach($res as $node)
		{
			$node->parentNode->removeChild($node);
		}

		$res = $this->xpath->query('//body');
		foreach($res as $node)
		{
			$out .= $node->textContent."\n";
		}
		return $out;
	}

	/* Deal with it */
	public function untangleURL($url)
	{
		$re = array('#[^:](/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
    	for($n=1; $n>0; $url=preg_replace($re, '/', $url, -1, $n)) {}
    	return $url;
	}

	/* Why is this not a native function? */
	public function absoluteURL($base,$url)
	{
		$base_parts = parse_url($base);
		$url_parts = parse_url($url);
		if(!empty($url_parts['scheme']))
			return $url;
		if(strpos($url,'//') === 0)
			return $base_parts['scheme'] . ':' . $url;
		if(strpos($url,'/') === 0)
			return $base_parts['scheme'] . '://' . $base_parts['host'] . $url;
		if(empty($base_parts['path']))
			$base_parts['path'] = '/';
		return $this->untangleURL( $base_parts['scheme'] . '://' . $base_parts['host'] . $base_parts['path'] . $url );
	}
}

/* Author: Bain Mullins */
?>
