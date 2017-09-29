<?php

namespace FrontFiles\Inspections\FileMimeType\Interfaces;

interface FileMimeTypeInterface
{
    /**
     * Filter have to implement this interface.
     *
     * @param string $value
     * @throws \Exception
     */
    public function isValid(string $value);
}