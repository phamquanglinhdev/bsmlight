<?php

namespace App\Http\Controllers;

use App\Helper\CrudBag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public CrudBag $crudBag;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(CrudBag $crudBag)
    {
        $this->crudBag = $crudBag;
    }
}
