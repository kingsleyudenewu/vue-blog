<?php

namespace App\Actions;

use App\Models\User;

class GenerateTokenAction
{
    /**
     * Format payload to be sent to the user
     *
     * @param User $user
     * @return array
     */
    public function generatePayload(User $user): array
    {
        $token = $user->createToken("API TOKEN")->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
            'token_type' => 'Bearer',
        ];
    }
}
