<x-app-layout>
    @if(isset($note))
        <cornell-notes :demo='false' :isAdmin='false' :note='@json($note)'/>
    @else
        <cornell-notes :demo='false' :isAdmin='false' />
    @endif

</x-app-layout>
