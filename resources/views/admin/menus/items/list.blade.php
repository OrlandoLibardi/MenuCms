<div class="col-md-8">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <h5>Items Cadastradas</h5>
              <div class="ibox-tools">
                  <a class="collapse-link"> <i class="fa fa-chevron-up"></i>  </a>
              </div>
          </div>
          <div class="ibox-content">
              <div class="row">
                  <div class="col-md-12">
                      <table class="table table-bordered table-striped" id="results">
                          <thead>
                              <tr>
                                  <td width="10"><input type="checkbox" name="excludeAll"></td>
                                  <td width="80"></td>
                                  <td width="200">Título</td>
                                  <td>Url</td>
                                  <td width="200">Item Parente</td>
                                  <td width="50">Ordem</td>
                                  <td width="50">Editar</td>
                              </tr>
                          </thead>
                          <tbody>
                              @php $i = 1 @endphp
                              @forelse($items as $item)
                                  <tr>
                                      <td><input type="checkbox" name="exclude" value="{{ $item->id }}"> </td>
                                      <td>{{ $i }}</td>
                                      <td>{{ $item->title }}</td>
                                      <td>{{ $item->url }}</td>
                                      <td> -- </td>
                                      <td width="50"><input type="text" name="order" class="orderChange form-control" value="{{ $item->order_at }}" data-id="{{ $item->id }}" readonly> </td>
                                      <td class="text-center">
                                          @include('admin.includes.btn_edit', [ 'route' => route('menu-items.edit', ['id' => $item->id]) ])
                                      </td>
                                  </tr>
                                  @if(count($item->childs) > 0)
                                    @include('admin.menus.items.tr', ['childs' => $item->childs, 'i' => $i, 'parent_name' => $item->title, 'menu' => $menu])
                                  @endif
                                  @php $i++ @endphp
                              @empty
                              <tr>
                                  <td colspan="8" class="text-info text-center">
                                      <br /><br /><h3> Nenhum resultado encontrado! </h3><br />
                                  </td>
                              </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
