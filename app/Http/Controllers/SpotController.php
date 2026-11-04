<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class SpotController extends CrudController
{
    //
    function save(Request $request, ?string $id)
    {
        // TODO: Implement save() method.
    }

    function delete(string $id)
    {
        // TODO: Implement delete() method.
    }

    function view()
    {
        $spotsByRow = Spot::orderBy('row')
            ->orderBy('index')
            ->get()
            ->groupBy('row');

        return view('spots.spots', compact('spotsByRow'));
    }
}
