<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClient;
use App\Http\Controllers\Controller;
use App\Model\AdvocateClient;
use App\Model\CourtCase;
use App\Model\ClientPartiesInvoive;
use App\Traits\DatatablTrait;
use App\Model\Country;
use App\Model\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;

class ClientController extends Controller
{
    use DatatablTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::guard('admin')->user();
        if (!$user->can('client_list')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.client.client');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::guard('admin')->user();
        if (!$user->can('client_add')) {
            abort(403, 'Unauthorized action.');
        }

        $this->data['country'] = Country::all();
        $this->data['state'] = State::all();
        $this->data['city'] = State::all();
        return view('admin.client.client_create', $this->data);
    }

    public function ClientList(Request $request)
    {
        $user = \Auth::guard('admin')->user();
        $isEdit = $user->can('client_edit');
        $isDelete = $user->can('client_delete');

        $columns = array(
            0 => 'id',
            1 => 'first_name',
            2 => 'dni_ruc',
            3 => 'mobile',
            4 => 'case',
            5 => 'is_active',
            6 => 'action',
        );

        $totalData = AdvocateClient::count(); // datata table count

        $totalRec = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
//        $order = $columns[$request->input('order.0.column')];
//        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        $customcollections = AdvocateClient::when($search, function ($query, $search) {
            return $query->where('first_name', 'LIKE', "%{$search}%");
        });

        $totalFiltered = $customcollections->count();
        $customcollections = $customcollections->offset($start)->limit($limit)->get();
        $data = [];
        foreach ($customcollections as $key => $item) {

            $show = route('clients.show', $item->id);
            $case_list = url('admin/case-list/' . $item->id);

            if (empty($request->input('search.value'))) {
                $final = $totalRec - $start;
                $row['id'] = $final;
                $totalRec--;
            } else {
                $start++;
                $row['id'] = $start;
            }

            $row['first_name'] = '<a class="title text-primary" href="' . $show . '">' . $item->full_name . '</a>';
            $row['document_number'] = $item->dni_ruc;
            $row['mobile'] = $item->mobile;
            $row['case'] = "<a class='title text-primary' href='{$case_list}'>" . $this->getClientCasesTotal($item->id) . "</a>";

            if ($isEdit == "1") {
                $row['is_active'] = $this->status($item->is_active, $item->id, route('clients.status'));
            } else {
                $row['is_active'] = [];
            }
            $row['action'] = $this->action([
                'view' => route('clients.show', $item->id),
                'edit' => route('clients.edit', $item->id),
                'edit_permission' => $isEdit,
                'delete' => collect([
                    'id' => $item->id,
                    'action' => route('clients.destroy', $item->id),
                ]),
                'delete_permission' => $isDelete,

            ]);

            $data[] = $row;

        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        return response()->json($json_data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreClient $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:advocate_clients,email',
            'mobile' => 'required|unique:advocate_clients,mobile',
            'document_number' => 'required|unique:advocate_clients,dni_ruc',
            'document_type' => 'required',
        ], [
            'email.required' => 'Ingrese el correo electrónico.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'email.unique' => 'El correo electrónico ya ha sido registrado.',
            'mobile.required' => 'Ingrese el número de teléfono móvil.',
            'mobile.unique' => 'El número de teléfono móvil ya ha sido registrado.',
            'document_number.required' => 'Ingrese el número de documento.',
            'document_number.unique' => 'El número de documento ya ha sido registrado.',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $AdvocateClient = new AdvocateClient;
        $AdvocateClient->first_name = $request->f_name;
        $AdvocateClient->middle_name = $request->m_name ?? null;
        $AdvocateClient->last_name = $request->l_name;
        $AdvocateClient->gender = $request->gender;
        $AdvocateClient->email = $request->email;
        $AdvocateClient->mobile = $request->mobile;
        $AdvocateClient->document_type = $request->document_type;
        $AdvocateClient->dni_ruc = $request->document_number;
        $AdvocateClient->address = $request->address;
        $AdvocateClient->country_id = $request->country;
        $AdvocateClient->state_id = $request->state;
        $AdvocateClient->city_id = $request->city_id;
        $AdvocateClient->client_type = $request->type;
        $AdvocateClient->reference_name = $request->reference_name;
        $AdvocateClient->reference_mobile = $request->reference_mobile;
        $AdvocateClient->save();
        $clientId = $AdvocateClient->id;


        if ($request->type == "single") {
            if (isset($request['group-a']) && count($request['group-a']) > 0) {
                foreach ($request['group-a'] as $key => $value) {
                    if (!empty($value['firstname']) && !empty($value['middlename']) && !empty($value['lastname']) && !empty($value['mobile_client']) && !empty($value['address_client'])) {
                        $ClientPartiesInvoive = new ClientPartiesInvoive();
                        $ClientPartiesInvoive->client_id = $clientId;
                        $ClientPartiesInvoive->party_firstname = $value['firstname'];
                       // $ClientPartiesInvoive->party_middlename = $value['middlename'];
                        $ClientPartiesInvoive->party_lastname = $value['lastname'];
                        $ClientPartiesInvoive->party_mobile = $value['mobile_client'];
                        $ClientPartiesInvoive->party_address = $value['address_client'];
                        $ClientPartiesInvoive->save();
                    }
                }
            }
        } else if ($request->type == "multiple") {
            if (isset($request['group-b']) && count($request['group-b']) > 0) {
                foreach ($request['group-b'] as $key => $value) {
                    if (!empty($value['firstname']) && !empty($value['middlename']) && !empty($value['lastname']) && !empty($value['mobile_client']) && !empty($value['address_client']) && !empty($value['advocate_name'])) {
                        $ClientPartiesInvoive = new ClientPartiesInvoive();
                        $ClientPartiesInvoive->client_id = $clientId;
                        $ClientPartiesInvoive->party_firstname = $value['firstname'];
                       // $ClientPartiesInvoive->party_middlename = $value['middlename'];
                        $ClientPartiesInvoive->party_lastname = $value['lastname'];
                        $ClientPartiesInvoive->party_mobile = $value['mobile_client'];
                        $ClientPartiesInvoive->party_address = $value['address_client'];
                        $ClientPartiesInvoive->party_advocate = $value['advocate_name'];
                        $ClientPartiesInvoive->save();
                    }
                }

            }
        }
        return redirect()->route('clients.index')->with('success', "Cliente añadido exitosamente.");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data['single'] = array();
        $data['multiple'] = array();
        $data['client'] = AdvocateClient::find($id);
        $data['single'] = ClientPartiesInvoive::where('client_id', $id)->get();
        $clientName = AdvocateClient::findorfail($id);
        $data['name'] = trim($clientName->first_name . ' ' . ($clientName->middle_name ?? '') . ' ' . $clientName->last_name);
        return view('admin.client.view.client_detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \Auth::guard('admin')->user();
        if (!$user->can('client_edit')) {
            abort(403, 'Unauthorized action.');
        }

        $data['client'] = AdvocateClient::with('country', 'state', 'city')->find($id);
        $data['country'] = DB::table('countries')->where('id', 101)->first();
        $data['states'] = DB::table('states')->where('country_id', $data['client']->country_id)->get();
        $data['citys'] = DB::table('cities')->where('state_id', $data['client']->state_id)->get();

        $data['client_parties_invoive'] = ClientPartiesInvoive::where('client_id', $id)->get();
        return view('admin.client.client_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreClient $request, $id)
    {
        DB::table('client_parties_invoives')->where('client_id', $id)->delete();
        $AdvocateClient = AdvocateClient::find($id);
        $AdvocateClient->first_name = $request->f_name;
        $AdvocateClient->middle_name = $request->m_name ?? null;
        $AdvocateClient->last_name = $request->l_name;
        $AdvocateClient->gender = $request->gender;
        $AdvocateClient->email = $request->email;
        $AdvocateClient->mobile = $request->mobile;
        $AdvocateClient->dni_ruc = $request->document_number;
        $AdvocateClient->document_type = $request->document_type;
        $AdvocateClient->address = $request->address;
        $AdvocateClient->country_id = $request->country;
        $AdvocateClient->state_id = $request->state;
        $AdvocateClient->city_id = $request->city_id;
        $AdvocateClient->client_type = $request->type;
        $AdvocateClient->reference_name = $request->reference_name;
        $AdvocateClient->reference_mobile = $request->reference_mobile;
        $AdvocateClient->save();

        $clientId = $id;
        if ($request->change_court_chk == "Yes") {
            if ($request->type == "single") {
                if (isset($request['group-a']) && count($request['group-a']) > 0) {
                    foreach ($request['group-a'] as $key => $value) {
                        $ClientPartiesInvoive = new ClientPartiesInvoive();
                        $ClientPartiesInvoive->client_id = $clientId;
                        $ClientPartiesInvoive->party_firstname = $value['firstname'];
                      //  $ClientPartiesInvoive->party_middlename = $value['middlename'];
                        $ClientPartiesInvoive->party_lastname = $value['lastname'];
                        $ClientPartiesInvoive->party_mobile = $value['mobile_client'];
                        $ClientPartiesInvoive->party_address = $value['address_client'];
                        $ClientPartiesInvoive->save();
                    }
                }

            } else if ($request->type == "multiple") {

                if (isset($request['group-b']) && count($request['group-b']) > 0) {
                    foreach ($request['group-b'] as $key => $value) {
                        $ClientPartiesInvoive = new ClientPartiesInvoive();
                        $ClientPartiesInvoive->client_id = $clientId;
                        $ClientPartiesInvoive->party_firstname = $value['firstname'];
                      //  $ClientPartiesInvoive->party_middlename = $value['middlename'];
                        $ClientPartiesInvoive->party_lastname = $value['lastname'];
                        $ClientPartiesInvoive->party_mobile = $value['mobile_client'];
                        $ClientPartiesInvoive->party_address = $value['address_client'];
                        $ClientPartiesInvoive->party_advocate = $value['advocate_name'];
                        $ClientPartiesInvoive->save();
                    }
                }

            }

        }
        return redirect()->route('clients.index')->with('success', "Cliente actualizado con éxito!.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointments = DB::table('appointments')->where('client_id', $id)->count();
        $cases = DB::table('court_cases')->where('advo_client_id', $id)->count();
        if ($appointments > 0 || $cases > 0) {
            Session::flash('error', "Client was used in other module so you can't delete.");
        }
        $AdvocateClient = AdvocateClient::find($id);
        $AdvocateClient->delete();

        ClientPartiesInvoive::where('client_id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado con éxito.',
        ], 200);
    }

    public function changeStatus(Request $request)
    {
        $statuscode = 400;
        $client = AdvocateClient::findOrFail($request->id);
        $client->is_active = $request->status == 'true' ? 'Yes' : 'No';

        if ($client->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'true' ? 'activado' : 'desactivado';
        $message = 'Estado ' . $status . ' con exito.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);

    }

    public function check_client_email_exits(Request $request)
    {
        if ($request->id == "") {
            $count = AdvocateClient::where('email', $request->email)->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            $count = AdvocateClient::where('email', '=', $request->email)
                ->where('id', '<>', $request->id)
                ->count();
            if ($count == 0) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }

    public function caseDetail($id)
    {
        $user = \Auth::guard('admin')->user();
        if (!$user->can('case_list')) {
            abort(403, 'Acción no autorizada.');
        }
        $totalCourtCase = CourtCase::where('advo_client_id', $id)->count();
        $clientName = AdvocateClient::findorfail($id);
        $name = $clientName->first_name . ' ' . $clientName->middle_name . ' ' . $clientName->last_name;
        $client = AdvocateClient::find($id);


        return view('admin.client.view.cases_view', ['advo_client_id' => $id, 'name' => $name, 'totalCourtCase' => $totalCourtCase, 'client' => $client]);
    }


    public function accountDetail($id)
    {
//        dd(1);
        $user = \Auth::guard('admin')->user();
        if (!$user->can('invoice_list')) {
            abort(403, 'Acción no autorizada.');
        }
        $clientName = AdvocateClient::findorfail($id);
        $name = $clientName->first_name . ' ' . $clientName->middle_name . ' ' . $clientName->last_name;
        $client = AdvocateClient::find($id);
        return view('admin.client.view.client_account', ['advo_client_id' => $id, 'name' => $name, 'client' => $client]);
    }

}
