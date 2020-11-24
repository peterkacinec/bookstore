<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

    /**
     * User model.
     *
     * @var object
     */
    private $user;

    /**
     * Create a new command instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = $this->getUserData();
        $user = $this->createUser($data);
        $this->display($user);
    }

    /**
     * Ask for user data.
     *
     * @return array
     */
    private function getUserData() : array
    {
        $user['name']    = $this->ask('Enter name', 'Admin_name');
        $user['surname'] = $this->ask('Enter surname', 'Admin_surname');
        $user['email']   = $this->ask('Enter email/login', 'admin@bookstore.sk');
        $user['password'] = $this->secret('Enter '.$user["email"].' password') ?? '';
        $user['confirm_password'] = $this->secret('Confirm password') ?? '';

        while (!$this->isValidPassword($user['password'], $user['confirm_password'])) {
            if (!$this->isRequiredLength($user['password'])) {
                $this->error('Password must be longer or equals to 6 characters');
            }

            if (!$this->isMatch($user['password'], $user['confirm_password'])) {
                $this->error('Password and Confirm password do not match');
            }

            $user['password'] = $this->secret('Enter password again') ?? '';
            $user['confirm_password'] = $this->secret('Confirm password') ?? '';
        }

        return $user;
    }

    /**
     * Save user to DB
     *
     * @param array $data
     * @return User|bool
     */
    private function createUser(array $data)
    {
        // Test DB connection and table
        try {
            DB::connection()->getPdo();
            if (!Schema::hasTable('users')) {
                die("Neexistuje tabulka users, pravdepodobne treba spustit migracie.");
            }
        } catch (\Exception $e) {
            die("Could not connect to the database. Please check your configuration. error:" . $e );
        }

        $user = new User($data);
        $user->password = bcrypt($data['password']);

        if (!$user->save()) {
            $this->error('Something went wrong!');
            return false;
        }

        return $user;
    }

    /**
     * Display created user.
     *
     * @param User $user
     * @return void
     */
    private function display(User $user) : void
    {
        $headers = ['Name', 'Surname', 'Email/Login'];

        $fields = [
            'name'      => $user->name,
            'surname'   => $user->surname,
            'email'     => $user->email
        ];

        $this->info('User successfully created');
        $this->table($headers, [$fields]);
    }

    /**
     * Check if password is valid
     *
     * @param string $password
     * @param string $confirmPassword
     * @return boolean
     */
    private function isValidPassword(string $password, string $confirmPassword) : bool
    {
        return $this->isRequiredLength($password) && $this->isMatch($password, $confirmPassword);
    }

    /**
     * Check if password and confirm password matches.
     *
     * @param string $password
     * @param string $confirmPassword
     * @return bool
     */
    private function isMatch(string $password, string $confirmPassword) : bool
    {
        return Hash::check($confirmPassword, bcrypt($password));
    }

    /**
     * Checks if password is longer or equals to 6 characters.
     *
     * @param string $password
     * @return bool
     */
    private function isRequiredLength(string $password) : bool
    {
        return strlen($password) >= 6;
    }
}
