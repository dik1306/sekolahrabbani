<?php

namespace App\Http\Controllers;

use App\Models\MenuMobile;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $profile = Profile::get_user_profile_byphone($user->no_hp);
        $menu_profile = MenuMobile::where('is_profile', 1)->orderby('no', 'asc')->get();
        // dd($menu_profile);
        $menubar = MenuMobile::where('is_footer', 1)->orderBy('no', 'asc')->get();
        

        return view('ortu.profile.index', compact('profile', 'menu_profile', 'menubar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function change_password(Request $request) {

        $menubar = MenuMobile::where('is_footer', 1)->orderBy('no', 'asc')->get();

        return view('ortu.profile.change-password', compact('menubar'));
    }

    public function update_password(Request $request) {

        $request->validate([
            // 'old_pass' => 'required',
            'new_pass' => 'required|confirmed',
        ]);

        $user_id = Auth::user()->id;
        $pass_lama = $request->old_pass;
        $pass_baru = $request->new_pass;
        $confirm_new_pass = $request->new_pass_confirmation;

        if (!Hash::check($pass_lama, auth()->user()->password)){
            return back()->with("error", "Password lama salah");
        } 

         #Update the new Password
        User::whereId($user_id)->update([
            'password' => Hash::make($pass_baru)
        ]);

        #update pass_akun profile
        Profile::where('user_id', $user_id)->where('pass_akun', $pass_lama)->update([
            'pass_akun' => $pass_baru
        ]);

        return back()->with("success", "Password berhasil diganti!");

    }
}
