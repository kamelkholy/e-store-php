<?php

namespace App\Exceptions;

use Exception;

class CategoryHasChildrenException extends Exception
{
    //
    public function report()
    {
    }
    public function render($request)
    {
        return redirect()->back()->withErrors(["This Category Has Children"]);
    }
}
