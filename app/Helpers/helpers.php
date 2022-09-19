<?php

if (!function_exists('getClassName')) {
    /**
     * Get the name of a class.
     *
     * @return string
     */
    function getClassName(string $class)
    {
        try {
            return strtolower((new \ReflectionClass($class))->getShortName());
        } catch (ReflectionException $e) {
            return '';
        }
    }
}
