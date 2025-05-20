@extends ('ortu.layouts.app')

@section('content')    
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a href="{{route('dashboard')}}" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="mx-2">Pendidikan Palestine Day </h4>
        </div>
    </div>

    <div class="container mt-0 pt-0">
        @foreach ($get_jenjang as $item)
            @if ($item->sekolah_id != 'UBRSMP' || $item->user_id == 2 || $item->user_id == 1789 || $item->user_id == 1790)
                <div class="center">
                    <a style="text-decoration: none" href="{{route('palestine.tksd')}}"> 
                        <img src="{{ asset('assets/images/palestine_day_tk_sd.png') }}" alt="pd_tk_sd" style="border-radius: 0.4rem" width="100%" >
                    </a>
                </div>
            @endif
        @endforeach

        @foreach ($get_jenjang as $item)
            @if ($item->sekolah_id == 'UBRSMP' || $item->user_id == 2 || $item->user_id == 1789 || $item->user_id == 1790)
                <div class="center">
                    <a style="text-decoration: none" href="{{route('palestine.smp')}}"> 
                        <img src="{{ asset('assets/images/palestine_day_smp.png') }}" alt="pd_smp" style="border-radius: 0.4rem" width="100%" >
                    </a>
                </div>
            @endif
        @endforeach

        <div class="center" style="display: none">
            <a style="text-decoration: none" href="{{route('palestine.merchandise')}}"> 
                <img src="{{ asset('assets/images/palestine_day_merchandise.png') }}" alt="pd_tk_sd" style="border-radius: 0.4rem" width="100%" >
            </a>
        </div>
    </div>
@endsection
