<?php

namespace Ozone\Framework\Template\Services\Autoload;



use Stringable;
use Ozone\Framework\TemplateService;

/**
 * Module service.
 *
 */
class ModuleService extends TemplateService implements Stringable {

	protected $serviceName = "module";

	private $templateName;

	public function __construct(private $runData)
	{
	}

	public function render($templateName, $parameters=null){
		$parmstring = null;
		$this->templateName = $templateName;
		if($parameters!==null){
			$parmstring = " ".urlencode($parameters)." ";
		}
		$d = utf8_encode("\xFE");
		$out = $d."module \"".$templateName."\" ".$parmstring.$d;
		return $out;

	}

	public function __toString() : string {

	}

}
