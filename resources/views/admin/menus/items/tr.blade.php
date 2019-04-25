@php $ii = 1 @endphp
@foreach($childs as $item)
    <tr>
        <td><input type="checkbox" name="exclude" value="{{ $item->id }}"> </td>
        <td>{{ $i }}.{{$ii}}</td>
        @php 
            $temp = $i.".".$ii;
            $niveis = substr_count($temp, ".");
            $traco  = ""; 
            for($t=0; $t< $niveis; $t++) {
                $traco .= '-';
            }
        @endphp
        <td>{{$traco}} {{ $item->title }}</td>
        <td>{{ $item->url }} </td>
        <td>{{ $parent_name }}</td>
        <td width="50"><input type="text" name="order" class="orderChange form-control" value="{{ $item->order_at }}" data-id="{{ $item->id }}" readonly> </td>
        <td class="text-center">
            @include('admin.includes.btn_edit', [ 'route' => route('menu-items.edit', ['id' => $item->id]) ])
        </td>
    </tr>
@if(count($item->childs) > 0)
  @php $iii = $i . '.' .$ii; @endphp
  @include('admin.menus.items.tr', ['childs' => $item->childs, 'i' => $iii, 'parent_name' => $item->title, 'menu' => $menu])
@endif
@php $ii++ @endphp
@endforeach
