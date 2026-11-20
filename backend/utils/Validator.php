<?php

require_once __DIR__ . '/exceptions.php';

class Validator
{
    public static function required(array $data, array $fields): void
    {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || (is_string($data[$field]) && trim($data[$field]) === '')) {
                throw new ValidationException("Field '$field' is required.");
            }
        }
    }

    public static function string(mixed $value, string $field, int $min, int $max): void
    {
        if (!is_string($value)) {
            throw new ValidationException("Field '$field' must be text.");
        }
        $length = mb_strlen(trim($value));
        if ($length < $min || $length > $max) {
            throw new ValidationException("Field '$field' must have between $min and $max characters.");
        }
    }

    public static function integer(mixed $value, string $field, int $min, int $max): void
    {
        $number = filter_var($value, FILTER_VALIDATE_INT);
        if ($number === false) {
            throw new ValidationException("Field '$field' must be a whole number.");
        }
        if ($number < $min || $number > $max) {
            throw new ValidationException("Field '$field' must be between $min and $max.");
        }
    }

    public static function email(mixed $value, string $field = 'email'): void
    {
        if (!is_string($value) || filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new ValidationException("Field '$field' must be a valid email address.");
        }
    }
}