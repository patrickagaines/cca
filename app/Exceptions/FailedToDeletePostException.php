<?php

namespace App\Exceptions;

use Exception;

class FailedToDeletePostException extends Exception
{
    protected $code = 422;
    protected $message = 'An error occurred while deleting your post. Please try again.';
}
