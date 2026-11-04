<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class SpotController extends CrudController
{
    function save(Request $request, ?string $id = null)
    {
        if (!$id) {
            $lastSpot = Spot::orderBy('id', 'desc')->first();

            if ($lastSpot) {
                $rowLetter = $lastSpot->row;
                $rowLetter++;
                $rowLetter = strtoupper($rowLetter);
            } else {
                $rowLetter = 'A';
            }

            while (Spot::where('row', $rowLetter)->where('index', 1)->exists()) {
                $rowLetter++;
                $rowLetter = strtoupper($rowLetter);
            }

            Spot::create([
                'row' => $rowLetter,
                'index' => 1,
            ]);
        } else {
            $rowLetter = strtoupper($id);

            $lastIndex = Spot::where('row', $rowLetter)->max('index') ?? 0;
            $nextIndex = $lastIndex + 1;

            Spot::create([
                'row' => $rowLetter,
                'index' => $nextIndex,
            ]);
        }

        return redirect()->route('spot');
    }

    function delete(string $id)
    {
        $spot = Spot::findOrFail($id);

        $isOcupada = $spot->parking && is_null($spot->parking->horario_saida);

        if ($isOcupada) {
            return redirect()->route('spot')->with('error', 'Não é possível excluir uma vaga que está ocupada!');
        }

        $spot->forceDelete();

        return redirect()->route('spot')->with('success', 'Vaga excluída com sucesso!');
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
