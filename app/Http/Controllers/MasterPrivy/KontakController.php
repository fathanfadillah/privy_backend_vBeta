<?php

namespace App\Http\Controllers\MasterPrivy;

use DataTables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kontak_bisnis;

class KontakController extends Controller
{
    protected $route = 'master-privy.kontakBisnis.';
    protected $view  = 'pages.masterPrivy.kontakBisnis.';
    protected $title = 'Kontak Bisnis';
    public function index()
    {
        $route = $this->route;
        $title = $this->title;
        
        return view($this->view . 'index', compact(
            'route',
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function api()
    {
        $kontaks = Kontak_bisnis::orderBy('updated_at','desc');
        return DataTables::of($kontaks)
            ->addColumn('action', function ($k) {
                return "
                <a href='#' onclick='remove(" . $k->id . ")' class='text-danger' title='Hapus Role'><i class='icon-remove'></i></a>";
            })
            
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }
    
    public function destroy($id)
    {
        $kontaks = Kontak_bisnis::findOrFail($id);

        $kontaks->delete();   

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }
}