<?php

namespace App\Http\Controllers\MasterPrivy;

use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Model
use App\Models\Enterprise;

class EnterpriseController extends Controller
{
    protected $route = 'master-privy.enterprise.';
    protected $view  = 'pages.masterPrivy.enterprise.';
    protected $title = 'Enterprise';
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
        $enterprise = Enterprise::orderBy('updated_at','desc');
        return DataTables::of($enterprise)
            ->addColumn('action', function ($e) {
                return "
                <a href='#' onclick='edit(" . $e->id . ")' title='Edit Role'><i class='icon-pencil mr-1'></i></a>
                <a href='#' onclick='remove(" . $e->id . ")' class='text-danger' title='Hapus Role'><i class='icon-remove'></i></a>";
            })
            ->editColumn('foto',  function ($e) {
                if ($e->foto != null) {
                    return "<img width='50' class='img-fluid mx-auto d-block rounded-circle' alt='foto' src='" . $this->path . $e->foto . "'>";
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
        $data = $request()->validate([
            'title'  => 'required',
            'deskripsi'     => 'required',
             'foto'     => 'required|mimes:png,jpg,jpeg|max:1024'         
         ]);

        $file     = $request->file('foto');
        $fileName = time() . "." . $file->getClientOriginalName();  
        $request->file('foto')->move("images/privy/", $fileName);

        $enterprises = new Enterprise();
        $enterprises->title = $request->title;
        $enterprises->deskripsi = $request->deskripsi;
        $enterprises->foto = $fileName;
        $enterprises->save();
                

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function destroy($id)
    {
        $enterprises = Enterprise::findOrFail($id);

        // Proses Delete Foto
        $exist = $enterprises->foto;
        $path  = "images/privy/" . $exist;
        \File::delete(public_path($path));

        // delete from table admin_details
        $enterprises->delete();   

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }

    public function edit($id)
    {
        $enterprises = Enterprise::findOrFail($id);

        return $enterprises;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'no_telp' => 'required',
            'title'  => 'required',
            'deskripsi'     => 'required'
            //  'foto'     => 'required|mimes:png,jpg,jpeg|max:1024'         
            // 'alamat_pedagang' => 'required'
        ]);
        
        
        $title       = $request->title;
        $deskripsi = $request->deskripsi;
        $foto  = $request->foto;
        
        $enterprises   = Enterprises::find($id);

        if ($request->foto != null) {
            $request->validate([
                'foto' => 'required|mimes:png,jpg,jpeg|max:2024'
            ]);

            // Proses Saved Foto
                $file     = $request->file('foto');
                $fileName = time() . "." . $file->getClientOriginalName();  
                $request->file('foto')->move("images/privy/", $fileName);

          
            $enterprises->update([
                'foto' => $fileName,
                'title'=> $title,
                'deskripsi'=> $deskripsi,
            ]);
        }else{
            $enterprises->update([
              'title'=> $title,
                'deskripsi'=> $deskripsi,
            ]);
        }

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }
}