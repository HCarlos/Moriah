@if(isset($tpaginas) && $tpaginas > 1)
    <nav aria-label="Page navigation" style="margin-top: -1.5em" class="pull-right" >
        {{ $paginator->links() }}
    </nav>
@endif
