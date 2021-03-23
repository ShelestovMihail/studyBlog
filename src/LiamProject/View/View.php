<?php
namespace LiamProject\View;

class View
{
	protected $templatesPath;

	public function __construct(string $templatesPath)
	{
		$this->templatesPath = $templatesPath;
	}

	public function renderHtml(string $temptateName, array $vars = [], int $code = 200)
	{
		http_response_code($code);
		extract($vars);

		ob_start();

		include $this->templatesPath . '/' . $temptateName;

		$buffer = ob_get_contents();
  	 	ob_end_clean();
  	 	echo $buffer;
	}
}