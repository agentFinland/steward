<?php

namespace Lmc\Steward\Component;

use Lmc\Steward\Test\AbstractTestCaseBase;

/**
 * AbstractComponent used as parent of all components to add some default functionality and interface .
 *
 * @method void log(string $message, $arguments)
 * @method void warn(string $message, $arguments)
 */
abstract class AbstractComponent
{
    /** @var AbstractTestCaseBase */
    protected $tc;

    /** @var string */
    protected $componentName;

    /**
     * @param AbstractTestCaseBase $tc TestCase instance
     */
    public function __construct(AbstractTestCaseBase $tc)
    {
        $this->tc = $tc;

        $reflection = new \ReflectionClass($this);
        $this->componentName = $reflection->getShortName();
    }

    public function __call($name, $arguments)
    {
        // Methods log() and warn() prepend componentName to message and call the same method on TestCase.
        if ($name == 'log' || $name == 'warn') {
            $arguments[0] = '[' . $this->componentName . '] ' . $arguments[0];
            call_user_func_array([$this->tc, $name], $arguments);
        }
    }
}
