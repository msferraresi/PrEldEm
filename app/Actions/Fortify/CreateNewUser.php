<?php

namespace App\Actions\Fortify;

use App\Models\Membership;
use App\Models\TeamInvitation;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'exists:team_invitations,email'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            $teamInvitation = TeamInvitation::select('role')->where('email', $input['email'])->first();

            if($teamInvitation == null) $teamInvitation = ['role'=>'colaborator'];

            return tap(User::create(
                [
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                ])->assignRole($teamInvitation['role']), function (User $user) {
                    $team = TeamInvitation::where('email', $user['email'])->first();
                    if($team != null ) $this->acceptInvitation($user, $team);
                }
            );
        });
    }

    protected function acceptInvitation(User $user, TeamInvitation $team)
    {
        $user->current_team_id = $team['team_id'];
        $user->save();
        Membership::create([
            'team_id' => $team['team_id'],
            'user_id' => $user['id'],
            'role' => $team['role'],
        ]);
        $team->delete();
    }
}
