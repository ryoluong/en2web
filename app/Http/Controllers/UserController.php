<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Rules\GenerationVali;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Mail\SupportFormMessage;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Country;
use App\Tag;
use App\Category;
use App\Facades\Slack;

class UserController extends Controller
{
    public function showHome () {
        $user = auth()->user();
        if(isset($user->countries()->first()->name)) {
            $user_country = $user->countries()->first()->name;
        } else {
            $user_country = "noCountry";
        }
        return view('web.home', compact(['user', 'user_country']));
    }

    public function showMyPage() {
        $user = auth()->user();
        $notes = $user->notes()->orderBy('date', 'desc')->take(6)->get();
        $favNotes = $user->favNotes()->orderBy('date', 'desc')->take(6)->get();
        $flag = 'mypage';
        $user->university = $user->getEscapedStringWithBr();
        $user->profile = $user->getEscapedProfileWithHeader();
        return view('web.mypage', compact(['user', 'notes', 'favNotes', 'flag']));
    }

    public function editMyPage() {
        $user = auth()->user();
        return view('web.mypage_edit', compact(['user']));
    }

    public function updateMyPage() {
        $user = auth()->user();
        request()->validate([
            'countries' => ['nullable', 'string', 'max:255'],
            'university' => ['nullable', 'string', 'max:255'],
            'isOB' => ['nullable', 'in:1'],
            'isOverseas' => ['nullable', 'in:1'],
            'job' => ['nullable', 'string', 'max:255'],
            'profile' => ['nullable', 'max:2000'],
        ]);
        $user->university = request('university');
        $user->isOB = request('isOB', 0);
        $user->isOverseas = request('isOverseas', 0);
        $user->job = request('job');
        $user->profile = request('profile');
        $user->save();

        $country_ids = getCountryIdsFromRequest(request('countries'));
        $user->countries()->sync($country_ids);
        
        return redirect('/mypage');
    }

    public function uploadAvater() {
        $flag = 'avater';
        return view('web.user.upload_image', compact(['flag']));
    }

    public function uploadAvater_confirm(Request $request) {
        $photo = $request->file('file');
        $filename = uniqid('image_').'.'.$photo->guessExtension();
        $image = \Image::make(file_get_contents($photo->getRealPath()));
        $image = getOrientatedImage($image, $photo);
        if($image->width() >= $image->height()) {
            $image
                ->resize(null, 500, function($constraint)
                    {
                        $constraint->aspectRatio();
                    })
                ->save(public_path().'/storage/img/tmp/'.$filename);
        } else {
            $image
                ->resize(500, null, function($constraint)
                    {
                        $constraint->aspectRatio();
                    })
                ->save(public_path().'/storage/img/tmp/'.$filename);
        }
        $path = '/img/tmp/'.$filename;

        return view('web.avater_upload_confirm', compact(['path']));
    }

    public function uploadAvater_save(Request $request) 
    {
        $action = $request->get('action', 'update');
        $input = $request->except('action');
        $path = $request->path;
        if($action == 'update')
        {
            $user = auth()->user();
            $filename = 'avater_'.$user->id.'_'.uniqid().'.'.pathinfo($path, PATHINFO_EXTENSION);
            Storage::disk('public')->move($path, '/img/user/'.$filename);
            if($user->avater_path !== null)
            {
                unlink(public_path('storage').$user->avater_path);
            }
            $user->update(['avater_path' => '/img/user/'.$filename]);
            return redirect('/mypage');
        } else {
            Storage::disk('public')->delete($path);
            return redirect('/mypage/upload_avater');
        }
    }

    /**
     * 
     * Upload Cover Image
     * 
     */
    public function uploadCoverimg() {
        $flag = 'coverimg';
        return view('web.user.upload_image', compact(['flag']));
    }

    public function uploadCoverimg_confirm(Request $request) {
        $photo = $request->file('file');
        $filename = uniqid('image_').'.'.$photo->guessExtension();
        $image = \Image::make(file_get_contents($photo->getRealPath()));
        $image = getOrientatedImage($image, $photo);
        $image
            ->resize(null, 900, function($constraint)
                {
                    $constraint->aspectRatio();
                })
            ->save(public_path().'/storage/img/tmp/'.$filename);
        $path = '/img/tmp/'.$filename;
        return view('web.user.upload_coverimg_confirm', compact(['path']));
    }

    public function uploadCoverimg_save(Request $request) 
    {
        $action = $request->get('action', 'update');
        $input = $request->except('action');
        $path = $request->path;
        if($action === 'update')
        {
            $user = auth()->user();
            $filename = 'coverimg_'.$user->id.'_'.uniqid().'.'.pathinfo($path, PATHINFO_EXTENSION);
            Storage::disk('public')->move($path, '/img/user/'.$filename);
            if($user->coverimg_path !== null)
            {
                unlink(public_path('storage').$user->coverimg_path);
            }
            $user->update(['coverimg_path' => '/img/user/'.$filename]);
            return redirect('/mypage');
        } else {
            Storage::disk('public')->delete($path);
            return redirect('/mypage/upload_coverimg');
        }
    }

    public function support()
    {
        return view('web.support.form');
    }

    public function sendMail()
    {
        request()->validate([
            'message' => ['required', 'string', 'max:2000']
        ]);
        $email = new SupportFormMessage(request('message'));
        Mail::to('admin@en2ynu.com')->send($email);
        Slack::notice("問い合わせフォームにメッセージがありました：\n".request('message'));
        return view('web.support.sent');
    }
}
