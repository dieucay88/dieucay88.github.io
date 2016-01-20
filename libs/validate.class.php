<?php

class Validate

{
    public static function isNumber($input)
    {
        return preg_match('/^[0-9]+$/', $input);
    }

    public static function isPhone($input)
    {
        return preg_match('/^[0-9]{9,11}$/', $input);
    }

    public static function isValidUsername($input)
    {
        return preg_match('/^[a-zA-Z0-9]{6,32}$/', $input);
    }

    public static function isValidEmail($input)
    {
        return preg_match('/^([\w\.\-_]+)?\w+@[\w-_]+(\.\w+){1,}$/', $input);
    }

    public static function isValidPass($input)
    {
        return preg_match('/^[a-zA-Z0-9]{6,32}$/', $input);
    }
}