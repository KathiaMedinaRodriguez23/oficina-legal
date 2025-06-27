@extends('admin.layout.app')
@section('title','Role')
@push('style')

@endpush
@section('content')
   <div class="">
     @component('component.heading' , [

    'page_title' => 'Permisos',
    'action' => route('role.index') ,
    'text' => 'Atras'
     ])
    @endcomponent
      <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <form action="{{ route('permission.update',$role_id) }}"  method="post" name="product_type_attribute_form" id="product_type_attribute_form" enctype="multipart/form-data" class="m-form m-form--fit m-form--label-align-right">

                                      @csrf @method('PUT')
                <div class="x_panel">
                  <div class="x_content">

                    <table class="table">
                        <thead>
                          <tr>
                            <th width="30%">Menú</th>
                            <th width="30%">Submenú</th>

                            <th width="10%"><input class="all_view" type="checkbox">&nbsp; Ver </th>
                            <th width="10%"> <input class="all_add" type="checkbox">&nbsp; Agregar</th>
                            <th width="10%"> <input class="all_edit" type="checkbox">&nbsp; Editar</th>
                            <th width="10%"> <input class="all_delete" type="checkbox">&nbsp; Eliminar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="tr_permition">
                            <td>Dashboard</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="1" name="permission[]" {{ ($permissions_array->contains('1')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              -
                            </td>
                            <td>
                              -
                            </td>
                            <td>
                              -
                            </td>
                          </tr>
                          <tr  class="tr_permition">
                            <td>Cliente</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand "><input class="permition_view" type="checkbox" value="2" name="permission[]" {{ ($permissions_array->contains('2')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="3" name="permission[]" {{ ($permissions_array->contains('3')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="4" name="permission[]" {{ ($permissions_array->contains('4')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="5" name="permission[]" {{ ($permissions_array->contains('5')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                          <tr  class="tr_permition">
                            <td>Tarea</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="6" name="permission[]" {{ ($permissions_array->contains('6')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="7" name="permission[]" {{ ($permissions_array->contains('7')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="8" name="permission[]" {{ ($permissions_array->contains('8')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="9" name="permission[]" {{ ($permissions_array->contains('9')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td>Caso</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="14" name="permission[]" {{ ($permissions_array->contains('14')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="15" name="permission[]" {{ ($permissions_array->contains('15')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="16" name="permission[]" {{ ($permissions_array->contains('16')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                               -
                            </td>
                          </tr>
                          <tr  class="tr_permition">
                            <td>Citaciones</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="17" name="permission[]" {{ ($permissions_array->contains('17')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="18" name="permission[]" {{ ($permissions_array->contains('18')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="19" name="permission[]" {{ ($permissions_array->contains('19')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                                -
                            </td>
                          </tr>

                            <tr  class="tr_permition">
                            <td>Configuración</td>

                            <td>Tipo de Caso</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="32" name="permission[]" {{ ($permissions_array->contains('32')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="33" name="permission[]" {{ ($permissions_array->contains('33')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="34" name="permission[]" {{ ($permissions_array->contains('34')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="35" name="permission[]" {{ ($permissions_array->contains('35')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td></td>

                            <td>Tipo de Tribunal</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="36" name="permission[]" {{ ($permissions_array->contains('36')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="37" name="permission[]" {{ ($permissions_array->contains('37')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="38" name="permission[]" {{ ($permissions_array->contains('38')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="39" name="permission[]" {{ ($permissions_array->contains('39')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td></td>

                            <td>Tribunal</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="40" name="permission[]" {{ ($permissions_array->contains('40')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="41" name="permission[]" {{ ($permissions_array->contains('41')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="42" name="permission[]" {{ ($permissions_array->contains('42')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="43" name="permission[]" {{ ($permissions_array->contains('43')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td></td>

                            <td>Estado de Caso</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="44" name="permission[]" {{ ($permissions_array->contains('44')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="45" name="permission[]" {{ ($permissions_array->contains('45')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="46" name="permission[]" {{ ($permissions_array->contains('46')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="47" name="permission[]" {{ ($permissions_array->contains('47')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td></td>

                            <td>Juez</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="48" name="permission[]" {{ ($permissions_array->contains('48')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="49" name="permission[]" {{ ($permissions_array->contains('49')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="50" name="permission[]" {{ ($permissions_array->contains('50')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="51" name="permission[]" {{ ($permissions_array->contains('51')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                        </tbody>
                      </table>



                  </div>

                </div>
                   <div class="form-group pull-right">
                        <div class="col-md-12 col-sm-6 col-xs-12">
                          <a href="{{ route('role.index')  }}" class="btn btn-danger">Cancelar</a>

                          <button type="submit" class="btn btn-success"><i class="fa fa-save" id="show_loader"></i>&nbsp;Guardar</button>
                        </div>
                  </div>
                </form>
              </div>
            </div>




</div>
@endsection

@push('js')
    <script src="{{asset('assets/js/role/permition.js')}}"></script>


@endpush
