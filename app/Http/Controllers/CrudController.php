<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class CrudController extends Controller
{
    abstract function save(Request $request, ?string $id);
    abstract function delete(string $id);
    abstract function view();
    abstract function findById(string $id);
}
