<?php

namespace App\Http\Controllers\MasterPedagang;

use DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// Models
use App\Models\Pedagang;
use App\Models\PasarKategori;
use App\Models\PedagangAlamat;

class PedagangAlamatController extends Controller
{
    protected $route = 'master-pedagang.pedagangAlamat.';
    protected $view  = 'pages.masterPedagang.pedagangAlamat.';
    protected $title = 'Pedagang Alamat';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        $pedagang   = Pedagang::select('id', 'nm_pedagang')->orderBy('nm_pedagang', 'ASC')->get();
        $alamatToko = PasarKategori::select('id', 'tm_pasar_id', 'tm_jenis_lapak_id', 'ukuran')->whereNotIn('jumlah', [0])->with('pasar', 'jenisLapak')->get();

        return view($this->view . 'index', compact(
            'route',
            'title',
            'pedagang',
            'alamatToko'
        ));
    }

    public function api()
    {
        $pedagangAlamat = PedagangAlamat::all();
        return DataTables::of($pedagangAlamat)
            ->addColumn('action', function ($p) {
                return "
                <a href='#' onclick='edit(" . $p->id . ")' title='Edit Role'><i class='icon-pencil mr-1'></i></a>
                <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Role'><i class='icon-remove'></i></a>";
            })
            ->editColumn('tm_pedagang_id', function ($p) {
                return "<a href='" . route($this->route . 'show', $p->id) . "' class='text-primary' title='Show Data'>" . $p->pedagang->nm_pedagang . "</a>";
            })
            ->editColumn('tm_pasar_kategori_id', function ($p) {
                return $p->pasarkategori->pasar->nm_pasar;
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'tm_pedagang_id'])
            ->toJson();
    }

    public function show($id)
    {
        $route = $this->route;
        $title = $this->title;

        $pedagangAlamat = PedagangAlamat::findOrFail($id);

        return view($this->view . 'show', compact(
            'route',
            'title',
            'pedagangAlamat'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tm_pedagang_id' => 'required|unique:tm_pedagang_alamats,tm_pedagang_id',
            'tm_pasar_kategori_id' => 'required',
            'nm_toko' => 'required|unique:tm_pedagang_alamats,nm_toko',
            'nm_blok' => 'required',
            'tgl_tinggal' => 'required',
            'status' => 'required'
        ]);

        /**
         * Tahapan :
         * 1. tm_pedagang_alamats
         * 2. tm_pasar_kategoris
         */

        //  Tahap 1
        $tm_pedagang_id = $request->tm_pedagang_id;
        $tm_pasar_kategori_id = $request->tm_pasar_kategori_id;
        $nm_toko = $request->nm_toko;
        $nm_blok = $request->nm_blok;
        $tgl_tinggal = $request->tgl_tinggal;
        $status = $request->status;

        // generate kd_toko
        $check  = PasarKategori::find($tm_pasar_kategori_id);
        $digit1 = $check->pasar->id;
        if (\strlen($digit1) == 1) {
            $digit1 = 0 . $digit1;
        }
        $digit2 = $check->jenisLapak->id;
        if (\strlen($digit2) == 1) {
            $digit2 = 0 . $digit2;
        }
        $digit3 = $check->pasar->id_kel;
        if (\strlen($digit3) == 1) {
            $digit3 = 0 . $digit3;
        }
        $kd_toko = $digit1 . $digit2 . $digit3;

        $pedagangAlamat = new PedagangAlamat();
        $pedagangAlamat->tm_pedagang_id = $tm_pedagang_id;
        $pedagangAlamat->tm_pasar_kategori_id = $tm_pasar_kategori_id;
        $pedagangAlamat->nm_toko = $nm_toko;
        $pedagangAlamat->kd_toko = $kd_toko;
        $pedagangAlamat->nm_blok = $nm_blok;
        $pedagangAlamat->tgl_tinggal = $tgl_tinggal;
        $pedagangAlamat->status = $status;
        $pedagangAlamat->save();

        // Tahap 2
        DB::update('UPDATE tm_pasar_kategoris SET jumlah = jumlah - 1 WHERE id = "' . $tm_pasar_kategori_id . '"');

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        $pedagangAlamat = PedagangAlamat::find($id);

        return $pedagangAlamat;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tm_pedagang_id' => 'required|unique:tm_pedagang_alamats,tm_pedagang_id,' . $id,
            'tm_pasar_kategori_id' => 'required',
            'nm_toko' => 'required|unique:tm_pedagang_alamats,nm_toko,' . $id,
            'nm_blok' => 'required',
            'tgl_tinggal' => 'required',
            'status' => 'required'
        ]);

        /**
         * Tahapan :
         * 1. tm_pedagang_alamats
         * 2. tm_pasar_kategoris
         */

        //  Tahap 1
        $tm_pedagang_id = $request->tm_pedagang_id;
        $tm_pasar_kategori_id = $request->tm_pasar_kategori_id;
        $oldValue = $request->old('tm_pasar_kategori_id');
        $nm_toko = $request->nm_toko;
        $nm_blok = $request->nm_blok;
        $tgl_tinggal = $request->tgl_tinggal;
        $status = $request->status;

        // add jumlah -1
        DB::update('UPDATE tm_pasar_kategoris SET jumlah = jumlah - 1 WHERE id = "' . $tm_pasar_kategori_id . '"');

        // generate kd_toko
        $check  = PasarKategori::find($tm_pasar_kategori_id);
        $digit1 = $check->pasar->id;
        if (\strlen($digit1) == 1) {
            $digit1 = 0 . $digit1;
        }
        $digit2 = $check->jenisLapak->id;
        if (\strlen($digit2) == 1) {
            $digit2 = 0 . $digit2;
        }
        $digit3 = $check->pasar->id_kel;
        if (\strlen($digit3) == 1) {
            $digit3 = 0 . $digit3;
        }
        $kd_toko = $digit1 . $digit2 . $digit3;

        $pedagangAlamat = PedagangAlamat::find($id);
        $pedagangAlamat->update([
            'tm_pedagang_id' => $tm_pedagang_id,
            'tm_pasar_kategori_id' => $tm_pasar_kategori_id,
            'nm_toko' => $nm_toko,
            'kd_toko' => $kd_toko,
            'nm_blok' => $nm_blok,
            'tgl_tinggal' => $tgl_tinggal,
            'status' => $status
        ]);

        // Tahap 2
        DB::update('UPDATE tm_pasar_kategoris SET jumlah = jumlah + 1 WHERE id = "' . $oldValue . '"');

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        $pedagangAlamat = PedagangAlamat::find($id);

        // Update table tm_pasar_kategoris
        DB::update('UPDATE tm_pasar_kategoris SET jumlah = jumlah + 1 WHERE id = "' . $pedagangAlamat->tm_pasar_kategori_id . '"');

        // delete from tabel tm_pedagang_alamat
        $pedagangAlamat->delete();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }
}
