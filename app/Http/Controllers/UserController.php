<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Rules\GenerationVali;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\User;
use App\Country;
use App\Tag;
use App\Category;

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
        $flag = 'mypage';
        return view('web.mypage', compact(['user', 'notes', 'flag']));
    }

    public function editMyPage() {
        $max = User::max('generation');
        $user = auth()->user();
        return view('web.mypage_edit', compact(['user','max']));
    }

    public function updateMyPage() {
        $user = auth()->user();
        request()->validate([
            'year' => ['nullable', 'digits:4'],
            'department' => ['required', Rule::in(['経済学部','経営学部','教育学部','都市科学部','理工学部'])],
            'major' => ['required',],// Rule::in(['経済学科','経営学科','教育学科','都市社会共生学科','環境リスク共生学科','建築学科','都市基盤学科','数物・電子情報系学科','化学・生命系学科','機械・材料・海洋系学科'])],
            'generation' => ['required', new GenerationVali],
            'countries' => ['nullable', 'string', 'max:255'],
            'university' => ['nullable', 'string', 'max:255'],
            'isOB' => ['nullable', 'in:1'],
            'job' => ['nullable', 'string', 'max:255'],
            'profile' => ['nullable', 'max:2000'],
        ]);

        if ((request('isOB')) === null) { $isOB = 0; } else { $isOB = 1; }
        $user->year = request('year');
        $user->department = request('department');
        $user->major = request('major');
        $user->generation = request('generation');
        
        if(request('university') !== null)
        {
            $uni_temp = mb_convert_kana(request()->university, 's');
            $unis = preg_split('/[\s,]+/', $uni_temp, -1, PREG_SPLIT_NO_EMPTY);
            $university = '';
            foreach($unis as $u)
            {
                $university .= $u."\n";
            }
            $user->university = $university;
        } else {
            $user->university = request('university');
        }
        $user->isOB = $isOB;
        $user->job = request('job');
        $user->profile = request('profile');
        $user->save();

        $country_ids = getCountryIdsFromRequest(request('countries'));
        $user->countries()->sync($country_ids);
        
        return redirect('/mypage');
    }

    public function uploadAvater() {
        $flag = 'avater';
        return view('web.user.upload_an_image', compact(['flag']));
    }

    public function uploadAvater_confirm(Request $request) {
        $photo = $request->file('file');
        $filename = uniqid('image_').'.'.$photo->guessExtension();
        $image = \Image::make(file_get_contents($photo->getRealPath()));
        if($image->width() >= $image->height())
        {
            $image
                ->orientate()
                ->resize(null, 500, function($constraint)
                    {
                        $constraint->aspectRatio();
                    })
                ->save(public_path().'/storage/img/tmp/'.$filename);
        } else {
            $image
                ->orientate()
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
        $action = $request->get('action', 'back');
        $input = $request->except('action');
        $path = $request->path;
        if($action === 'update')
        {
            $user = auth()->user();
            $filename = 'avater_'.$user->id.'_'.uniqid().'.'.pathinfo($path, PATHINFO_EXTENSION);
            Storage::disk('public')->move($path, '/img/user/'.$filename);
            if(app()->isLocal()) {
                if($user->avater_path !== null)
                {
                    unlink(public_path().$user->avater_path);
                }
                $user->update(['avater_path' => '/storage/img/user/'.$filename]);
            } else {
                if($user->avater_path !== null)
                {
                    unlink(public_path('storage').$user->avater_path);
                }
                $user->update(['avater_path' => '/img/user/'.$filename]);
            }
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
        return view('web.user.upload_an_image', compact(['flag']));
    }

    public function uploadCoverimg_confirm(Request $request) {
        $photo = $request->file('file');
        $filename = uniqid('image_').'.'.$photo->guessExtension();
        $image = \Image::make(file_get_contents($photo->getRealPath()));
        $image
            ->orientate()
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
        $action = $request->get('action', 'back');
        $input = $request->except('action');
        $path = $request->path;
        if($action === 'update')
        {
            $user = auth()->user();
            $filename = 'coverimg_'.$user->id.'_'.uniqid().'.'.pathinfo($path, PATHINFO_EXTENSION);
            Storage::disk('public')->move($path, '/img/user/'.$filename);
            if(app()->isLocal()) {
                if($user->coverimg_path !== null)
                {
                    unlink(public_path().$user->coverimg_path);
                }
                $user->update(['coverimg_path' => '/storage/img/user/'.$filename]);
            } else {
                if($user->coverimg_path !== null)
                {
                    unlink(public_path('storage').$user->coverimg_path);
                }
                $user->update(['coverimg_path' => '/img/user/'.$filename]);
            }
            return redirect('/mypage');
        } else {
            Storage::disk('public')->delete($path);
            return redirect('/mypage/upload_coverimg');
        }
    }
}
