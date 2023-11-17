<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    // Function get all data patients
    public function index()
    {
        $patients = Patient::all();

        if ($patients->isEmpty()) {
            $response = ['message' => "Data pattient is empty"];

            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Data patients successfully loaded',
                'data' => $patients
            ];

            return response()->json($response, 200);
        }
    }

    // Function create data patients
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:50',
            'phone' => 'required|string',
            'address' => 'required|max:200',
            'status' => 'required|max:50',
            'in_date_at' => 'required|date',
            'out_date_at' => 'nullable|date',
        ]);

        $patient = Patient::create($validateData);

        $response = [
            'message' => 'Data patient create successfully',
            'data' => $patient,
        ];

        return response()->json($response, 201);
    }

    // Function show data patients by id
    public function show(string $id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            $response = [
                'message' => 'Show data patient successfully',
                'data' => $patient,
            ];

            return response()->json($response, 200);
        } else {
            $error = [
                'massage' => 'Data patient not found',
            ];

            return response()->json($error, 404);
        }
    }

    // Function update or edit data patients
    public function update(Request $request, string $id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            $validateData = $request->validate([
                'name' => 'required|max:50',
                'phone' => 'required|string',
                'address' => 'required|max:200',
                'status' => 'required|max:50',
                'in_date_at' => 'required|date',
                'out_date_at' => 'nullable|date',
            ]);

            $input = [
                'name' => $validateData['name'] ?? $patient->name,
                'phone' => $validateData['phone'] ?? $patient->phone,
                'address' => $validateData['address'] ?? $patient->address,
                'status' => $validateData['status'] ?? $patient->status,
                'in_date_at' => $validateData['in_date_at'] ?? $patient->in_date_at,
                'out_date_at' => $validateData['out_date_at'] ?? $patient->out_date_at,
            ];

            $patient->update($input);

            $response = [
                'message' => 'Data patient update successfully',
                'data' => $patient,
            ];
            return response()->json($response, 200);
        } else {
            $error = ['message' => 'Data patient not found'];

            return response()->json($error, 404);
        }
    }

    // Function delete data patients
    public function destroy(string $id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            $patient->delete();

            $response = ['message' => ' Data patient successfully deleted'];

            return response()->json($response, 200);
        } else {
            $error = ['message' => 'Data not found, Deleted patient failed!!'];

            return response()->json($error, 404);
        }
    }

    // Function search data patients by name
    public function search(string $name)
    {
        $patients = Patient::where('name', 'like', '%' . $name . '%')->get();

        if ($patients->count()) {
            $response = [
                'message' => 'Get search patients name successfully',
                'data' => $patients,
            ];
            return response()->json($response, 200);
        } else {
            $error = ['message' => 'No patient found with the provided name'];

            return response()->json($error, 404);
        }
    }

    // Function get patients with positive status
    public function positive()
    {
        $getPositive = Patient::where('status', 'positive')->get();
        $totalPositive = $getPositive->count();

        if ($totalPositive == 0) {
            $response = [
                'message' => 'Patients with positive status has empty!',
                'total' => $totalPositive,
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Get patients with positive status succesfully',
                'total' => $totalPositive,
                'data' => $getPositive,
            ];

            return response()->json($response, 200);
        }
    }

    // Function get patients with recovered status
    public function recovered()
    {
        $getRecovered = Patient::where('status', 'recovered')->get();
        $totalRecovered = $getRecovered->count();

        if ($totalRecovered == 0) {
            $response = [
                'message' => 'Patients with recovered status has empty!',
                'total' => $totalRecovered,
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Get patients with recovered status successfully',
                'total' => $totalRecovered,
                'data' => $getRecovered,
            ];

            return response()->json($response, 200);
        }
    }

    // Function get patients with dead status
    public function dead()
    {
        $getDead = Patient::where('status', 'dead')->get();
        $totalDead = $getDead->count();

        if ($totalDead == 0) {
            $response = [
                'message' => 'Patients with dead status has empty!',
                'total' => $totalDead,
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Get patients with dead status succesfully',
                'total' => $totalDead,
                'data' => $getDead,
            ];

            return response()->json($response, 200);
        }
    }
}
