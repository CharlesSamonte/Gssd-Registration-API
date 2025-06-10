<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\EmailService;

class AccessCodeService
{
    protected $tableName = 'Mst_SWIS';
    protected $idColName = 'SWIS_ID';
    protected $codeColName = 'Hashed_Code';
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index($userID)
    {
        [$rawCode, $hashedCode] = $this->generateCode();
        $this->insertCode($userID, $rawCode);
        $this->emailCode($userID, $rawCode);
    }

    public function generateCode()
    {
        $code = random_int(100000, 999999);
        $hashedCode = Hash::make($code);

        return [$code, $hashedCode];
    }

    public function insertCode($userID, $hashedCode)
    {
        DB::table($this->tableName)
            ->where($this->idColName, $userID)
            ->update([$this->codeColName => $hashedCode]);
    }

    public function emailCode($userID, $rawCode)
    {
        $user = DB::table($this->tableName)
            ->where($this->idColName, $userID)
            ->first();

        if ($user && isset($user->E_mail)) {
            $body = '<div style="text-align: center;"><h2>Here is your access code</h2><h1>' . $rawCode . '</h1></div>';
            $this->emailService->sendEmail(
                $user->E_mail,
                "Your Access Code",
                $body
            );
        }
    }

    public function validateCode($userID, $inputCode)
    {
        $storedHashedCode = DB::table($this->tableName)
            ->where($this->idColName, $userID)
            ->value($this->codeColName);

        return $inputCode == $storedHashedCode;
        // return Hash::check($inputCode, $storedHashedCode);
    }

}