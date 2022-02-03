@foreach ($bankBalance as $item)
    @if($item->total >= 500)
    <span style="color: green; font-weight: bold;">
    Selected Account Balance is {{number_format($item->total,2)}} Tk
    </span>
    @else
    <span style="color: red; font-weight: bold;">
    Selected Account Balance is {{number_format($item->total,2)}} Tk
    </span>
    @endif
@endforeach