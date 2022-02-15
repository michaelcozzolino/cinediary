<?php

namespace Tests\Unit\Traits;

use App\Traits\ScreenplayTypes;
use Tests\TestCase;

class ScreenplayTypesTest extends TestCase {

    /** @test */
    public function it_returns_the_correct_available_screenplay_types(){
        $trait = $this->getObjectForTrait(ScreenplayTypes::class);

        $screenplayTypes = $trait->getScreenplayTypes();
        $this->assertCount(2, $screenplayTypes);
        $this->assertTrue(in_array('movies', $screenplayTypes));
        $this->assertTrue(in_array('series', $screenplayTypes));
    }

}
