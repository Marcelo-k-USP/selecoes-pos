<div class="row">
  <div class="col-md-12 form-inline">
    <span class="h4 mt-2">Orientadores</span>
    @can('orientadores.create')
      &nbsp; &nbsp;
      <button type="button" class="btn btn-sm btn-success" onclick="add_form()">
        <i class="fas fa-plus"></i> Novo
      </button>
      @endcan
  </div>
</div>

<table class="table table-sm my-0 ml-3">
  @foreach ($orientadores as $orientador)
    {{-- Mostra os dados de um orientador --}}
    <tr>
      <td>
        <div>
          <a name="{{ \Str::lower($orientador->id) }}" class="font-weight-bold" style="text-decoration: none;">{{ $orientador->nome }}</a>
          @if ($orientador->externo)
            @can('orientadores.update')
              @include('orientadores.partials.btn-edit')
            @endcan
          @endif
          @can('orientadores.delete')
            @include('orientadores.partials.btn-delete')
          @endcan
        </div>
      </td>
    </tr>
  @endforeach
</table>
