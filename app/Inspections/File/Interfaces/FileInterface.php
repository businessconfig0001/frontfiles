<?php

namespace FrontFiles\Inspections\File\Interfaces;

interface FileInterface
{
    /**
     * Filter have to implement this interface.
     *
     * @param string $value
     * @throws \Exception
     */
    public function isValid(string $value);
}