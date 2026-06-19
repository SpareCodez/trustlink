<?php

namespace Tests\Feature;

use App\Contracts\SmsSender;
use App\Enums\UserRole;
use App\Models\PhoneVerificationChallenge;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PhoneRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private FakeSmsSender $smsSender;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->smsSender = new FakeSmsSender;
        $this->app->instance(SmsSender::class, $this->smsSender);
    }

    public function test_otp_request_normalizes_the_phone_and_stores_only_a_hash(): void
    {
        $this->postJson('/register/otp', [
            'phone_number' => '024 123 4567',
        ])->assertOk()->assertJson([
            'phone_number' => '+233241234567',
        ]);

        $challenge = PhoneVerificationChallenge::firstOrFail();

        $this->assertSame('+233241234567', $this->smsSender->phoneNumber);
        $this->assertTrue(Hash::check($this->smsSender->code, $challenge->code_hash));
        $this->assertNotSame($this->smsSender->code, $challenge->code_hash);
    }

    public function test_valid_otp_creates_a_verified_merchant_account(): void
    {
        $this->requestOtp();

        $this->post('/register', $this->registrationPayload($this->smsSender->code))
            ->assertRedirect('/home');

        $user = User::where('email', 'ama@example.com')->firstOrFail();

        $this->assertSame('+233241234567', $user->phone_number);
        $this->assertNotNull($user->phone_verified_at);
        $this->assertTrue($user->hasRole(UserRole::Merchant));
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_otp_does_not_create_an_account(): void
    {
        $this->requestOtp();

        $this->from('/register')
            ->post('/register', $this->registrationPayload('000000'))
            ->assertRedirect('/register')
            ->assertSessionHasErrors('otp');

        $this->assertDatabaseMissing('users', ['email' => 'ama@example.com']);
        $this->assertDatabaseHas('phone_verification_challenges', [
            'phone_number' => '+233241234567',
            'failed_attempts' => 1,
        ]);
    }

    public function test_expired_otp_does_not_create_an_account(): void
    {
        $this->requestOtp();

        PhoneVerificationChallenge::query()->update([
            'expires_at' => now()->subSecond(),
        ]);

        $this->post('/register', $this->registrationPayload($this->smsSender->code))
            ->assertSessionHasErrors('otp');

        $this->assertDatabaseMissing('users', ['email' => 'ama@example.com']);
    }

    public function test_duplicate_phone_number_cannot_request_an_otp(): void
    {
        User::factory()->create(['phone_number' => '+233241234567']);

        $response = $this->postJson('/register/otp', [
            'phone_number' => '0241234567',
        ]);

        $response->assertUnprocessable();
        $this->assertSame(
            'An account already uses this phone number.',
            $response->json('errors.phone_number.0'),
        );
    }

    public function test_invalid_ghana_phone_number_is_rejected(): void
    {
        $response = $this->postJson('/register/otp', [
            'phone_number' => '12345',
        ]);

        $response->assertUnprocessable();
        $this->assertSame(
            'Enter a valid Ghana mobile number.',
            $response->json('errors.phone_number.0'),
        );
    }

    public function test_otp_cannot_be_resent_during_the_cooldown(): void
    {
        $this->requestOtp();

        $response = $this->postJson('/register/otp', [
            'phone_number' => '0241234567',
        ]);

        $response->assertUnprocessable();
        $this->assertSame(
            'Please wait before requesting another code.',
            $response->json('errors.phone_number.0'),
        );
    }

    public function test_otp_is_locked_after_five_incorrect_attempts(): void
    {
        $this->requestOtp();

        foreach (range(1, 5) as $attempt) {
            $this->post('/register', $this->registrationPayload('000000'))
                ->assertSessionHasErrors('otp');
        }

        $this->post('/register', $this->registrationPayload($this->smsSender->code))
            ->assertSessionHasErrors('otp');

        $this->assertDatabaseMissing('users', ['email' => 'ama@example.com']);
        $this->assertDatabaseHas('phone_verification_challenges', [
            'phone_number' => '+233241234567',
            'failed_attempts' => 5,
        ]);
    }

    private function requestOtp(): void
    {
        $this->postJson('/register/otp', [
            'phone_number' => '0241234567',
        ])->assertOk();
    }

    private function registrationPayload(string $otp): array
    {
        return [
            'name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone_number' => '0241234567',
            'otp' => $otp,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
    }
}

class FakeSmsSender implements SmsSender
{
    public string $phoneNumber;

    public string $code;

    public function sendOtp(string $phoneNumber, string $code, int $expiresInMinutes): void
    {
        $this->phoneNumber = $phoneNumber;
        $this->code = $code;
    }
}
