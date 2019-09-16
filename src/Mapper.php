<?php

namespace Falseclock\DBD\Entity;

use Exception;
use Falseclock\DBD\Common\Singleton;
use Falseclock\DBD\Entity\Common\Enforcer;
use Falseclock\DBD\Entity\Common\EntityException;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class MapperCache extends Singleton
{
	public $conversionCache = [];
}

/**
 * Название переменной в дочернем классе, которая должна быть если мы вызываем BaseHandler
 *
 * @property Column $id
 * @property Column $constant
 */
abstract class Mapper extends Singleton
{
	const ANNOTATION = "abstract";

	public function annotation() {
		return $this::ANNOTATION;
	}

	/**
	 * @return array
	 */
	public function fields() {
		/** @var Column[] $fields */
		$fields = get_object_vars($this);

		foreach($fields as &$field) {
			$field = $field->name;
		}

		return $fields;
	}

	/**
	 * @throws ReflectionException
	 */
	public function getConstraints() {
		$reflect = new ReflectionClass($this);
		$constraints = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);

	}

	/**
	 * @return mixed|Singleton|static
	 * @throws EntityException
	 * @throws ReflectionException
	 * @throws Exception
	 */
	public static function me() {

		/** @var Entity $self */
		$self = self::getInstance(get_called_class());

		Enforcer::__add(__CLASS__, get_called_class());

		if(!isset(MapperCache::me()->conversionCache[get_class($self)])) {
			$vars = get_object_vars($self);

			foreach($vars as $varName => $varValue) {

				if(is_scalar($varValue)) {
					$self->$varName = new Column($varValue);
				}
				else if(is_array($varValue)) {
					$varValue = (object) $varValue;
					$column = new Column();

					foreach($varValue as $key => $value) {
						if($key == Column::TYPE) {
							$column->$key = new Primitive($value);
						}
						else {
							$column->$key = $value;
						}
					}

					$self->$varName = $column;
				}
				else {
					throw new EntityException("Unknown type of Mapper variable {$varName} in $self");
				}
			}
			MapperCache::me()->conversionCache[get_class($self)] = true;
		}

		return $self;
	}

	public function revers($string) {
		$revers = array_flip($this->fields());

		return $revers[$string];
	}
}