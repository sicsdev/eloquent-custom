<?php

namespace Saritasa\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Saritasa\Enum;

/**
 * Adds some features to Eloquent model:
 * Enums cast. See TODO: Doc URL
 * Ability to define default values. See TODO: Doc URL
 */
class Entity extends Model
{
    const ID = 'id';
    const DELETED_AT = 'deleted_at';
    const RULE_REQUIRED = 'required';

    protected $defaults = [];

    /**
     * The attributes that should be cast to Enum classes
     * @var array
     */
    protected $enums = [];

    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    /**
     * Gets the value of attribute
     * @param string $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        $value = $this->getAttributeFromArray($key);
        // check if it's a enum
        if (isset($this->enums[$key]) && is_scalar($value)) {
            $enumClass = $this->enums[$key];
            return new $enumClass($value);
        }
        return parent::getAttributeValue($key);
    }

    /**
     * Sets the value of attribute
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        // check if it's a enum
        if (isset($this->enums[$key]) && is_scalar($value)) {
            $enumClass = $this->enums[$key];
            $this->attributes[$key] = new $enumClass($value);
        } else {
            parent::setAttribute($key, $value);
        }
        return $this;
    }

    /**
     * Gets validation rule for given enum class
     * @param string $enumClass
     * @return array
     */
    protected static function getEnumValidationRule(string $enumClass) : array
    {
        if (!is_a($enumClass, Enum::class, true)) {
            throw new \UnexpectedValueException('Class is not enum');
        }

        return array_merge(['in'], $enumClass::getConstants());
    }
}
