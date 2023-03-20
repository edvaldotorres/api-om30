<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ImportCsvRequest;
use App\Http\Requests\v1\PatientRequest;
use App\Http\Resources\v1\PatientResource;
use App\Imports\PatientsImport;
use App\Models\Patient;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class PatientController extends Controller
{
    use UploadFile;

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
     * We create a new patient and address record in the database
     * 
     * @param PatientRequest request The request object.
     * 
     * @return A PatientResource
     */
    public function store(PatientRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = $this->uploadImage($request->image, 'images');
            $validatedData['image'] = $imageName;
        }

        $patient = Patient::create($validatedData);
        $patient->address()->create($validatedData);

        return new PatientResource($patient);
    }

    /**
     * It takes the id of a patient, finds the patient in the database, and returns a JSON response
     * containing the patient's data
     * 
     * @param id The id of the patient you want to show.
     * 
     * @return A single patient resource.
     */
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return new PatientResource($patient);
    }

    /**
     * It updates the patient and address records
     * 
     * @param PatientRequest request The request object.
     * @param id The id of the patient to be updated.
     * 
     * @return A PatientResource
     */
    public function update(PatientRequest $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $this->uploadDeleteImage($patient->image);
            $imageName = $this->uploadImage($request->image, 'images');
            $validatedData['image'] = $imageName;
        }

        $patient->update($validatedData);
        $patient->address->update($request->validated());

        return new PatientResource($patient);
    }

    /**
     * It deletes the patient with the given ID
     * 
     * @param id The id of the patient to be deleted.
     * 
     * @return A 204 No Content response.
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->noContent();
    }

    /**
     * It receives a CSV file, stores it in the storage folder, and then uses the Laravel Excel package to
     * import the data into the database
     * 
     * @param ImportCsvRequest request The request object.
     * 
     * @return A JSON response with a message.
     */
    public function import(ImportCsvRequest $request)
    {
        $file = $request->file('file')->storeAs('csv',  time() . '-' . 'import-patients.csv');

        Excel::import(new PatientsImport, $file);

        return response()->json([
            'message' => 'Patients imported successfully'
        ], Response::HTTP_CREATED);
    }
}
