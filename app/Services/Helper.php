<?php

namespace App\Services;

class Helper {
    /**
     * @param int|float $number
     * @param int $decimals
     * @return string
     */
    public function formatNumber($number, $decimals = 2)
    {
        return number_format($number, $decimals, ',', ' ');
    }

    /**
     * @param string|array $destinataires
     * @return \Illuminate\Mail\PendingMail
     */
    public function mailTo($destinataires)
    {
        if (config('app.env') === 'local' || request()->ip() === config('app.ip')) {
            $dst_imp = (is_array($destinataires)? implode(',', $destinataires): "'{$destinataires}'");
            \Log::info("Envoi d'un email pour {$dst_imp}");
            return \Mail::to(config('app.email'));
        } else {
            return \Mail::to($destinataires)->bcc(config('app.email'));
        }
    }
}