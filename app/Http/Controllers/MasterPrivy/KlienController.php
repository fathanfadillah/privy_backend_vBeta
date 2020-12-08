<?php

namespace App\Http\Controllers\MasterPrivy;

use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Model
use App\Models\Klien;

class KlienController extends Controller
{
    protected $route = 'master-privy.klien.';
    protected $view  = 'pages.masterPrivy.klien.';
    protected $title = 'klien';
    protected $path  = '../images/privy/';
    

    public function index()
    {
        $route = $this->route;
        $title = $this->title;
        $path = $this->path;
        // dd($route);
        return view($this->view . 'index', compact(
            'route',
            'title',
            'path'
        ));
    }

    public function api()
    {
        $kliens = Klien::orderBy('updated_at','desc');
        return DataTables::of($kliens)
            ->addColumn('action', function ($p) {
                return "
                <a href='#' onclick='edit(" . $p->id . ")' title='Edit Role'><i class='icon-pencil mr-1'></i></a>
                <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Role'><i class='icon-remove'></i></a>";
            })
            ->editColumn('foto',  function ($p) {
                if ($p->foto != null) {
                    return "<img width='50' class='img-fluid mx-auto d-block rounded-circle' alt='foto' src='" . $this->path . $p->foto . "'>";
                } else {
                    return "<img width='50' class='rounded img-fluid mx-auto d-block' alt='foto' src='" . asset('images/404.png') . "'>";
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'foto'])
            ->toJson();
            
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'no_telp' => 'required',
            'foto'     => 'required|mimes:png,jpg,jpeg|max:1024'         
            // 'alamat_pedagang' => 'required'
        ]);

                $file     = $request->file('foto');
        $fileName = time() . "." . $file->getClientOriginalName();  
        $request->file('foto')->move("images/privy/", $fileName);

        $kliens = new Klien();
        // $pedagang->nm_pedagang     = $request->nm_pedagang;
        // $pedagang->alamat_pedagang = $request->alamat_pedagang;
        // $pedagang->no_ktp = $request->no_ktp;
        // $pedagang->no_telp = $request->no_telp;
       
        $kliens->foto = $fileName;
        $kliens->save();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function destroy($id)
    {
        $kliens = Klien::findOrFail($id);

        // Proses Delete Foto
        $exist = $kliens->foto;
        $path  = "images/privy/" . $exist;
        \File::delete(public_path($path));

        // delete from table admin_details
        $kliens->delete();   

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }

    public function edit($id)
    {
        $kliens = klien::findOrFail($id);

        return $kliens;
    }

    public function update(Request $request, $id)
    {
        $foto  = $request->foto;
        $kliens   = Klien::find($id);

        if ($request->foto != null) {
            $request->validate([
                'foto' => 'required|mimes:png,jpg,jpeg|max:2024'
            ]);

            // Proses Saved Foto
                $file     = $request->file('foto');
                $fileName = time() . "." . $file->getClientOriginalName();  
                $request->file('foto')->move("images/privy/", $fileName);

          
            $kliens->update([
                'foto'=> $fileName
            ]);
        }

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }
}