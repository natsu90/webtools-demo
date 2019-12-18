<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Patient;
use App\User;
use Auth;

class PatientsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // https://www.5balloons.info/laravel-tdd-beginner-crud-example/
    public function test_guest_user_cannot_view_patient_page()
    {
        $response = $this->get('/patients');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_view_patient_page()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/patients');
        $response->assertStatus(200);
    }

    public function test_guest_user_cannot_add_patient()
    {
        $patient = factory(Patient::class)->make();

        $this->post('/patient', $patient->toArray())
            ->assertRedirect('/login');
    }

    public function test_authenticated_user_can_add_patient()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user);
        $patient = factory(Patient::class)->make();

        $response = $this->post('/patient', $patient->toArray());

        $this->assertEquals(1, Patient::all()->count());
        $response->assertRedirect('/patients/'. Patient::first()->id);
    }

    // https://www.startutorial.com/articles/view/phpunit-beginner-part-2-data-provider
    public function emptyDataProvider()
    {
        return [
            [null], [""], ["  "], ["\r\n"]
        ];
    }

    /**
     * @dataProvider emptyDataProvider
     */
    public function test_add_patient_requires_name($emptyValue)
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $patient = factory(Patient::class)->make(['name' => $emptyValue]);

        $response = $this->post('/patient', $patient->toArray());

        $response->assertSessionHasErrors('name');
    }

    public function test_guest_user_cannot_update_patient()
    {
        $user = factory(User::class)->create();
        // need to login everytime create patient?
        $this->actingAs($user);

        $patient = factory(Patient::class)->create();
        $old_patient_name = $patient->name;

        Auth::logout();

        $this->post('/patients/'. $patient->id, ['name' => 'New Name'])
            ->assertRedirect('/login');

        $this->assertDatabaseHas('patients', ['id' => $patient->id, 'name' => $old_patient_name]);
    }

    public function test_authenticated_user_can_update_patient()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $patient = factory(Patient::class)->create();
        $new_name = 'New Name';

        $response = $this->post('/patients/' .$patient->id, ['name' => $new_name]);

        $this->assertDatabaseHas('patients', ['id' => $patient->id, 'name' => $new_name]);
        $response->assertRedirect('/patients/'. $patient->id);
    }

    /**
     * @dataProvider emptyDataProvider
     */
    public function test_update_patient_requires_name($emptyValue)
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $patient = factory(Patient::class)->create();
        $old_patient_name = $patient->name;

        $response = $this->post('/patients/'.$patient->id, ['name' => $emptyValue]);

        $this->assertDatabaseHas('patients', ['id' => $patient->id, 'name' => $old_patient_name]);
        $response->assertSessionHasErrors('name');
    }
}
