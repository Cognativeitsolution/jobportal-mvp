<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\Industry;
use App\Models\NumberOfEmployees;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller {
    public function profile() {
        $pageTitle         = "Employer Profile Update";
        $industries        = Industry::active()->get();
        $numberOfEmployees = NumberOfEmployees::active()->get();
        $employer          = authUser('employer');
        return view('Template::employer.profile_setting', compact('pageTitle', 'employer', 'industries', 'numberOfEmployees'));
    }

    public function submitProfile(Request $request) {
        $request->validate([
            'company_name'        => 'required|string|max:40',
            'slug'                => 'required|string|max:255',
            'ceo_name'            => 'required|string|max:40',
            'website'             => 'required|url',
            'fax'                 => 'nullable',
            'industry'            => 'required|integer|exists:industries,id',
            'number_of_employees' => 'required|integer|gte:0',
            'address'             => 'required|string',
            'social_media'        => 'nullable|array',
            'social_media.*.'     => 'nullable|url',
            'description'         => 'required',
            'founding_date'       => 'required',
            'image'               => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $employer = authUser('employer');

        $slug  = slug($request->slug);
        $exist = Employer::where('slug', $slug)->first();
        if (($exist) && $exist->slug != $employer->slug) {
            $notify[] = ['error', 'Slug must be unique'];
            return back()->withNotify($notify);
        }

        if ($request->hasFile('image')) {
            try {
                $old             = $employer->image;
                $employer->image = fileUploader($request->image, getFilePath('employer'), getFileSize('employer'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $employer->company_name           = $request->company_name;
        $employer->slug                   = $request->slug;
        $employer->ceo_name               = $request->ceo_name;
        $employer->website                = $request->website;
        $employer->fax                    = $request->fax;
        $employer->industry_id            = $request->industry;
        $employer->number_of_employees_id = $request->number_of_employees;
        $employer->address                = $request->address ?? null;
        $employer->city                   = $request->city ?? null;
        $employer->state                  = $request->state ?? null;
        $employer->zip                    = $request->zip ?? null;
        $employer->map                    = $request->map ?? null;
        $employer->social_media           = $request->social_media ?? null;
        $employer->description            = $request->description;
        $employer->founding_date          = Carbon::parse($request->founding_date);
        $employer->save();

        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function checkSlug($id = null) {
        $page = Employer::where('slug', request()->slug);
        if ($id) {
            $page = $page->where('id', '!=', $id);
        }
        $exist = $page->exists();
        return response()->json([
            'exists' => $exist,
        ]);
    }

    public function changePassword() {
        $pageTitle = 'Change Password';
        return view('Template::employer.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request) {
        $passwordValidation = Password::min(6);
        $general            = gs();
        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', $passwordValidation],
        ]);

        $user = authUser('employer');
        if (Hash::check($request->current_password, $user->password)) {
            $password       = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changed successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }

    public function updateImage(Request $request) {
        $validator = Validator::make($request->all(), [
            'profile_image' => ['required', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all(),
            ]);
        }
        $employer = auth()->guard('employer')->user();
        try {
            $employer->image = fileUploader($request->profile_image, getFilePath('employer'), null, $employer->image);
            $employer->save();

            return response()->json([
                'success'    => true,
                'message'    => 'Profile image updated successfully',
                'image_name' => $employer->image,
            ]);
        } catch (\Exception $exp) {

            return response()->json([
                'success' => false,
                'message' => "Couldn\'t upload your image",
            ]);
        }
    }
}
