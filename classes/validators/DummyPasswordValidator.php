<?php

class DummyPasswordValidator implements eZPaExValidatorInterface
{
    /**
     * @throws eZPaExValidatorException
     */
    public function validate(string $password): bool
    {
        throw new eZPaExValidatorException('Dummy password validator error');
    }
}