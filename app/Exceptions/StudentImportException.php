<?php

namespace App\Exceptions;

use Exception;

class StudentImportException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }

    public function render($request)
    {
        // Customize the response here
        return response()->view('admin.import.student-import-form', ['message' => $this->getMessage()], 500);
    }
}
