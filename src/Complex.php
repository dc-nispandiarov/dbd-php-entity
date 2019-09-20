<?php

namespace Falseclock\DBD\Entity;

/**
 * Class Complex used when you generate value with view or with calculations
 *
 * @package Falseclock\DBD\Entity
 */
class Complex
{
	public const DB_TYPE      = "dbType";
	public const ENTITY_CLASS = "entityClass";
	public const IS_ITERABLE  = "isIterable";
	public const VIEW_COLUMN  = "viewColumn";
	/** @var string $viewColumn name of the columns in view */
	public $viewColumn;
	/** @var bool $isIterable */
	public $isIterable = false;
	/** @var string $entityClass default empty. Will be converted to Entity if not null */
	public $entityClass;
	/** @var Type $dbType */
	public $dbType;

	public function __construct($arrayOfValues = null) {
		if(isset($arrayOfValues)) {
			foreach($arrayOfValues as $key => $value) {
				$this->$key = $value;
			}
		}
	}
}