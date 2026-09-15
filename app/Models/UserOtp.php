<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserOtp extends Model
{
    use HasFactory, HasUuids;

    /**
     * Clé primaire en UUID
     */
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Les champs assignables
     */
    protected $fillable = ['user_id', 'otp', 'expire_at'];

    /**
     * Relation vers l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Envoyer le SMS OTP
     */
    public function sendSMS($receiverNumber)
    {
        $message = 'HaMoj Login OTP is ' . $this->otp . ' Will expire in 10 mins. Do not share with anyone.';
        
        try {
            $account_id = getenv('TWILIO_SID');
            $auth_token = getenv('TWILIO_TOKEN');
            $twilio_number = getenv('TWILIO_FROM');

            $client = new Client($account_id, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message,
            ]);

            info('Login OTP sent successfully.');
        } catch (\Throwable $e) {
            info('Error: ' . $e->getMessage());
        }
    }
}