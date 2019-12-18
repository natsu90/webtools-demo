<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Note;
use Auth;
use App\User;
use App\Patient;

class NotesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_user_cannot_view_note_page()
    {
        $this->actingAs(factory(User::class)->create());
        $patient = factory(Patient::class)->create();

        Auth::logout();

        $response = $this->get('/patients/'. $patient->id);

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_view_note_page()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);
        $patient = factory(Patient::class)->create();

        $response = $this->get('/patients/'. $patient->id);
        $response->assertStatus(200);
    }

    public function test_guest_user_cannot_add_note()
    {
        // $this->withoutExceptionHandling();

        $this->actingAs(factory(User::class)->create());
        $patient = factory(Patient::class)->create();

        $note = factory(Note::class)->make(['patient_id' => $patient->id]);

        Auth::logout();

        $this->post('/patients/'. $patient->id .'/note', $note->toArray())
            ->assertRedirect('/login');
        $this->assertEquals(0, Note::all()->count());
    }

    public function test_authenticated_user_can_add_note()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);
        $patient = factory(Patient::class)->create();

        $note = factory(Note::class)->make(['patient_id' => $patient->id]);

        $response = $this->post('/patients/' .$patient->id .'/note', $note->toArray());

        $this->assertEquals(1, Note::all()->count());
        $response->assertRedirect('/patients/'. $patient->id);
    }

    public function emptyDataProvider()
    {
        return [
            [null], [""], ["  "], ["\r\n"]
        ];
    }

    /**
     * @dataProvider emptyDataProvider
     */
    public function test_add_note_requires_description($emptyValue)
    {
        // $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user);
        $patient = factory(Patient::class)->create();

        $note = factory(Note::class)->make(['description' => $emptyValue, 'patient_id' => $patient->id]);

        $response = $this->post('/patients/'. $patient->id .'/note', $note->toArray());

        $response->assertSessionHasErrors('description');
    }

    public function test_guest_user_cannot_update_note()
    {
        // Illuminate\Auth\AuthenticationException: Unauthenticated.
        // $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        // need to login everytime create patient?
        $this->actingAs($user);

        $patient = factory(Patient::class)->create();
        $note = factory(Note::class)->create(['patient_id' => $patient->id]);
        $old_description = $note->description;

        Auth::logout();

        $this->post('/notes/'. $note->id, ['description' => 'New Description'])
            ->assertRedirect('/login');

        $this->assertDatabaseHas('notes', ['id' => $note->id, 'description' => $old_description]);
    }

    public function test_authenticated_user_can_update_note()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user);
        $patient = factory(Patient::class)->create();
        $note = factory(Note::class)->create(['patient_id' => $patient->id]);
        $new_description = 'New Description';

        $response = $this->post('/notes/'. $note->id, ['description' => $new_description]);

        $this->assertDatabaseHas('notes', ['id' => $note->id, 'description' => $new_description]);
        $response->assertRedirect('/patients/'. $patient->id);
    }

    /**
     * @dataProvider emptyDataProvider
     */
    public function test_update_note_requires_description($emptyValue)
    {
        // Illuminate\Validation\ValidationException: The given data was invalid.
        // $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user);
        $patient = factory(Patient::class)->create();
        $note = factory(Note::class)->create(['patient_id' => $patient->id]);
        $old_description = $note->description;

        $response = $this->post('/notes/'. $note->id, ['description' => $emptyValue]);

        $this->assertDatabaseHas('notes', ['id' => $note->id, 'description' => $old_description]);
        $response->assertSessionHasErrors('description');
    }
}
