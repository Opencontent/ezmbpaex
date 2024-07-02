<?php

interface eZPaExValidatorInterface
{

    /**
     * @throw eZPaExValidatorException
     */
    public function validate(string $password): bool;
}