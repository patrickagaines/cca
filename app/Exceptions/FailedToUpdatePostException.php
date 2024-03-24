<?php

namespace App\Exceptions;

use Exception;

class FailedToUpdatePostException extends Exception
{
    protected $code = 422;
    protected $message = 'An error occurred while updating your post. Please try again.';
}
