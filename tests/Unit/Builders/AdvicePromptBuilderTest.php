<?php

namespace Tests\Unit\Builders;

use App\Builders\AdvicePromptBuilder;
use App\DTOs\AdviceRequestDTO;
use Carbon\Carbon;
use Tests\TestCase;

class AdvicePromptBuilderTest extends TestCase
{
    public function test_build_returns_exact_prompt()
    {
        $dto = new AdviceRequestDTO([
                'United Kingdom',
                'Canada'
            ],
            Carbon::createFromFormat('Y-m-d H:i', '2025-04-02 12:00')->toDateString(),
            Carbon::createFromFormat('Y-m-d H:i', '2025-07-02 10:00')->toDateString()
        );

        $result = AdvicePromptBuilder::build($dto);
        $expected = "Generate travel advice for United Kingdom, Canada from 2025-04-02 to 2025-07-02";
        $this->assertEquals($expected, $result);
    }
}
