<x-app-layout>
    @if(isset($note))
        <cornell-notes :demo='false' :admin='true' :note='@json($note)'/>
    @else
        <cornell-notes :demo='false' :admin='true'/>
    @endif

</x-app-layout>
