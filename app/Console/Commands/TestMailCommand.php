<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email? : The email address to send the test message to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify SMTP configuration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $recipient = $this->argument('email');

        if (empty($recipient)) {
            $recipient = $this->ask('Enter destination email address:');
        }

        if (empty($recipient) || ! filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid destination email address.');
            return 1;
        }

        $this->info("--------------------------------------------------");
        $this->info("Testing SMTP Email Configuration");
        $this->info("--------------------------------------------------");
        $this->line("Mailer:       " . config('mail.default'));
        $this->line("Host:         " . config('mail.mailers.smtp.host'));
        $this->line("Port:         " . config('mail.mailers.smtp.port'));
        $this->line("Encryption:   " . config('mail.mailers.smtp.encryption'));
        $this->line("Username:     " . config('mail.mailers.smtp.username'));
        $this->line("From Address: " . config('mail.from.address'));
        $this->line("From Name:    " . config('mail.from.name'));
        $this->line("To:           " . $recipient);
        $this->info("--------------------------------------------------");
        $this->line("Sending test email...");

        try {
            Mail::raw("¡Excelente! La configuración de correo SMTP en tu sistema " . config('app.name', 'AudazPOS') . " funciona perfectamente.\n\nFecha y hora: " . now()->toDateTimeString(), function ($message) use ($recipient) {
                $message->to($recipient)
                    ->subject('✅ Prueba Exitosa de Correo SMTP - ' . config('app.name', 'AudazPOS'));
            });

            $this->info("✅ SUCCESS: Test email successfully sent to: {$recipient}");
            $this->info("Check your inbox (and spam folder) for the confirmation message.");
            return 0;
        } catch (\Exception $e) {
            $this->error("❌ ERROR: Failed to send email.");
            $this->error($e->getMessage());
            return 1;
        }
    }
}
