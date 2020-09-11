<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visit;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use RealRashid\SweetAlert\Facades\Alert;

class VisitController extends Controller
{
    public function exportPdf()
    {
        $visits = Visit::get();

        $pdf = PDF::loadView('pdf.visita', compact('visits'));

        return $pdf->setPaper('a4','landscape')->stream('visita-list-pdf');
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
        $this->validate($request,[
            'date'       => 'required',
            'assessor'   => 'required',
        ]);

        $visits = new Visit;
        $visits->fill($request->only('date','assessor'));
        $visits->user_id = auth()->user()->id;
        $visits->save();

        return redirect()->route('visits.index')->withToastSuccess('Registro Añadido');
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


        if($visits->user_id != \Auth::user()->id) {
            return redirect()->route('visits.index');
        }

        return view('visits.edit', compact('visits', 'users'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'date'     => 'required',
            'assessor' => 'required',
        ]);

        $visits = Visit::findOrFail($id);

        if($visits->user_id != \Auth::user()->id) {
            return redirect()->route('visits.index');
        }

        $visits->update($request->only('date','assessor'));

        return redirect()->route('visits.index')->withToastInfo('Resgistro Actualizado');
    }

    public function destroy($id)
    {
        $visits = Visit::findOrFail($id);

        if($visits->user_id != \Auth::user()->id) {
            return redirect()->route('posts.index');
        }

        $visits->delete();
        return redirect()->route('visits.index')->withToastError('Registro Borrado');
    }
}
