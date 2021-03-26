<?php
namespace LiamProject\View;

class View
{
	protected $templatesPath;
	protected $extraVars = [];

	public function __construct(string $templatesPath)
	{
		$this->templatesPath = $templatesPath;
	}

	public function setVar(string $name, $value): void
	{
		$this->extraVars[$name] = $value;
	}

	public function renderHtml(string $temptateName, array $vars = [], int $code = 200)
	{
		http_response_code($code);

		extract($this->extraVars);
		extract($vars);

		ob_start();

		include $this->templatesPath . '/' . $temptateName;

		$buffer = ob_get_contents();
  	 	ob_end_clean();
  	 	echo $buffer;
	}
}