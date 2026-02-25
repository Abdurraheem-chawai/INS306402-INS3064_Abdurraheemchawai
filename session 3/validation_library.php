<?php

class ValidationLibrary
{
    /**
     * Sanitize email
     */
    public static function sanitizeEmail($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Validate email
     */
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Sanitize string (remove tags and special chars)
     */
    public static function sanitizeString($string)
    {
        return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate string length
     */
    public static function validateStringLength($string, $minLength = 1, $maxLength = 255)
    {
        $length = strlen($string);
        return $length >= $minLength && $length <= $maxLength;
    }

    /**
     * Sanitize integer
     */
    public static function sanitizeInteger($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Validate integer
     */
    public static function validateInteger($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * Sanitize URL
     */
    public static function sanitizeUrl($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * Validate URL
     */
    public static function validateUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate required field
     */
    public static function validateRequired($value)
    {
        return !empty(trim($value));
    }

    /**
     * Validate regex pattern
     */
    public static function validatePattern($value, $pattern)
    {
        return preg_match($pattern, $value) === 1;
    }
}