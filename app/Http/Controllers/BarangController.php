<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
// use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* tanpa pagination
        $Barang = Barang::all();        
        return view('view_barang.index01',compact('Barang'));
        */

        /* ada pagination */
        $rBarang = Barang::latest()->paginate(10);        
        return view('view_barang.index',compact('rBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriOptions= Kategori::all();
        // return view('view_barang.create' compact('kategoriOptions'));
        return view('view_barang.create', compact('kategoriOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;

       // dd("");
        //validate form
        $this->validate($request, [
            'merk'    => 'required',
            'seri'     => 'required',
            'spesifikasi'     => 'required',
            'kategori_id'  => 'required',
            // 'kelas'   => 'required|not_in:blank',
            // 'rombel'  => 'required',
        //     'foto'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // //upload image
        // $foto = $request->file('foto');
        // $foto->storeAs('public/foto', $foto->hashName());

        //create post
        Barang::create([
            'merk'     => $request->merk,
            'seri'      => $request->seri,
            'spesifikasi'      => $request->spesifikasi,
            'kategori_id'   => $request->kategori_id
            // 'foto'     => $foto->hashName()
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rBarang = Barang::find($id);

        //return $Barang;

        //return view
        return view('view_barang.show', compact('rBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        // $akategori = array('blank'=>'Pilih Barang',
        //                             'M'=>'M - Makanan',
        //                             'A'=>'A - Angkutan',
        //                             'BHP'=>'BHP - Beras',
        //                             'BTHP'=>'BTHP - Batu'
        //                 );

        // $rBarang = Barang::find($id);
        // return view('view_barang.edit', compact('rBarang','akategori'));

        $kategoriOptions = Kategori::all();                    
        // return view('view_barangg.create',compact('kategoriOptions'));
        $rBarang = Barang::find($id);
        $selectedkategori = Kategori::find($rBarang->kategori_id); 
        //return $rBarang;
        return view('view_barang.edit', compact('rBarang','kategoriOptions', 'selectedkategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'merk'    => 'required',
            'seri'     => 'required',
            'spesifikasi'  => 'required',
            'kategori_id'  => 'required'
        ]);

        $rBarang = Barang::find($id);


        //update post without image
        $rBarang->update([
            'merk'     => $request->merk,
            'seri'      => $request->seri,
            'spesifikasi'   => $request->spesifikasi,
            'kategori_id'   => $request->kategori_id,
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rBarang = Barang::find($id);
        //delete image
        Storage::delete('public/foto/'. $rBarang->foto);

        //delete post
        $rBarang->delete();

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}