<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PatientRequest;
use App\Http\Resources\v1\PatientResource;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * It takes a search term from the request, uses the search method on the Patient model to find all
     * patients that match the search term, and then returns a JSON response of the PatientResource
     * collection
     * 
     * @param Request request The request object.
     * 
     * @return A collection of patients
     */
    public function index(Request $request)
    {
        $patients = Patient::search($request->search);
        return response()->json(PatientResource::collection($patients));
    }

    /**
     * > We create a new patient and then create a new address for that patient
     * 
     * @param PatientRequest request The request object.
     * 
     * @return A new PatientResource
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
        $patient = Patient::findOrFail($id);
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
        $patient = Patient::findOrFail($id);

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
        $patient = Patient::findOrFail($id);
        $patient->delete();
        
        return response()->noContent();
    }
}
