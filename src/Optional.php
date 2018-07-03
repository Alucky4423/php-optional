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
        if ($callback === null)
            throw new NullPointerException('lambda is null.');

        if ($this->isPresent())
            $callback($this->value);
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
