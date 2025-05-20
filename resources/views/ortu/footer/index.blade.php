<div  class="menu-bottom">
  <div class="row" style="justify-content: center;">
    @foreach($menubar as $item)
      <a href="{{$item->url}}" class="col text-center menu-link">
        <i class="{{$item->icon}}"></i>
        <br />
        <span style="font-size: 10px;"> {{$item->name}}</span>
      </a>
    @endforeach
  </div>
</div>