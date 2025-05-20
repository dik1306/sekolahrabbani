<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Csdm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class CsdmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $csdm = User::get_user_csdm();
        return view('karir.admin.csdm.index', compact('csdm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('karir.admin.csdm.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_csdm' => 'required',
            'name' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'password' => 'required',
        ]);

        User::create([
            'kode_csdm' => $request->kode_csdm,
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'id_role' => 3
        ]);

        return redirect()->route('karir.admin.csdm')
            ->with('success', 'User Csdm created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Csdm  $csdm
     * @return \Illuminate\Http\Response
     */
    public function show(Csdm $csdm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Csdm  $csdm
     * @return \Illuminate\Http\Response
     */
    public function edit(Csdm $csdm, $id)
    {
        $user_csdm = User::find($id);
        return view('karir.admin.csdm.edit', compact('user_csdm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Csdm  $csdm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Csdm $csdm, $id)
    {
        $request->validate([
            'kode_csdm' => 'required',
            'name' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'password' => 'required',
        ]);

        User::find($id)->update([
            'kode_csdm' => $request->kode_csdm,
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('karir.admin.csdm')
            ->with('success', 'User Csdm updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Csdm  $csdm
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect()->route('karir.admin.csdm')
            ->with('success', 'CSDM Diklat deleted successfully');
    }


    public function import_excel(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
		$nama_file = rand().$file->getClientOriginalName();
		$file->move('user_csdm',$nama_file);
		Excel::import(new UsersImport, public_path('/user_csdm/'.$nama_file));
 
		// alihkan halaman kembali
		return redirect()->route('karir.admin.csdm');
	}
}
