<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PatientRequest;
use App\Http\Resources\v1\PatientResource;
use App\Models\Patient;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $patients = Patient::query();

        if ($request->has('name')) {
            $patients->where('name', 'ilike', '%' . $request->input('name') . '%');
        }

        if ($request->has('document')) {
            $patients->where('cpf', $request->input('cpf'));
        }

        $patients = $patients->paginate(10);

        return PatientResource::collection($patients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
        $patient = Patient::create($request->validated());
        $patient->address()->create($request->validated());

        return new PatientResource($patient);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $patient->update($request->validated());
        $patient->address->update($request->validated());

        return new PatientResource($patient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $patient->delete();
        return response()->noContent();
    }
}
