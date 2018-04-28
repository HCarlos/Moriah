@if(isset($tpaginas) && $tpaginas > 1)
    <nav aria-label="Page navigation" style="border-bottom: 1px solid coral;  padding: 0em !important; margin-bottom: 0.5em !important; ">
        {{ $paginator->links() }}
    </nav>
@endif
