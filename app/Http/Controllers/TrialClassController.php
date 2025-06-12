<?php

namespace App\Http\Controllers;

use App\Models\StatusTC;
use App\Models\TahunAjaranAktif;
use App\Models\TrialClass;
use Illuminate\Http\Request;

class TrialClassController extends Controller
{
    public function trial_class(){
        $tahun_ajaran = TahunAjaranAktif::where('status_tampil',1)->orderby('id','Desc')->first();
        $id_tahun_ajaran = $tahun_ajaran->id;
        $get_data_trial_class = TrialClass::select('j.id', 'j.nama_jenjang','t_trial_class.id as id_tc','t_trial_class.*','m.tahun_ajaran as tahun_ajar')
        ->leftjoin('m_jenjang as j','j.id','t_trial_class.jenjang_id')
        ->leftjoin('master_tahun_ajaran as m','m.id','t_trial_class.tahun_ajaran')
        ->where('m.id',$id_tahun_ajaran)
        ->get();

        //dump data / ngecek data
        // dd ($get_data_trial_class);
        // $ambil_tgl_input = date("d F Y H:i:s", strtotime(compact("get_data_trial_class",created_at)));

        $status = StatusTC::where('stat', 1)->get();
        // dd ($status);
        // dd($tahun_ajaran);

        return view('admin.laporan.list-trialclass', compact("get_data_trial_class","status"));
    }

    public function simpan_jadwal(Request $request){
        $id = $request->id;
        $tgl_ = $request->tgl_;
        // dd($testimoni_by_id);
        $update_jadwal_tc = TrialClass::where('id',$id)->update([
            'jadwal_tc'=> $tgl_,
        ]);
        
        return response()->json($update_jadwal_tc);
    }

    public function simpan_hasil(Request $request){
        $nomor_eksekusi = $request->nomor_eksekusi;
        $stat = $request->stat;
        $keterangan = $request->keterangan;
        // dd($testimoni_by_id);
        $update_jadwal_tc = TrialClass::where('id',$nomor_eksekusi)->update([
            'hasil_tc'=> $stat,
            'keterangan'=> $keterangan,
        ]);
        
        return response()->json($update_jadwal_tc);
    }
}
