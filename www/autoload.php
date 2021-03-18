<?php
declare(strict_types = 1);

function myProjectAutoload($classname)
{
	require_once __DIR__ . '/../src/' . str_replace("\\", '/', $classname) . '.php';
}

spl_autoload_register('myProjectAutoload');