<?php

namespace Ozone\Framework\Template\Services\Autoload;



use Ozone\Framework\TemplateService;

/**
 * Service for matching the current template name against given regular
 * expression. Should be useful when making menus etc.
 */
class TemplateRegexpMatcher extends TemplateService{

	protected $serviceName = "templateMatcher";

	public function __construct(private $runData)
	{
	}

	public function match($pattern){
		return preg_match("/".$pattern."/", $this->runData->getScreenTemplate());
	}

}
