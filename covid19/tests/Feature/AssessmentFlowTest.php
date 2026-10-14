<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssessmentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function validStep1(): array
    {
        return [
            'name'     => 'John Doe',
            'age'      => '34',
            'sex'      => 'male',
            'bodytemp' => '98.6',
        ];
    }

    /**
     * @return void
     */
    public function testStep1AcceptsValidPersonalDataAndRendersStep2()
    {
        $response = $this->post('/assessment', $this->validStep1());

        $response
            ->assertStatus(200)
            ->assertSee('Self-Assessment Form (Step 2)')
            ->assertSee('John Doe');
    }

    /**
     * @return void
     */
    public function testStep1RejectsMissingRequiredFields()
    {
        $response = $this->post('/assessment', []);

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors(['name', 'age', 'sex', 'bodytemp']);
    }

    /**
     * @return void
     */
    public function testStep1RejectsOutOfRangeAge()
    {
        $response = $this->post('/assessment', array_merge($this->validStep1(), ['age' => '130']));

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('age');
    }

    /**
     * @return void
     */
    public function testStep1RejectsOutOfRangeBodyTemperature()
    {
        $response = $this->post('/assessment', array_merge($this->validStep1(), ['bodytemp' => '95.0']));

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('bodytemp');
    }

    /**
     * @return void
     */
    public function testStep2AcceptsSymptomsAndRendersStep3()
    {
        $response = $this->post('/assessment1', array_merge($this->validStep1(), ['symptoms' => ['dry_cough']]));

        $response
            ->assertStatus(200)
            ->assertSee('Self-Assessment Form (Step 3)');
    }

    /**
     * @return void
     */
    public function testStep2RejectsMissingSymptoms()
    {
        $response = $this->post('/assessment1', $this->validStep1());

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors('symptoms');
    }

    /**
     * @return void
     */
    public function testFinalResultPersistsNegativeRecordForZeroScore()
    {
        $response = $this->post('/assessment2', array_merge($this->validStep1(), [
            'symptoms'  => ['NoneofThese'],
            'asymptoms' => ['NoneofThese'],
        ]));

        $response
            ->assertStatus(200)
            ->assertSee('Final Result')
            ->assertSee('Negative');

        $this->assertDatabaseHas('covids', [
            'Name' => 'John Doe',
            'Score' => 0,
            'Result' => 'Negative',
        ])->assertDatabaseCount('covids', 1);
    }

    /**
     * @return void
     */
    public function testFinalResultPersistsNegativeRecordForScoreBelowFive()
    {
        $response = $this->post('/assessment2', array_merge($this->validStep1(), [
            'symptoms'  => ['dry_cough', 'weakness'],
            'asymptoms' => ['NoneofThese'],
        ]));

        $response
            ->assertStatus(200)
            ->assertSee('Negative');

        $this->assertDatabaseHas('covids', [
            'Name' => 'John Doe',
            'Score' => 4,
            'Result' => 'Negative',
        ]);
    }

    /**
     * @return void
     */
    public function testFinalResultPersistsPositiveRecordForScoreOfFive()
    {
        $response = $this->post('/assessment2', array_merge($this->validStep1(), [
            'symptoms'  => ['dry_cough'],
            'asymptoms' => ['abdominal_pain'],
        ]));

        $response
            ->assertStatus(200)
            ->assertSee('Positive');

        $this->assertDatabaseHas('covids', [
            'Name' => 'John Doe',
            'Score' => 5,
            'Result' => 'Positive',
        ]);
    }

    /**
     * @return void
     */
    public function testFinalResultAddsTwoPointsForSubfebrileTemperature()
    {
        $response = $this->post('/assessment2', array_merge($this->validStep1(), [
            'bodytemp'  => '100.0',
            'symptoms'  => ['dry_cough'],
            'asymptoms' => ['abdominal_pain'],
        ]));

        $response
            ->assertStatus(200)
            ->assertSee('Positive');

        $this->assertDatabaseHas('covids', [
            'Name' => 'John Doe',
            'Score' => 7,
            'Result' => 'Positive',
        ]);
    }

    /**
     * @return void
     */
    public function testFinalResultUsesCorrectLowerTemperatureBoundary()
    {
        $this->post('/assessment2', array_merge($this->validStep1(), [
            'name'      => 'Boundary 99.4',
            'bodytemp'  => '99.4',
            'symptoms'  => ['NoneofThese'],
            'asymptoms' => ['NoneofThese'],
        ]));

        $this->assertDatabaseHas('covids', [
            'Name' => 'Boundary 99.4',
            'Score' => 0,
        ]);

        $this->post('/assessment2', array_merge($this->validStep1(), [
            'name'      => 'Boundary 99.5',
            'bodytemp'  => '99.5',
            'symptoms'  => ['NoneofThese'],
            'asymptoms' => ['NoneofThese'],
        ]));

        $this->assertDatabaseHas('covids', [
            'Name' => 'Boundary 99.5',
            'Score' => 2,
        ]);
    }

    /**
     * @return void
     */
    public function testFinalResultUsesCorrectUpperTemperatureBoundary()
    {
        $this->post('/assessment2', array_merge($this->validStep1(), [
            'name'      => 'Boundary 100.9',
            'bodytemp'  => '100.9',
            'symptoms'  => ['NoneofThese'],
            'asymptoms' => ['NoneofThese'],
        ]));

        $this->assertDatabaseHas('covids', [
            'Name' => 'Boundary 100.9',
            'Score' => 2,
        ]);

        $this->post('/assessment2', array_merge($this->validStep1(), [
            'name'      => 'Boundary 101.0',
            'bodytemp'  => '101.0',
            'symptoms'  => ['NoneofThese'],
            'asymptoms' => ['NoneofThese'],
        ]));

        $this->assertDatabaseHas('covids', [
            'Name' => 'Boundary 101.0',
            'Score' => 0,
        ]);
    }
}