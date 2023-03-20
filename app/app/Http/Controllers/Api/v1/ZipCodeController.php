<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\InvalidZipCodeException;
use App\Http\Controllers\Controller;
use App\Services\ZipCodeService;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ZipCodeController extends Controller
{
    private $zipCodeService;

    /**
     * > The constructor function is used to create a new instance of the ZipCodeController class
     * 
     * @param ZipCodeService zipCodeService This is the service that we're injecting into the controller.
     */
    public function __construct(ZipCodeService $zipCodeService)
    {
        $this->zipCodeService = $zipCodeService;
    }

    /**
     * It returns a JSON response with the zip code data if the zip code is valid, or an error message if
     * it's not
     * 
     * @param string code The zip code to fetch data for
     * 
     * @return A JSON response with the zip code data or an error message.
     */
    public function getZipCode(string $code)
    {
        try {
            $zipCodeData = $this->zipCodeService->fetchZipCodeData($code);

            return response()->json($zipCodeData, Response::HTTP_OK);
        } catch (InvalidZipCodeException $ex) {
            return response()->json([
                'message' => 'Invalid Zip code',
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            return response()->json([
                'message' => 'An error occurred',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
