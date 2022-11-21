<x-app-layout>
    @if(isset($note))
        <cornell-notes :demo='true' :isAdmin='false' :note='@json($note)'/>
    @else
        <cornell-notes :demo='true' :isAdmin='false' />
    @endif

</x-app-layout>
