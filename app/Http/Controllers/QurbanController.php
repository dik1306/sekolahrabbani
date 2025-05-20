<?php

namespace App\Http\Controllers;

use App\Exports\HaveWatchExport;
use App\Models\EdukasiQurban;
use App\Models\HaveWatch;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class QurbanController extends Controller
{
    public function master_materi_qurban()
    {
        $materi_tksd = EdukasiQurban::where('jenjang', 1)->get();
        $materi_smp = EdukasiQurban::where('jenjang', 2)->get();
        return view('admin.master.qurban.index', compact('materi_tksd', 'materi_smp'));
    }

    public function master_materi_by_id(Request $request, $id)
    {
        $detail_materi = EdukasiQurban::where('id', $id)->first();

        return response($detail_materi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'required'
        ]);

        $user = Auth::user()->name;

        $image = null;
        $image_url = null;
        $path = 'qurban/gambar';
        if ($request->has('gambar')) {
            $image = $request->file('gambar')->store($path);
            $image_name = $request->file('gambar')->getClientOriginalName();
            $image_url = $path . '/' . $image_name;
            Storage::disk('public')->put($image_url, file_get_contents($request->file('gambar')->getRealPath()));
        } else {
            return redirect()->back()->with('error', 'Image tidak boleh kosong');
        }

        EdukasiQurban::create([
            'judul' => $request->judul,
            'style' => $request->warna,
            'deskripsi' => $request->deskripsi,
            'image' => $image_url,
            'status'  => 1,
            'link_video' => $request->link_video,
            'terbit'  => $request->terbit,
            'jenjang' => $request->jenjang,
            'created_by' => $request->penulis,
            'updated_by' => $user,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Materi created successfully.');
    }

    public function update_materi(Request $request, $id)
    {
        try {
            $user = Auth::user()->name;
    
            $image = null;
            $image_url = null;
            $path = 'qurban/gambar';
            if ($request->has('gambar')) {
                $image = $request->file('gambar')->store($path);
                $image_name = $request->file('gambar')->getClientOriginalName();
                $image_url = $path . '/' . $image_name;
                Storage::disk('public')->put($image_url, file_get_contents($request->file('gambar')->getRealPath()));
            }

            $update_materi = EdukasiQurban::where('id', $id)->update([
                'judul' => $request->judul_edit,
                'style' => $request->warna_edit,
                'status'  => $request->status_edit,
                'terbit'  => $request->terbit_edit,
                'link_video' => $request->link_video_edit,
                'jenjang' => $request->jenjang_edit,
                'created_by' => $request->penulis_edit,
                'design_by' => $request->design_by_edit,
                'updated_by' => $user,
            ]);
            return redirect()->back()->withSuccess('Success update Materi ');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }

        
    }

    public function list_sudah_nonton()
    {
        $haveWatch = HaveWatch::select('t_sudah_materi_qurban.materi_id', 't_sudah_materi_qurban.created_at', 'mpro.nis', 'mpro.nama_lengkap', 'mls.sublokasi as lokasi', 'mpro.nama_kelas', 'mpd.judul', )
                            ->leftJoin('m_edukasi_qurban as mpd', 'mpd.id', 't_sudah_materi_qurban.materi_id')
                            ->leftJoin('m_profile as mpro', 'mpro.nis', 't_sudah_materi_qurban.nis')
                            ->leftJoin('mst_lokasi_sub as mls', 'mpro.sekolah_id', 'mls.id')
                            ->groupby('t_sudah_materi_qurban.materi_id', 't_sudah_materi_qurban.nis')
                            ->orderby('t_sudah_materi_qurban.created_at', 'Desc')
                            ->get();

        return view('admin.master.qurban.sudah-nonton', compact('haveWatch'));
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $id_role = Auth::user()->id_role;
        $user_phone = Auth::user()->no_hp;

        $keys = ['7', '5', '6', '7', '8', '9'];
        $keywords = [];
        foreach($keys as $key){
            $keywords[] = ['nama_kelas', 'LIKE', '%'.$key.'%'];
        }

        $get_jenjang_tksd = DB::table('m_profile')->where('no_hp_ibu', $user_phone)  
                            ->Where(function ($query) {
                                $query->whereIn('jenjang_id', [1,2])
                                    ->orwhere('nama_kelas', 'like', '1%')
                                    ->orwhere('nama_kelas', 'like', '2%')
                                    ->orwhere('nama_kelas', 'like', '3%');
                                    

                            })
                            ->groupBy('no_hp_ibu')
                            ->get();

        $get_jenjang = DB::table('m_profile')->where('no_hp_ibu', $user_phone) 
                            ->Where(function ($query) {
                                $query->where('jenjang_id', 4)
                                    ->orwhere('nama_kelas', 'like', '4%')
                                    ->orwhere('nama_kelas', 'like', '5%')
                                    ->orwhere('nama_kelas', 'like', '6%')
                                    ->orwhere('nama_kelas', 'like', '7%')
                                    ->orwhere('nama_kelas', 'like', '8%')
                                    ->orwhere('nama_kelas', 'like', '9%');
                            })
                            ->groupBy('no_hp_ibu')
                            ->get();


        return view('ortu.qurban.index', compact('get_jenjang_tksd', 'get_jenjang', 'id_role'));
        
    }

    public function materi_tksd()
    {
        $user_id = Auth::user()->id;

        $materi = EdukasiQurban::where('jenjang', 1)->where('status', 1)->get();

        return view('ortu.qurban.materi-tksd', compact('materi'));
        
    }

    public function materi_smp()
    {
        $user_id = Auth::user()->id;

        $materi = EdukasiQurban::where('jenjang', 2)->where('status', 1)->get();

        return view('ortu.qurban.materi-smp', compact('materi'));
        
    }

    public function materi_tksd_by_id($id)
    {
        $user_id = Auth::user()->id;

        $materi = EdukasiQurban::find($id);

        $sudah_nonton = HaveWatch::where('user_id', $user_id)->where('materi_id', $id)->first();

        return view('ortu.qurban.materi-tksd-by-id', compact('materi', 'sudah_nonton'));
        
    }

    public function materi_smp_by_id($id)
    {
        $user_id = Auth::user()->id;

        $materi = EdukasiQurban::find($id);

        $sudah_nonton = HaveWatch::where('user_id', $user_id)->where('materi_id', $id)->first();

        return view('ortu.qurban.materi-smp-by-id', compact('materi', 'sudah_nonton'));
        
    }

    public function sudah_baca(Request $request) {
        $user = auth()->user();
        $user_id = $user->id;
        $no_hp = $user->no_hp;
        $user_name = $user->name;
        $materi_id = $request->materi_id;

        $materi = EdukasiQurban::find($materi_id);
        
        $get_jenjang = $materi->jenjang;

        if ($get_jenjang == 2) {
            $jenjang = 'UBRSMP';

            $data = Profile::select('m_profile.nis')
                            ->leftJoin('t_sudah_materi_qurban as tsbm', 'tsbm.user_id', 'm_profile.user_id')
                            ->leftJoin('m_edukasi_qurban as meq', 'meq.id', 'tsbm.materi_id')
                            ->where('m_profile.no_hp_ibu', $no_hp)
                            ->groupby('m_profile.no_hp_ibu', 'm_profile.nis', 'tsbm.materi_id')
                            ->get();
            
            
            foreach ($data as $item) {
                $store_have_read = HaveWatch::create([
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'nis' => $item['nis'],
                    'materi_id' => $materi_id,
                ]);
            }
            return response()->json($store_have_read);

        } else {
            $data = Profile::select('m_profile.nis')
                            ->leftJoin('t_sudah_materi_qurban as tsbm', 'tsbm.user_id', 'm_profile.user_id')
                            ->leftJoin('m_edukasi_qurban as meq', 'meq.id', 'tsbm.materi_id')
                            ->where('m_profile.no_hp_ibu', $no_hp)
                            ->groupby('m_profile.no_hp_ibu', 'm_profile.nis', 'tsbm.materi_id')
                            ->get();

            foreach ($data as $item) {
                $store_have_read = HaveWatch::create([
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'nis' => $item['nis'],
                    'materi_id' => $materi_id,
                ]);
            }
            return response()->json($store_have_read);
        }

    }

    public function export_have_read()
    {
        $now = date('d-m-y');
        $file_name = 'have-watch-qurban-'.$now.'.xlsx';
        return Excel::download(new HaveWatchExport(), $file_name);
    }
}
