<?php

class ValidationException extends Exception {
    // By extending the core Exception class, we create a specific 
    // "type" of error that we can catch independently of database errors.
}