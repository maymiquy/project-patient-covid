<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();

        if ($patients->isEmpty()) {
            $response = ['data' => $patients];

            return response()->json($response, 204);
        } else {
            $response = [
                'message' => 'Data patients successfully loaded',
                'data' => $patients
            ];

            return response()->json($response, 200);
        }
    }


    public function store(Request $request)
    { {
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
    }

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

    public function destroy(string $id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            $patient->delete();

            $response = ['message' => ' Data patient successfully deleted'];

            return response()->json($response, 204);
        } else {
            $error = ['message' => 'Data not found, Deleted patient failed!!'];

            return response()->json($error, 404);
        }
    }
}
