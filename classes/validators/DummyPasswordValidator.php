<?php

class DummyPasswordValidator implements eZPaExValidatorInterface
{
    public function validate(string $password): bool
    {
        throw new eZPaExValidatorException('Dummy password validator error');
    }
}