@extends ('ortu.layouts.app')

@section('content')    
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a href="{{route('dashboard')}}" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="mx-2">Edukasi Qurban</h4>
        </div>
    </div>

    <div class="container mt-0 pt-0">
        @if ($get_jenjang_tksd)
            @foreach ($get_jenjang_tksd as $item)
                <div class="center">
                    <a style="text-decoration: none" href="{{route('qurban.tksd')}}"> 
                        <img src="{{ asset('assets/images/qurban-tksd.png') }}" alt="qrb_tk_sd" style="border-radius: 0.4rem" width="100%" >
                    </a>
                </div>
            @endforeach
        @endif

        @if ($get_jenjang)
            @foreach ($get_jenjang as $item)
                <div class="center">
                    <a style="text-decoration: none" href="{{route('qurban.smp')}}"> 
                        <img src="{{ asset('assets/images/qurban-smp.png') }}" alt="qrb_smp" style="border-radius: 0.4rem" width="100%" >
                    </a>
                </div>
            @endforeach
        @endif

        @if ($id_role == 4)
            <div class="center">
                <a style="text-decoration: none" href="{{route('qurban.tksd')}}"> 
                    <img src="{{ asset('assets/images/qurban-tksd.png') }}" alt="qrb_tk_sd" style="border-radius: 0.4rem" width="100%" >
                </a>
            </div>

            <div class="center">
                <a style="text-decoration: none" href="{{route('qurban.smp')}}"> 
                    <img src="{{ asset('assets/images/qurban-smp.png') }}" alt="qrb_smp" style="border-radius: 0.4rem" width="100%" >
                </a>
            </div>
        @endif
    </div>
@endsection
