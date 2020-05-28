<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Twilio\Rest\Client;

class StudentController extends Controller
{
    use \App\Traits\UploadTrait;
    //
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
        $student = Student::create([
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

        $token = JWTAuth::fromUser($student);

        return response()->json(compact('student', 'token'), 201);
    }
    public function getAuthenticatedStudents()
    {
        try {

            if (!$student = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['student_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('student'));
    }
    public function updateVisaType(Request $request){
        // echo $request->get('specialiseCountries');
        // exit();
        $student = Student::findOrFail($request->get('userId'));
        $student->study_countries = $request->get('studyCountries');
        $student->visa_type = $request->get('visaType');
        $student->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function updateTravelHistory(Request $request){
        // echo $request->get('specialiseCountries');
        // exit();
        $student = Student::findOrFail($request->get('userId'));
        $student->is_travelled_country = $request->get('isTravelledCountry');
        $student->travelled_country_detail = $request->get('travelledCountryDetail');
        $student->is_refused_country = $request->get('isRefusedCountry');
        $student->refused_country_detail = $request->get('refusedCountryDetail');
        $student->is_deported_country = $request->get('isDeportedCountry');
        $student->deported_country_detail = $request->get('deportedCountryDetail');
        $student->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function updateFunding(Request $request){
        $student = Student::findOrFail($request->get('userId'));
        $student->personal_circumstances = $request->get('personalCircumstances');
        $student->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function updateProposedStudy(Request $request){
        $student = Student::findOrFail($request->get('userId'));
        $student->sponsoring_education = $request->get('sponsoringEducation');
        $student->is_received_admission = $request->get('isReceivedAdmission');
        $student->received_admission_detail = $request->get('receivedAdmissionDetail');
        $student->study_course = $request->get('studyCourse');
        $student->is_excluding_tuition = $request->get('isExcludingTuition');
        $student->excluding_tuition_detail = $request->get('excludingTuitionDetail');
        $student->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function updateLocation(Request $request){
        $student = Student::findOrFail($request->get('userId'));
        $student->address = $request->get('address');
        $student->state = $request->get('state');
       
        $student->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
    public function updateProfileImage(Request $request)
    {
        
        $student = Student::findOrFail($request->get('userId'));
        $image = $request->file('profileImageFile');

        $name = Str::slug($student->firstname).'_'.time();
        // Define folder path
        $folder = '/uploads/images/';
        // Make a file path where image will be stored [ folder path + file name + file extension]
        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
        // Upload image
        $file = $this->uploadOne($image, $folder, 'public', $name);
        // Set user profile image path in database to filePath
        $student->profile_image = $filePath;
        $student->save();
        return response(['error'=>false,'success_msg'=>"Success"],200);
    }
}
