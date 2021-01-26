<?php

namespace App\Actions\Fortify;

use App\Models\Cart;
use App\Models\Role;
use App\Models\User;
use App\Models\Wish_list;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'role' => ['required', 'exists:roles,id']
        ])->validate();

        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->roles()->attach($input['role']);
        
        if(Role::find($input['role'])->name == 'client')
        {
            Cart::create(['user_id' => $user->id]);
            Wish_list::create(['user_id' => $user->id]);
        }
        
        return $user;
    }
}
