<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAppointment;
use App\Http\Controllers\Controller;
use App\Model\AdvocateClient;
use App\Model\Appointment;
use Session;
use DB;
use App\Helpers\LogActivity;
use App\Notifications\ActivityNotification;
use Illuminate\Support\Facades\Notification;
use App\Admin;
use App\Traits\DatatablTrait;

class AppointmentController extends Controller
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
        if (!$user->can('appointment_list')) {
            abort(403, 'Unauthorized action.');
        }


        return view('admin.appointment.appointment');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::guard('admin')->user();
        if (!$user->can('appointment_add')) {
            abort(403, 'Unauthorized action.');
        }


        $data['client_list'] = AdvocateClient::where('is_active', 'Yes')->get();


        return view('admin.appointment.appointment_create', $data);
    }


    public function getMobileno(Request $request)
    {

        $data = AdvocateClient::findorfail($request->id);
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAppointment $request)
    {
        $appointmentDate = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->date)));
        if (Appointment::where('mobile', $request->email)
            ->whereDate('date', $appointmentDate)
            ->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Ya existe una cita programada para esta fecha.']);
        }

        $appoint = new Appointment();
        if ($request->type == "new") {
            $appoint->name = $request->new_client;

        } else {
            $appoint->client_id = $request->exists_client;
        }
        $appoint->mobile = $request->email;
        $appoint->date = date('Y-m-d H:i:s', strtotime(LogActivity::commonDateFromat($request->date)));

        $appoint->time = date('H:i:s', strtotime($request->time));
        $appoint->note = $request->note;
        $appoint->type = $request->type;
        $appoint->related = $request->related;
        $appoint->case_id = $request->related_id;
        $appoint->advocate_id = 1;

        $appoint->save();

        try {
            $client = new Client();
            $response = $client->post(env('MS_CITATION').'/send-citation-email', [
                'json' => [
                    'email' => $request->email,
                    'fecha' => date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->date))),
                    'hora' => date('H:i', strtotime($request->time)),
                    'idCaso' => $request->related_id
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            if($response->getStatusCode() != 200) {
                return redirect()->back()
                    ->with('error', 'Error al enviar el enlace de restablecimiento de contraseña: ' . $body['message']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al agregar la cita: ' . $e->getMessage());
        }

        return redirect()->route('appointment.index')->with('success', "Cita agregada exitosamente.");
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
    }


    public function appointmentList(Request $request)
    {


        $user = \Auth::guard('admin')->user();
        $isEdit = $user->can('appointment_edit');

        /*
          |----------------
          | Listing colomns
          |----------------
         */
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'date',
            3 => 'time',
            4 => 'mobile',
            5 => 'is_active',
            6 => 'action',
        );


        $totalData = DB::table('appointments AS a')
            ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'a.client_id')
            ->select('a.id AS id', 'a.is_active AS status', 'a.mobile AS mobile', 'a.date AS date', 'a.name AS name', 'a.name AS appointment_name', 'ac.first_name AS first_name', 'ac.last_name AS last_name', 'a.client_id AS client_id', 'a.type As type')
            ->count();
        $totalRec = $totalData;
        // $totalData = DB::table('appointments')->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        // $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $terms = DB::table('appointments AS a')
            ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'a.client_id')
            ->select('a.id AS id', 'a.is_active AS status', 'a.mobile AS mobile', 'a.date AS date', 'a.name AS name', 'a.name AS appointment_name', 'ac.first_name AS first_name', 'ac.last_name AS last_name', 'a.client_id AS client_id', 'a.type As type', 'a.time AS time')
            ->when($request->input('appoint_date_from'), function ($query, $iterm) {
                $iterm = LogActivity::commonDateFromat($iterm);
                return $query->whereDate('a.date', '>=', date('Y-m-d', strtotime($iterm)));
            })
            ->when($request->input('appoint_date_to'), function ($query, $iterm) {
                $iterm = LogActivity::commonDateFromat($iterm);
                return $query->whereDate('a.date', '<=', date('Y-m-d', strtotime($iterm)));
            })
            ->where(function ($query) use ($search) {
                return $query->where('a.mobile', 'LIKE', "%{$search}%")
                    ->orWhere('a.name', 'LIKE', "%{$search}%")
                    ->orWhere('ac.first_name', 'LIKE', "%{$search}%")
                    ->orWhere('ac.last_name', 'LIKE', "%{$search}%")
                    ->orWhere('a.is_active', 'LIKE', "%{$search}%")
                    ->orWhereRaw("concat(ac.first_name, ' ', ac.last_name) like '%{$search}%' ");

            })
            ->offset($start)
            ->limit($limit)
            // ->orderBy($order, $dir)
            ->get();


        /*
          |--------------------------------------------
          | For table search filter from frontend site inside two table namely courses and courseterms.
          |--------------------------------------------
         */

        /*
          |----------------------------------------------------------------------------------------------------------------------------------
          | Creating json array with all records based on input from front end site like all,searcheded,pagination record (i.e 10,20,50,100).
          |----------------------------------------------------------------------------------------------------------------------------------
         */

        $totalFiltered = $terms->count();

        $data = array();
        if (!empty($terms)) {

            foreach ($terms as $term) {

                /**
                 * For HTMl action option like edit and delete
                 */
                $edit = route('appointment.edit', $term->id);
                $token = csrf_field();

                // $action_delete = '"'.route('sale-Admin.destroy', $cat->id).'"';
                $action_delete = route('appointment.destroy', $term->id);

                $delete = "<form action='{$action_delete}' method='post' onsubmit ='return  confirmDelete()'>
                {$token}
                            <input name='_method' type='hidden' value='DELETE'>
                            <button class='dropdown-item text-center' type='submit'  style='background: transparent;
    border: none;'>DELETE</button>
                          </form>";

                /**
                 * -/End
                 */


                $con = '<select name="status" class="appointment-select2" id="status" onchange="change_status(' . "'" . $term->id . "'" . ',' . 'getval(this)' . ',' . "'" . 'appointments' . "'" . ')">';


                //for open status
                $con .= "<option value='OPEN'";
                if ($term->status == 'OPEN') {
                    $con .= "selected";
                }
                $con .= ">ABIERTO</option>";

                //for CANCEL BY CLIENT status

                $con .= "<option value='CANCEL BY CLIENT'";
                if ($term->status == 'CANCEL BY CLIENT') {
                    $con .= "selected";
                }
                $con .= ">Cancelado por el Cliente</option>";


                //for CANCEL BY ADVOCATE status
                $con .= "<option value='CANCEL BY ADVOCATE'";
                if ($term->status == 'CANCEL BY ADVOCATE') {
                    $con .= "selected";
                }
                $con .= ">Cancelado por el defensor</option>";


                $con .= "</select>";


                if ($isEdit == "1") {
                    $nestedData['is_active'] = $con;
                } else {
                    $nestedData['is_active'] = "";
                }

                if (empty($request->input('search.value'))) {
                    $final = $totalRec - $start;
                    $nestedData['id'] = $final;
                    $totalRec--;
                } else {
                    $start++;
                    $nestedData['id'] = $start;
                }
                $nestedData['date'] = date(LogActivity::commonDateFromatType(), strtotime($term->date));
                $nestedData['time'] = date('g:i a', strtotime($term->time));


                $nestedData['mobile'] = $term->mobile;
                if ($term->type == "new") {
                    $nestedData['name'] = $term->appointment_name;
                } else {
                    $nestedData['name'] = $term->first_name . ' ' . $term->last_name;
                }


                if ($isEdit == "1") {
                    $nestedData['action'] = $this->action([
                        'edit' => route('appointment.edit', $term->id),
                        'edit_permission' => $isEdit,

                    ]);
                } else {
                    $nestedData['action'] = [];
                }

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
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
        if (!$user->can('appointment_edit')) {
            abort(403, 'Unauthorized action.');
        }
        // $advocate_id = $this->getLoginUserId();
        $data['client_list'] = AdvocateClient::where('is_active', 'Yes')->get();
        $data['appointment'] = Appointment::find($id);
        $data['cases'] = DB::table('court_cases AS case')
            ->leftJoin('advocate_clients AS ac', 'ac.id', '=', 'case.advo_client_id')
            ->leftJoin('case_types AS ct', 'ct.id', '=', 'case.case_types')
            ->leftJoin('case_types AS cst', 'cst.id', '=', 'case.case_sub_type')
            ->leftJoin('case_statuses AS s', 's.id', '=', 'case.case_status')
            ->leftJoin('court_types AS t', 't.id', '=', 'case.court_type')
            ->leftJoin('courts AS c', 'c.id', '=', 'case.court')
            ->leftJoin('judges AS j', 'j.id', '=', 'case.judge_type')
            ->select(
                'case.id AS id',
                'case.registration_number AS case_number',
                'case.act',
                'case.priority',
                'case.court_no',
                's.case_status_name',
                'ac.first_name',
                'ac.middle_name',
                'ac.last_name',
                'case.updated_by',
                'ac.id AS advo_client_id',
                'case.is_nb',
                'case.is_active'
            )
            ->where('case.is_active','Yes')
            ->where('case.id', $data['appointment']->case_id)
            ->get();
        return view('admin.appointment.appointment_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreAppointment $request, $id)
    {
        $appointmentDate = date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->date)));
        if (Appointment::where('mobile', $request->email)
            ->whereDate('date', $appointmentDate)
            ->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Ya existe una cita programada para esta fecha.']);
        }

        $appoint = Appointment::find($id);

        if ($request->type == "new") {
            $appoint->name = $request->new_client;

        } else {
            $appoint->client_id = $request->exists_client;

        }
        $appoint->mobile = $request->email;
        $currentDate = Carbon::parse($appoint->date);
        $newDate = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime(LogActivity::commonDateFromat($request->date))));
        if ($newDate->greaterThan($currentDate)) {
            try {
                $client = new Client();
                $response = $client->post(env('MS_CITATION').'/send-reprogramacion-de-cita-email', [
                    'json' => [
                        'email' => $request->email,
                        'fecha' => date('Y-m-d', strtotime(LogActivity::commonDateFromat($request->date))),
                        'hora' => date('H:i', strtotime($request->time)),
                        'idCaso' => $request->related_id
                    ],
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                ]);

                $body = json_decode($response->getBody()->getContents(), true);
                if($response->getStatusCode() != 200) {
                    return redirect()->back()
                        ->with('error', 'Error al enviar el enlace de restablecimiento de contraseña: ' . $body['message']);
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error al agregar la cita: ' . $e->getMessage());
            }
        }
        $appoint->date = date('Y-m-d H:i', strtotime(LogActivity::commonDateFromat($request->date)));
        $appoint->time = date('H:i:s', strtotime($request->time));
        $appoint->note = $request->note;
        $appoint->type = $request->type;
        $appoint->related = $request->related;
        $appoint->case_id = $request->related_id;

        $appoint->save();


        return redirect()->route('appointment.index')->with('success', "Cita actualizada exitosamente.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
