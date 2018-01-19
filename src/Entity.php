<?php

namespace Saritasa\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Saritasa\Enum;

/**
 * Adds some features to Eloquent model:
 * Enums cast. See https://github.com/Saritasa/php-common#enum
 * Ability to define default values. See https://github.com/Saritasa/php-eloquent-custom#entity
 */
class Entity extends Model
{
    const ID = 'id';
    const DELETED_AT = 'deleted_at';
    const RULE_REQUIRED = 'required';

    protected $defaults = [];

    /**
     * The attributes that should be cast to Enum classes
     *
     * @var array
     */
    protected $enums = [];

    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    /**
     * Gets the value of attribute,
     * taking enums typecast into consideration
     *
     * @param string $key Name of attribute
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
     * Sets the value of attribute,
     * taking enums typecast into consideration
     *
     * @param string $key Name of the attribute
     * @param mixed $value Value of the attribute to set
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
     *
     * @deprecated Should use Rule::enum($enumClass)
     *
     * @param string $enumClass Enum class name
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
