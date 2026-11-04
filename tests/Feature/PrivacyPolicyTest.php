<?php

namespace Tests\Feature;

use Tests\TestCase;

class PrivacyPolicyTest extends TestCase
{
    public function test_privacy_policy_is_public_and_identifies_the_operator(): void
    {
        $this->get('/privacy')
            ->assertOk()
            ->assertSee('Privacy Policy')
            ->assertSee('SLSU-BONTOC Digital Technology')
            ->assertSee('slsubontocdigitaltech@gmail.com');
    }
}
