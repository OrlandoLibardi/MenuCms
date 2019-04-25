@php $ii = 1 @endphp
@foreach($childs as $item)
@php $activeOption = ($item->parent_id==$selected) ? "selected" : ""; @endphp   
<option value="{{ $item->id }}" {{$activeOption}}>{{ $i }}.{{$ii}} {{ $item->title }}</option>

@if(count($item->childs) > 0)
  @php $iii = $i . '.' .$ii; @endphp
  @include('admin.menus.items.option', ['childs' => $item->childs, 'i' => $iii, 'selected' => $selected])
@endif
@php $ii++ @endphp
@endforeach
