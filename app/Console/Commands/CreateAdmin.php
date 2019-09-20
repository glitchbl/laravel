<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use App\Admin;
use Exception;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Création d'un compte admin";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (!(new EmailValidator)->isValid($email, new RFCValidation)) {
            throw new Exception("L'adresse email renseignée n'est pas valide");
        }

        // if (strlen($password) < 6) {
        //     throw new Exception("Veuillez renseigner un mot de passe d'au moins 6 caractères");
        // }

        if (Admin::where('email', $email)->count()) {
            throw new Exception("L'email {$email} est déjà utilisé");
        }

        Admin::create([
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->info('Compte ajouté!');
        $this->info("Email : {$email}");
        $this->Info("Mot de passe : {$password}");
    }
}
