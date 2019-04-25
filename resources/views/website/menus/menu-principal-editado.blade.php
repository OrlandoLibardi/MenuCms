<!-- bootstrap model -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
 </button>
 <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
  @foreach( $items as $item )
   @if(count($item->childs) > 0)
   <!-- sub items -->
   <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
aria-haspopup="true" aria-expanded="false">
     {{  $item->title  }}
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
     @foreach($item->childs as $child)
     <!-- sub item list-->
     <a class="dropdown-item" href="{{ $child->url  }}">{{ $child->title  }}</a>
     @endforeach
    </div>
   </li>
   @else
    <li class="nav-item">
     <a class="nav-link" href="{{  $item->url  }}">{{  $item->title  }}</a>
    </li>
  @endif
  @endforeach
  </ul>
 </div>
</nav>
<!-- ./bootstrap model -->