<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Db\Exception;

use Attw\Db\Entity\AbstractEntity;
use \Exception;

class EntityException extends Exception
{
	public static function primaryKeyNotDefined(AbstractEntity $entity)
	{
		throw new EntityException('Primary key not defined for entity: ' . get_class($entity));
	}

	public static function primaryKeyIsNotString(AbstractEntity $entity)
	{
		throw new EntityException('Primary key of the entity \'' . get_class($entity) . '\' is not a string');
	}

	public static function primaryKeyIsNotAColumn(AbstractEntity $entity)
	{
		throw new EntityException('Primary key of \'' . get_class($entity) . '\' is not a column');
	}
}