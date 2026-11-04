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
            ->assertSee('privacy@cotstracker.com');
    }

    public function test_account_deletion_request_is_public(): void
    {
        $this->get('/account-deletion')
            ->assertOk()
            ->assertSee('Delete your account')
            ->assertSee('COTS Tracker account deletion request')
            ->assertSee('privacy@cotstracker.com');
    }
}
