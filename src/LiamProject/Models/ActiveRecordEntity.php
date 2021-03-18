<?php
namespace LiamProject\Models;

use \LiamProject\Services\Db;

abstract class ActiveRecordEntity
{
	// int
	protected $id;

	public function getId(): int
	{
		return $this->id;
	}

	public function __set($name, $value)
    {
    	//Конвертирует snake_case в camelCase
        $camelCaseName = lcfirst(str_replace('_', '', ucwords($name, '_')));

        $this->$camelCaseName = $value;
    }

    public static function getAll(): array
    {
    	$db = Db::getInstance();
    	return $db->query('SELECT * FROM ' . static::getTableName(), [], static::class); 
    }

    public static function getById($id): ?self
    {
    	$db = Db::getInstance();
    	$entities = $db->query(
    		'SELECT * FROM ' . static::getTableName() . ' WHERE id=:id;', 
    		[':id' => $id],
    		static::class
    	);

    	return $entities ? $entities[0] : null;
    }

    abstract protected static function getTableName(): string;
}