<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekolah Rabbani | QLP</title>
    <link href="{{ asset('assets/images/logo-yayasan_1.png') }}" rel="icon" type="image/jpg">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/app.css?v=').time() }}"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"  />
      
    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css')}}">
    
    <!-- Aos Animation Css -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/aos/dist/aos.css')}}"> --}}
    
    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=4.0.0')}}">
    
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=4.0.0')}}">
    
    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark.min.css')}}">
    
    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css')}}">
</head>

<body>
  
    @if ( Route::currentRouteName() == 'login' )
        @include('layouts.navbars.no_content')
    @else 
        @include('layouts.navbars.sidebar')
    @endif
    
        <main class="main-content">
            @yield('content')
        </main>
      
       <!-- Library Bundle Script -->
        <script src="{{ asset('assets/js/core/libs.min.js')}}"></script>
        
        <!-- External Library Bundle Script -->
        <script src="{{ asset('assets/js/core/external.min.js')}}"></script>
        
        <!-- fslightbox Script -->
        <script src="{{ asset('assets/js/plugins/fslightbox.js')}}"></script>
        
        <!-- Settings Script -->
        <script src="{{ asset('assets/js/plugins/setting.js')}}"></script>
        
        <!-- Slider-tab Script -->
        <script src="{{ asset('assets/js/plugins/slider-tabs.js')}}"></script>
        
        <!-- Form Wizard Script -->
        <script src="{{ asset('assets/js/plugins/form-wizard.js')}}"></script>
        
        <!-- AOS Animation Plugin-->
        {{-- <script src="{{ asset('assets/vendor/aos/dist/aos.js')}}"></script> --}}
        
        <!-- App Script -->
        <script src="{{ asset('assets/js/hope-ui.js')}}" defer ></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script>
            document.querySelectorAll(".nav-link").forEach((link) => {
                if (link.href === window.location.href) {
                    link.classList.add("active");
                    link.setAttribute("aria-current", "page");
                }
            });
        </script>
       
</body>
</html>
