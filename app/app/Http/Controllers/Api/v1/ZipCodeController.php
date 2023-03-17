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

    public function __construct(ZipCodeService $zipCodeService)
    {
        $this->zipCodeService = $zipCodeService;
    }

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
