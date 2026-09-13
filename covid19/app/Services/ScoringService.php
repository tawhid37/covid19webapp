<?php

namespace App\Services;

/**
 * Centralises the COVID-19 self-assessment scoring rules so they can be
 * unit-tested independently of the HTTP layer.
 *
 * Scoring rules (extracted verbatim from the original controller logic):
 *  - "NoneOfThese" alone                  -> 0 points
 *  - 1 selected symptom                   -> +3 points
 *  - 2+ selected symptoms                 -> +count + 2 points
 *  - each additional symptom ("asymptoms") -> +2 points each
 *  - body temperature 99.5 - 100.9        -> +2 points
 */
class ScoringService
{
    public const NONE_OF_THESE = 'NoneofThese';

    /**
     * Compute the risk score for a set of symptoms and body temperature.
     *
     * @param array       $symptoms          Primary symptom selections.
     * @param array       $additionalSymptoms Additional symptom selections.
     * @param int|float|string $bodyTemperature Body temperature value.
     *
     * @return int
     */
    public function score(array $symptoms, array $additionalSymptoms, $bodyTemperature): int
    {
        $counter = 0;

        if ($this->isOnlyNoneOfThese($symptoms)) {
            $counter = 0;
        } elseif (count($symptoms) >= 2) {
            $counter += count($symptoms) + 2;
        } elseif (count($symptoms) === 1) {
            $counter += 3;
        }

        if (! $this->isOnlyNoneOfThese($additionalSymptoms)) {
            $counter += count($additionalSymptoms) * 2;
        }

        if ($this->hasSubfebrileFever($bodyTemperature)) {
            $counter += 2;
        }

        return $counter;
    }

    /**
     * Whether the body temperature falls within the "slight fever" range.
     *
     * @param int|float|string $bodyTemperature
     *
     * @return bool
     */
    public function hasSubfebrileFever($bodyTemperature): bool
    {
        $temperature = (float) $bodyTemperature;

        return $temperature >= 99.5 && $temperature <= 100.9;
    }

    /**
     * Translate a score into the screening result label.
     *
     * @param int $score
     *
     * @return string
     */
    public function resultFor(int $score): string
    {
        return $score < 5 ? 'Negative' : 'Positive';
    }

    /**
     * Whether the selection contains exactly the "None of these" option.
     *
     * @param array $items
     *
     * @return bool
     */
    private function isOnlyNoneOfThese(array $items): bool
    {
        return count($items) === 1 && in_array(self::NONE_OF_THESE, $items, true);
    }
}