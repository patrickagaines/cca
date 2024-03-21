<?php

namespace App\Exceptions;

use Exception;

class FailedToCreatePostException extends Exception
{
    protected $code = 500;
    protected $message = 'An error occurred while creating your post. Please try again.';
}
