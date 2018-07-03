<?php

namespace Alucky4423;

use Alucky4423\Exceptions\NullPointerException;

class Optional
{
    private static $instanceOfNullValue;
    private $value;

    /**
     * @param $value
     * @return Optional
     * @throws NullPointerException
     */
    public static function of($value): Optional
    {
        if ($value === null)
            throw new NullPointerException("value is null.");

        return new self($value);
    }


    /**
     * @param $value
     * @return Optional
     */
    public static function ofNullable($value): Optional
    {
        if ($value === null)
            return self::ofNull();

        return new self($value);
    }


    /**
     * @return Optional
     */
    public static function ofNull(): Optional
    {
        if (! isset(self::$instanceOfNullValue))
            self::$instanceOfNullValue = new self(null);

        return self::$instanceOfNullValue;
    }


    /**
     * Optional constructor.
     * @param $value
     */
    private function __construct($value)
    {
        $this->value = $value;
    }


    /**
     * @return bool
     */
    public function isPresent(): bool
    {
        return ($this->value !== null);
    }


    /**
     * @param callable $callback
     * @throws NullPointerException
     */
    public function ifPresent(callable $callback): void
    {
        if ($this->isPresent())
            $callback($this->value);
    }

    /**
     * @param callable $callback
     * @return Optional
     */
    public function filter(callable $callback): Optional
    {
        $bool = $callback($this->value);
        if (gettype($bool) !== 'boolean')
            throw new TypeError('The callback function must return a boolean value.');

        return $bool ? $this : self::ofNull();
    }

    public function map(callable $callback): Optional
    {
        return self::ofNullable($callback($this->value));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $type = gettype($this->value);
        return "Optional<${type}>";
    }
}
