@extends('admin.layout.app')
@section('title','Vendor Edit')
@section('content')
    @component('component.heading' , [
        'page_title' => 'Edit Vendor',
        'action' => route('vendor.index') ,
        'text' => 'Atras'
         ])
    @endcomponent

    <div class="row">
        <form id="add_vendor" name="add_vendor" role="form" method="POST"
              action="{{route('vendor.update',$client->id)}}" enctype="multipart/form-data">
            <input type="hidden" id="id" value="{{ $client->id ?? ''}}" name="id">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">

            <div class="col-md-12 col-sm-12 col-xs-12">
                @include('component.error')
                <div class="x_panel">

                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="company_name">Company Name <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" name="company_name"
                                       id="company_name" value="{{ $client->company_name ?? '' }}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="f_name">First Name <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" id="f_name" name="f_name"
                                       value="{{ $client->first_name ?? ''}}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="l_name">Last Name <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" id="l_name" name="l_name"
                                       value="{{ $client->last_name ?? ''}}">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="email">Email ID <span class="text-danger"></span></label>
                                <input type="email" placeholder="" class="form-control" id="email" name="email"
                                       value="{{ $client->email ?? ''}}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="mobile">Mobile No. <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="mobile" name="mobile"
                                       data-rule-required="true" data-rule-number="true"
                                       data-msg-required="Mobile no is required" data-rule-maxlength="10"
                                       value="{{ $client->mobile ?? ''}}" maxlength="10">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="alternate_no">Alternate No<span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" id="alternate_no"
                                       name="alternate_no" value="{{ $client->alternate_no ?? ''}}">
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="address">Address <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="address" name="address"
                                       data-rule-required="true" data-msg-required="Adress is required "
                                       value="{{ $client->address ?? ''}}">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="country">Country <span class="text-danger">*</span></label>
                                <select class="form-control select-change country-select2" data-rule-required="true"
                                        data-msg-required=" Please select country selct2-width-100"  name="country"
                                        id="country"
                                        data-url="{{ route('get.country') }}"
                                        data-clear="#city_id,#state"
                                >
                                    <option value=""> Select Country</option>
                                    @if($client->country)
                                        <option value="{{ $client->country->id }}"
                                                selected=""> {{ $client->country->name  }} </option>

                                    @endif

                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="state">State <span class="text-danger">*</span></label>
                                <select id="state" name="state"

                                        data-url="{{ route('get.state') }}"
                                        data-target="#country"
                                        data-clear="#city_id"
                                        class="form-control state-select2 select-change" data-rule-required="true"
                                        data-msg-required=" Please select state">
                                    <option value=""> Select State</option>
                                    @if($client->state)
                                        <option value="{{ $client->state->id }}"
                                                selected=""> {{ $client->state->name  }} </option>

                                    @endif


                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="city">City <span class="text-danger">*</span></label>
                                <select id="city_id" name="city_id"
                                        data-url="{{ route('get.city') }}"
                                        data-target="#state"
                                        class="form-control city-select2" data-rule-required="true"
                                        data-msg-required=" Please select city">
                                    <option value=""> Select City</option>
                                    @if($client->city)
                                        <option value="{{ $client->city->id }}"
                                                selected=""> {{ $client->city->name  }} </option>

                                    @endif

                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="gst">GSTIN </label>
                                <input type="text" placeholder="" class="form-control" id="gst" name="gst"
                                       value="{{ $client->gst ?? ''}}">
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="pan">PAN</label>
                                <input type="text" placeholder="" class="form-control" id="pan" name="pan"
                                       value="{{ $client->pan ?? ''}}">
                            </div>


                            <div class="form-group pull-right">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <br>
                                    <a href="{{ route('vendor.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"
                                                                                     id="show_loader"></i>&nbsp;Save
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{asset('assets/admin/vendor/vendor.js') }}"></script>
@endpush
