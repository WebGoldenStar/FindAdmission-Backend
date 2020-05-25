<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Twilio\Rest\Client;

class UserController extends Controller
{
    use \App\Traits\UploadTrait;

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function register(Request $request)
    {
        $whatsapp_number = "+".strval($request->get('wadialingcode')).strval($request->get('waphone'));
        $phone_number = "+".strval($request->get('dialingcode')).strval($request->get('phone'));
        $user = User::create([
            'firstname' => $request->get('fname'),
            'lastname' => $request->get('lname'),
            'email' => $request->get('email'),
            'country' => $request->get('country'),
            'company' => $request->get('companyname'),
            'phonenumber' => $phone_number,
            'whatsapp_number' => $whatsapp_number,
            'gender' => $request->get('gender'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
    public function updateExpertise(Request $request){
        // echo $request->get('specialiseCountries');
        // exit();
        $user = User::findOrFail($request->get('userId'));
        $user->specialise_countries = $request->get('specialiseCountries');
        $user->countries_level = $request->get('experienceLevelCountry');
        $user->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function updateTraining(Request $request){
        // echo $request->get('specialiseCountries');
        // exit();
        $user = User::findOrFail($request->get('userId'));
        $user->training_from = $request->get('trainingFrom');
        $user->training_to = $request->get('trainingTo');
        $user->training_description = $request->get('trainingDescription');
        $user->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function updateLanguages(Request $request){
        // echo $request->get('specialiseCountries');
        // exit();
        $user = User::findOrFail($request->get('userId'));
        $user->speak_languages = $request->get('speakLanguages');
        $user->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function updateFees(Request $request){
        // echo $request->get('specialiseCountries');
        // exit();
        $user = User::findOrFail($request->get('userId'));
        $user->totalFee = $request->get('totalFees');
        $user->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function updateProfile(Request $request){
        // echo $request->get('specialiseCountries');
        // exit();
        $user = User::findOrFail($request->get('userId'));
        $user->profile_title = $request->get('profileTitle');
        $user->profile_overview = $request->get('profileOverview');
        $user->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function updateProfileImage(Request $request)
    {
        
        $user = User::findOrFail($request->get('userId'));
        $image = $request->file('profileImageFile');
        // return $image;  
        // dd($_FILES);
        // return $_FILES;
        // dd( $contents);
            // Make a image name based on user name and current timestamp
            $name = Str::slug($user->firstname).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $file = $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $user->profile_image = $filePath;
            $user->save();
            return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function sendVerificationCode(Request $request){
        // echo $request->get('specialiseCountries');
        // exit();
        $user = User::findOrFail($request->get('userId'));

        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($request->get('phoneVerificationNumber'), "sms");
        $user->phone_verification_number = $request->get('phoneVerificationNumber');
        $user->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function checkVerificationCode(Request $request){
        $user = User::findOrFail($request->get('userId'));
        $verificationCode = $request->get('verificationCode');
        $phoneVerifcationNumber = $request->get('phoneVerificationNumber');

        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($verificationCode, array('to' => $phoneVerifcationNumber));
        if ($verification->valid) {
            $user->phone_verified_at = date('Y-m-d H:i:s');
            $user->save();
            return response(['error'=>false,'success_msg'=>"Success"],200);
        }
        else
            return response(['error'=>true,'error_msg'=>"Don't Match the Digital Code"],404);
    }
}
