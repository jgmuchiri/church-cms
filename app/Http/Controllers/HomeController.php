<?php

namespace App\Http\Controllers;

use App\Models\Blog\Blog;
use App\Models\Events;
use App\Models\Ministry\Ministry;
use App\Models\Slides;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        $ministries = Ministry::whereActive(1)->limit(10)->get();
        $blogs =Blog::whereStatus('published')->limit(10)->get();
        $events = Events::whereStatus('active')->limit(10)->get();
        $churchSchedule =Events::churchSchedule();
        $slides = Slides::whereActive(1)->get();
        return view("home.index",compact('ministries','blogs','events','churchSchedule','slides'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function contact()
    {
        return view('home.contact');
    }

    /**
     * from contact form
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function sendMessage(Request $request)
    {
        $rules = [
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'subject' => 'required|max:50',
            'message' => 'required|max:50'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Mail::send('emails.general', ['subject' => $request->subject, 'msg' => $request->message], function ($m) use ($request) {
            $m->from($request->email, $request->name);
            $m->to(config('email.from.address'), config('email.from.name'))->subject($request->subject);
        });

        flash()->success('Thank you! We will get back with you shortly.');
        return redirect()->back();
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function giving(){
        if(Auth::check())
            return redirect('account');
        return view('home.giving');
    }
}
