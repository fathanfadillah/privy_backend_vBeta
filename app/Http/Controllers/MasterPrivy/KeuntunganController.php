<?php

namespace App\Http\Controllers\MasterPrivy;

use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Model
use App\Models\Keuntungan;

class KeuntunganController extends Controller
{
    protected $route = 'master-privy.keuntungan.';
    protected $view  = 'pages.masterPrivy.keuntungan.';
    protected $title = 'Keuntungan';
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
        $keuntungans = Keuntungan::orderBy('updated_at','desc');
        return DataTables::of($keuntungans)
            ->addColumn('action', function ($k) {
                return "
                <a href='#' onclick='edit(" . $k->id . ")' title='Edit Role'><i class='icon-pencil mr-1'></i></a>
                <a href='#' onclick='remove(" . $k->id . ")' class='text-danger' title='Hapus Role'><i class='icon-remove'></i></a>";
            })
            ->editColumn('icon',  function ($k) {
                if ($k->icon != null) {
                    return "<img width='50' class='img-fluid mx-auto d-block rounded-circle' alt='icon' src='" . $this->path . $k->icon . "'>";
                } else {
                    return "<img width='50' class='rounded img-fluid mx-auto d-block' alt='icon' src='" . asset('images/404.png') . "'>";
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'icon'])
            ->toJson();
            
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'no_telp' => 'required',
            'title_keuntungan'  => 'required',
            'deskripsi_keuntungan'     => 'required',
             'icon'     => 'required|mimes:png,jpg,jpeg|max:1024'         
            // 'alamat_pedagang' => 'required'
        ]);

                $file     = $request->file('icon');
        $fileName = time() . "." . $file->getClientOriginalName();  
        $request->file('icon')->move("images/privy/", $fileName);

        $keuntungans = new Keuntungan();
        
        $keuntungans->title_keuntungan = $request->title_keuntungan;
        $keuntungans->deskripsi_keuntungan = $request->deskripsi_keuntungan;
        $keuntungans->icon = $fileName;
        $keuntungans->save();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function destroy($id)
    {
        $keuntungans = Keuntungan::findOrFail($id);

        // Proses Delete Foto
        $exist = $keuntungans->icon;
        $path  = "images/privy/" . $exist;
        \File::delete(public_path($path));

        // delete from table admin_details
        $keuntungans->delete();   

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }

    public function edit($id)
    {
        $keuntungans = Keuntungan::findOrFail($id);
        return $keuntungans;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'no_telp' => 'required',
            'title_keuntungan'  => 'required',
            'deskripsi_keuntungan'     => 'required',
            // 'icon'     => 'required|mimes:png,jpg,jpeg|max:1024'         
            // 'alamat_pedagang' => 'required'
        ]);

        $title_keuntungan       = $request->title_keuntungan;
        $deskripsi_keuntungan = $request->deskripsi_keuntungan;
        $icon  = $request->icon;
        
        $keuntungans   = Keuntungan::find($id);

        if ($request->icon != null) {
            $request->validate([
                'icon' => 'required|mimes:png,jpg,jpeg|max:2024'
            ]);

            // Proses Saved Foto
                $file     = $request->file('icon');
                $fileName = time() . "." . $file->getClientOriginalName();  
                $request->file('icon')->move("images/privy/", $fileName);

          
            $keuntungans->update([
                'icon' => $fileName,
                'title_keuntungan'=> $title_keuntungan,
                'deskripsi_keuntungan'=> $deskripsi_keuntungan,
            ]);
        }else{
            $keuntungans->update([
              'title_keuntungan'=> $title_keuntungan,
                'deskripsi_keuntungan'=> $deskripsi_keuntungan,
            ]);
        }

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }
}