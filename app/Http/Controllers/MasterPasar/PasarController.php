<?php

namespace App\Http\Controllers\MasterPasar;

use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Modes
use App\Models\Pasar;

class PasarController extends Controller
{
    protected $route = 'master-pasar.pasar.';
    protected $view  = 'pages.masterPasar.pasar.';
    protected $title = 'Pasar';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        return view($this->view . 'index', compact(
            'route',
            'title'
        ));
    }

    public function api()
    {
        $pasar = Pasar::all();
        return DataTables::of($pasar)
            ->addColumn('action', function ($p) {
                return "
                <a href='#' onclick='edit(" . $p->id . ")' title='Edit Role'><i class='icon-pencil mr-1'></i></a>
                <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Role'><i class='icon-remove'></i></a>";
            })
            ->editColumn('nm_pasar', function ($p) {
                return "<a href='" . route($this->route . 'show', $p->id) . "' class='text-primary' title='Show Data'>" . $p->nm_pasar . "</a>";
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'nm_pasar'])
            ->toJson();
    }

    public function show($id)
    {
        $route = $this->route;
        $title = $this->title;

        $pasar = Pasar::find($id);

        return view($this->view . 'show', compact(
            'route',
            'title',
            'pasar'
        ));
    }
}
