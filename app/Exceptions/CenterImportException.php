<?php

namespace App\Exceptions;

use Exception;

class CenterImportException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }

    public function render($request)
    {
        // Customize the response here
        return response()->view('admin.import.center-import-form', ['message' => $this->getMessage()], 500);
    }
}
