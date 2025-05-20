@extends ('ortu.layouts.app')

@section('content')    
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a href="{{route('palestine.index')}}" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="mx-2"> Materi Palestine Day TK SD </h4>
        </div>
    </div>

    @if ($materi->count() > 0)
        <div class="d-grid-card">
            @foreach ($materi as $item)
                <a href="{{route('materi-by-id', $item->id)}}" style="text-decoration: none">
                    <div class="card catalog mb-1">
                        @if ($item->image == null || $item->image == "")
                            <img src="{{ asset('assets/images/img-palestine-1.png') }}" class="card-img-top" alt="palestine" style="max-height: 180px">
                        @else
                            <img src="{{ asset('storage/'.$item->image) }}" class="card-img-top" alt="palestine" style="max-height: 180px">
                        @endif
                        <div class="card-body pt-1">
                            <h6 class="card-title" style="color: #{{$item->style}}">{{$item->judul}}</h6>
                            <p class="mb-1" style="font-size: 10px; color: grey"><i>Ditulis oleh : {{$item->created_by}} </i> </p>
                            <p class="mb-1" style="font-size: 9px">Terbit : {{date('d-m-Y', strtotime($item->created_at))}} </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="center mt-5">
            <h3 class="text-danger"> Kami lagi menyiapkan materinya, Mohon Menunggu yaa.. </h3>
        </div>
    @endif
@endsection
