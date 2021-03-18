<?php
namespace LiamProject\Models;

use \LiamProject\Services\Db;

abstract class ActiveRecordEntity
{
	protected $id;

	public function getId(): int
	{
		return $this->id;
	}

    /*Наследники этого класса будут реальзоваться при помощи 
    PDO->fetchAll(PDO::FETCH_CLASS) В бд имена столбцов записаны 
    с_подчеркиваниями, поэтому нужно их конвертировать в имяСвойства*/
	public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public function save()
    {
        $mappedProperties = $this->mapPropertiesForDb();
        if ($this->id === null) {
            $this->insert($mappedProperties);
        } else {
            $this->update($mappedProperties);
        }
    }

    private function update(array $mappedProperties): void
    {
        $colums2params = [];
        $params2values = [];
        $paramNumber = 1;

        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $paramNumber; // :param1
            $colums2params[] = $column . ' = ' . $param; // column = :param1
            $params2values[$param] = $value;
            $paramNumber++;
        }

        $sql = 'UPDATE ' . static::getTableName() . 
        ' SET ' . implode(', ', $colums2params) . 
        ' WHERE id = ' . $this->id;

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    private function insert(array $mappedProperties): void
    {
        $mappedPropertiesWithoutNull = array_filter($mappedProperties);
        $colums = [];
        $params2values = [];
        $params = [];
        $paramNumber = 1;

        foreach ($mappedPropertiesWithoutNull as $column => $value) {
            $colums[] = $column;
            $param = ':param' . $paramNumber;
            $params[] = $param;
            $params2values[$param] = $value;
            $paramNumber++;
        }

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' .  
        implode(', ', $colums) . ') VALUES (' . 
        implode(', ', $params) . ');';

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    public static function getAll(): array
    {
    	$db = Db::getInstance();
    	return $db->query('SELECT * FROM ' . static::getTableName(), [], static::class); 
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('|(?<!^)[A-Z]|', '_$0', $source));
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function mapPropertiesForDb(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $dbName = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$dbName] = $this->$propertyName; 
        }

        return $mappedProperties;
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