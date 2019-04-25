<ul>
  @foreach( $items as $item )
   <li>
     <a href="{{  $item->url  }}" title="{{  $item->title  }}" target="{{  $item->target  }}" class="link">
      {{  $item->title  }}
     </a>
   </li>
  @endforeach
</ul>