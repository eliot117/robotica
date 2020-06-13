<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visit;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;

class VisitController extends Controller
{
    public function exportPdf()
    {
        $bitacoraservicio = BitacorasSe::get();

        $pdf = PDF::loadView('pdf.bitacoraservicio', compact('bitacoraservicio'));

        return $pdf->setPaper('a4','landscape')->stream('bitacoraservicio-list-pdf');
    }

    public function index()
    {
        $visits = Visit::all();
        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $users = User::get();
        return view('visits.create', compact('users'));
    }

    public function store(Request $request)
    {
        $visits = Visit::create($request->all());
        return redirect()->route('visits.index')->with('Registro Añadido');
    }

    public function show($id)
    {
        $visits = Visit::findOrFail($id);
        return view('visits.show', compact('visits'));
    }

    public function edit($id)
    {
        $visits = Visit::findOrFail($id);
        $users  = User::all();
        return view('visits.edit', compact('visits', 'users'));
    }

    public function update(Request $request, $id)
    {
        $visits = Visit::findOrFail($id);

        $visits->date = $request->input('date');
        $visits->save();

        return redirect()->route('visits.index')->with('Resgistro Actualizado');
    }

    public function destroy($id)
    {
        $visits = Visit::findOrFail($id)->delete();
        return redirect()->route('visits.index')->with('Registro Borrado');
    }
}
