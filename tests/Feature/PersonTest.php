<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Person;
use Tests\TestCase;

class PersonTest extends TestCase
{
    /**
     * Test the create person api end point and check the database and assert.
     */
    public function test_store_person_successful()
    {
        $data = [
            'firstname' => 'Jerry',
            'lastname'  => 'Endaya',
            'address'   => '424 3rd Street Barangay Katuparan',
            'age'       => 22
        ];

        $response = $this->postJson('/api/createPerson', $data);

        $response->assertStatus(200); // HTTP 200 OK
        $response->assertJson([
            'message' => 'Person Added',
        ]);

        // check if the person is created in the database
        $this->assertDatabaseHas('people', [
            'firstname' => 'Jerry',
            'lastname'  => 'Endaya',
            'address'   => '424 3rd Street Barangay Katuparan',
            'age'       => 22
        ]);
    }

    /**
     * Test updating a person successfully.
     */
    public function test_update_person_successful()
    {
        // Create a person to update
        $person = Person::create([
            'firstname' => 'Jerry',
            'lastname'  => 'Endaya',
            'address'   => '424 3rd Street Barangay Katuparan',
            'age'       => 29
        ]);

        // Data to update
        $updatedData = [
            'firstname' => 'Marcus',
            'lastname'  => 'Elmar',
            'address'   => '424 3rd Street Barangay Katuparan',
            'age'       => 31
        ];

        // Send PUT request to update the person
        $response = $this->putJson("/api/updatePerson/{$person->id}", $updatedData);

        // Assert the response status and message
        $response->assertStatus(200); // HTTP 200 OK
        $response->assertJson([
            'message' => 'Data Successfully Updated',
        ]);

        // Assert the database contains the updated data
        $this->assertDatabaseHas('people', [
            'id'        => $person->id,
            'firstname' => 'Marcus',
            'lastname'  => 'Elmar',
            'address'   => '424 3rd Street Barangay Katuparan',
            'age'       => 31
        ]);
    }

    /**
     * Test successfully deleting a person.
     */
    public function test_destroy_person_successful()
    {
        // Create a person in the database
        $person = Person::create([
            'firstname' => 'Marcus',
            'lastname'  => 'Elmar',
            'address'   => '424 3rd Street Barangay Katuparan',
            'age'       => 31
        ]);

        // Send DELETE request to delete the person
        $response = $this->deleteJson("/api/deletePerson/{$person->id}");

        // Assert that the response has status 200
        $response->assertStatus(200); // HTTP 200 OK
        $response->assertJson([
            'message' => 'Data Deleted Successfully '
        ]);

        // Assert that the person has been deleted from the database
        $this->assertDatabaseMissing('people', [
            'id' => $person->id
        ]);
    }

    /**
     * Test searching for a person by name.
     */
    public function test_search_person_found()
    {
        // Create a few person records in the database
        $person1 = Person::create([
            'firstname' => 'Marcus',
            'lastname'  => 'Elmar',
            'address'   => '424 3rd Street Barangay Katuparan',
            'age'       => 31
        ]);

        $person2 = Person::create([
            'firstname' => 'Marcus',
            'lastname'  => 'Jane',
            'address'   => '424 3rd Street Barangay Katuparan',
            'age'       => 34
        ]);

        // Send GET request to search for a person by first name
        $response = $this->getJson("/api/search/Marcus");

        // Assert that the response has status 200
        $response->assertStatus(200); // HTTP 200 OK

        // Assert that the data returned contains the correct person
        $response->assertJsonFragment([
            'firstname' => 'Marcus',
            'lastname'  => 'Jane',
            'address'   => '424 3rd Street Barangay Katuparan',
            'age'       => 34
        ]);
    }
   
}
