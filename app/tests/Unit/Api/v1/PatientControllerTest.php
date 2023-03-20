<?php

namespace Tests\Unit\Api\v1;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDestroy()
    {
        $user = User::factory()->create();
        $patient = Patient::factory()->create();

        $response = $this->actingAs($user)->delete(route('patients.destroy', $patient->id));

        $response->assertNoContent();
        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
    }

    public function testDestroyWithNonExistingPatient()
    {
        $response = $this->delete(route('patients.destroy', 999));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'message' => 'Patient not found',
        ]);
    }
}
