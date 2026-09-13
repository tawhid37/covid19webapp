<?php

namespace Tests\Unit;

use App\Services\ScoringService;
use PHPUnit\Framework\TestCase;

class ScoringServiceTest extends TestCase
{
    private $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ScoringService();
    }

    /** @test */
    public function it_scores_zero_when_only_none_of_these_is_selected()
    {
        $this->assertSame(0, $this->service->score(['NoneofThese'], ['NoneofThese'], 98.6));
    }

    /** @test */
    public function it_adds_three_points_for_a_single_symptom()
    {
        $this->assertSame(3, $this->service->score(['Cough'], ['NoneofThese'], 98.4));
    }

    /** @test */
    public function it_adds_count_plus_two_for_multiple_symptoms()
    {
        $score = $this->service->score(['Cough', 'Fever'], ['NoneofThese'], 98.4);

        $this->assertSame(4, $score);
    }

    /** @test */
    public function it_counts_additional_symptoms_doubled()
    {
        $score = $this->service->score(['Cough'], ['Fatigue', 'Headache'], 98.4);

        $this->assertSame(7, $score);
    }

    /** @test */
    public function it_ignores_none_of_these_inside_additional_symptoms()
    {
        $score = $this->service->score(['Cough'], ['NoneofThese'], 98.4);

        $this->assertSame(3, $score);
    }

    /** @test */
    public function it_adds_two_points_for_temperature_at_lower_boundary()
    {
        $this->assertSame(2, $this->service->score(['NoneofThese'], ['NoneofThese'], 99.5));
    }

    /** @test */
    public function it_adds_two_points_for_temperature_at_upper_boundary()
    {
        $this->assertSame(2, $this->service->score(['NoneofThese'], ['NoneofThese'], 100.9));
    }

    /** @test */
    public function it_does_not_add_points_below_temperature_threshold()
    {
        $this->assertSame(0, $this->service->score(['NoneofThese'], ['NoneofThese'], 99.4));
    }

    /** @test */
    public function it_does_not_add_points_above_temperature_threshold()
    {
        $this->assertSame(0, $this->service->score(['NoneofThese'], ['NoneofThese'], 101.0));
    }

    /** @test */
    public function it_results_negative_for_scores_below_five()
    {
        $this->assertSame('Negative', $this->service->resultFor(0));
        $this->assertSame('Negative', $this->service->resultFor(4));
    }

    /** @test */
    public function it_results_positive_for_scores_of_five_and_above()
    {
        $this->assertSame('Positive', $this->service->resultFor(5));
        $this->assertSame('Positive', $this->service->resultFor(9));
    }
}