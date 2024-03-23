<?php

namespace App\Exceptions;

use Exception;

class FailedToCreatePostException extends Exception
{
    protected $code = 422;
    protected $message = 'An error occurred while creating your post. Please try again.';
}
