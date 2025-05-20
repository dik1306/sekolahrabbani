<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekolah Rabbani | QLP</title>
    <link href="{{ asset('assets/images/logo-yayasan_1.png') }}" rel="icon" type="image/jpg">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css?v=').time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"  type='text/css'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"  />

</head>

<body>
  
    <div>
        <header>
            @if (Route::currentRouteName() == 'karir.profile' || Route::currentRouteName() == 'karir.kelas'  || Route::currentRouteName() == 'karir.edit_profile' 
                || Route::currentRouteName() == 'karir.kelas_pertemuan' || Route::currentRouteName() == 'karir.admin' || Route::currentRouteName() =='karir.profile_by_id'
                || Route::currentRouteName() == 'karir.admin.modul' || Route::currentRouteName() == 'admin.create_modul' || Route::currentRouteName() == 'admin.edit_modul'
                || Route::currentRouteName() == 'karir.admin.kelas' || Route::currentRouteName() == 'admin.create_kelas' || Route::currentRouteName() == 'admin.edit_kelas'
                || Route::currentRouteName() == 'karir.admin.tugas' || Route::currentRouteName() == 'admin.create_tugas' || Route::currentRouteName() == 'admin.edit_tugas'
                || Route::currentRouteName() == 'karir.admin.csdm' || Route::currentRouteName() == 'admin.create_csdm' || Route::currentRouteName() == 'admin.edit_csdm'
                || Route::currentRouteName() == 'karir.admin.posisi' || Route::currentRouteName() == 'admin.create_posisi' || Route::currentRouteName() == 'admin.edit_posisi'
                || Route::currentRouteName() == 'karir.admin.nilai' || Route::currentRouteName() == 'karir.admin.tugas_kumpul' || Route::currentRouteName() == 'download_kumpulan_tugas'
                || Route::currentRouteName() == 'karir.jadwal' || Route::currentRouteName() == 'karir.nilai' 
                || Route::currentRouteName() == 'karir.admin.jadwal' 
                )
                @include('karir.layouts.navbars.no_menu')
            @elseif (Route::currentRouteName() == 'karir.login' || Route::currentRouteName() == 'karir.verifikasi')
                @include('karir.layouts.navbars.no_content')
            @else 
                @include('karir.layouts.navbars.navbar')
            @endif
        </header>

        <main>
            @yield('content')
        </main>
      
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script>
            document.querySelectorAll(".nav-link").forEach((link) => {
                if (link.href === window.location.href) {
                    link.classList.add("active");
                    link.setAttribute("aria-current", "page");
                }
            });
        </script>

    </div>
    {{-- @include('layouts.footer.footer') --}}
</body>
</html>
