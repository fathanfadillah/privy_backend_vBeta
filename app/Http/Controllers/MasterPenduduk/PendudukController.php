<?php

namespace App\Http\Controllers\MasterPenduduk;

use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Model
use App\Models\Pimpinan;

class PendudukController extends Controller
{
    protected $route = 'master-penduduk.penduduk.';
    protected $view  = 'pages.masterPenduduk.penduduk.';
    protected $title = 'Pimpinan';
    protected $path  = '../images/ava/';

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
        $pimpinan = Pimpinan::orderBy('updated_at','desc');
        return DataTables::of($pimpinan)
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
            'nama'  => 'required',
            'jabatan'     => 'required',
             'foto'     => 'required|mimes:png,jpg,jpeg|max:1024'         
            // 'alamat_pedagang' => 'required'
        ]);

                $file     = $request->file('foto');
        $fileName = time() . "." . $file->getClientOriginalName();  
        $request->file('foto')->move("images/ava/", $fileName);

        $pimpinans = new Pimpinan();
        // $pedagang->nm_pedagang     = $request->nm_pedagang;
        // $pedagang->alamat_pedagang = $request->alamat_pedagang;
        // $pedagang->no_ktp = $request->no_ktp;
        // $pedagang->no_telp = $request->no_telp;
       
        $pimpinans->nama = $request->nama;
        $pimpinans->jabatan = $request->jabatan;
        $pimpinans->foto = $fileName;
        $pimpinans->save();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function destroy($id)
    {
        $pimpinans = Pimpinan::findOrFail($id);

        // Proses Delete Foto
        $exist = $pimpinans->foto;
        $path  = "images/ava/" . $exist;
        \File::delete(public_path($path));

        // delete from table admin_details
        $pimpinans->delete();   

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }

    public function edit($id)
    {
        $pimpinans = Pimpinan::findOrFail($id);

        return $pimpinans;
    }

    public function update(Request $request, $id)
    {
        $nama       = $request->nama;
        $jabatan = $request->jabatan;
        $foto  = $request->foto;
        $pimpinans   = Pimpinan::find($id);

        if ($request->foto != null) {
            $request->validate([
                'foto' => 'required|mimes:png,jpg,jpeg|max:2024'
            ]);

            // Proses Saved Foto
                $file     = $request->file('foto');
                $fileName = time() . "." . $file->getClientOriginalName();  
                $request->file('foto')->move("images/ava/", $fileName);

          
            $pimpinans->update([
                'foto' => $fileName,
                'nama'=> $nama,
                'jabatan'=> $jabatan,
            ]);
        }else{
            $pimpinans->update([
              'nama'=> $nama,
                'jabatan'=> $jabatan,
            ]);
        }

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }
}
