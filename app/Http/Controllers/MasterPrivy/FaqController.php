<?php

namespace App\Http\Controllers\MasterPrivy;

use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Model
use App\Models\Faq;

class FaqController extends Controller
{
    protected $route = 'master-privy.faq.';
    protected $view  = 'pages.masterPrivy.faq.';
    protected $title = 'Faq';
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
        $faq = Faq::orderBy('updated_at','desc');
        return DataTables::of($faq)
            ->addColumn('action', function ($f) {
                return "
                <a href='#' onclick='edit(" . $f->id . ")' title='Edit Role'><i class='icon-pencil mr-1'></i></a>
                <a href='#' onclick='remove(" . $f->id . ")' class='text-danger' title='Hapus Role'><i class='icon-remove'></i></a>";
            })
            
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
            
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'no_telp' => 'required',
            'kategori'  => 'required',
            'question'  => 'required',
            'answer'     => 'required'
           ]);

        $faqs = new Faq();
        // $pedagang->nm_pedagang     = $request->nm_pedagang;
        // $pedagang->alamat_pedagang = $request->alamat_pedagang;
        // $pedagang->no_ktp = $request->no_ktp;
        // $pedagang->no_telp = $request->no_telp;
        $faqs->kategori = $request->kategori;
        $faqs->question = $request->question;
        $faqs->answer = $request->answer;
        $faqs->save();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function destroy($id)
    {
        $faqs = Faq::findOrFail($id);

        $faqs->delete();   

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }

    public function edit($id)
    {
        $faqs = Faq::findOrFail($id);

        return $faqs;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori'  => 'required', 
            'question'  => 'required',
            'answer'     => 'required'
        ]);
        
        $kategori       = $request->kategori;
        $question       = $request->question;
        $answer = $request->answer;
        
        $faqs   = Faq::find($id);

            $faqs->update([
                'kategori'=> $kategori,
              'question'=> $question,
                'answer'=> $answer
            ]);        

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }
}