<?php

namespace App\Http\Controllers;

use App\Mail\DefaultMessaging;
use App\Models\EditorTemplates;
use App\Models\Messaging;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MessagingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'], ['except' => ['showPublic']]);
        
        $this->middleware('permission:create-messaging', ['only' => ['send']]);
        $this->middleware('role:admin', ['only' => ['createTemplate','storeTemplate','updateTemplate']]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function admin()
    {
        $template = null;
        if (isset($_GET['msg']) && $_GET['msg'] !== "") {
            $t = DB::table('messaging')->where('id', $_GET['msg'])->first();
            if ($t)
                $template = $t->message;

        } elseif (isset($_GET['tmp']) && $_GET['tmp'] !== "") {
            $t = DB::table('editor_templates')->where('id', $_GET['tmp'])->first();
            if ($t)
                $template = $t->body;
        }
        return view('messaging.admin', compact('template'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function send(Request $request)
    {
        $rules = [
            'subject' => 'required|max:50|min:5',
            'message'=>'required|min:10'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(empty($request->group) && empty($request->users[0]) && empty($request->email)){
            flash()->error(__("No recipient selected"));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!empty($request->users[0]) && is_array($request->users)) {
            //get all users\
            foreach ($request->users as $user) {
                $u = User::find($user);
                $receiver[] = $user;
                self::sendTo($request, $u,serialize($request->users));
            }

            flash()->success(__("Message has been sent"));
            return redirect()->back();
        }

        if (!empty($request->group)) {
            //get users in the group
            switch ($request->group) {
                case "all":
                    $recipients = "all";
                    $users = User::get();
                    foreach ($users as $u) {
                        self::sendTo($request, $u,$recipients);
                    }

                    flash()->success(__("Message has been sent"));
                    return redirect()->back();
                    break;
                case "admins":
                    $recipients = "admins";
                    $all = User::all();
                    foreach ($all as $u) {
                        if ($u->hasRole('admin')) {
                            self::sendTo($request, $u,$recipients);
                        }
                    }

                    flash()->success(__("Message has been sent"));
                    return redirect()->back();
                    break;
                case "moderators":
                    $recipients = "moderators";
                    $all = User::all();
                    foreach ($all as $u) {
                        if ($u->hasRole('moderator')) {
                            self::sendTo($request, $u,$recipients);
                        }
                    }

                    flash()->success(__("Message has been sent"));
                    return redirect()->back();
                    break;
                case "users":
                    $recipients = "users";
                    $all = User::all();
                    foreach ($all as $u) {
                        if ($u->hasRole('admin')) {
                            self::sendTo($request, $u,$recipients);
                        }
                    }

                    flash()->success(__("Message has been sent"));
                    return redirect()->back();
                    break;
                case "bday-m":
                    $recipients = "users";
                    $month = sprintf("%02d", date('m'));
                    $all = User::where('dob','LIKE',"%-$month-%")->get();
                    foreach ($all as $u) {
                        if ($u->hasRole('admin')) {
                            self::sendTo($request, $u,$recipients);
                        }
                    }

                    flash()->success(__("Message has been sent"));
                    return redirect()->back();
                    break;
                case "bday-d":
                    $recipients = "users";
                    $month = sprintf("%02d", date('m'));
                    $day=sprintf("%02d", date('d'));
                    $all = User::where('dob','LIKE',"%-$month-$day")->get();
                    foreach ($all as $u) {
                        if ($u->hasRole('admin')) {
                            self::sendTo($request, $u,$recipients);
                        }
                    }

                    flash()->success(__("Message has been sent"));
                    return redirect()->back();
                    break;
                default:
                    //special groups
                    if (is_numeric($request->group) && $request->group > 0) {
                        $group = DB::table('messaging_groups')->where('id', $request->group)->first();
                        $recipients = $group->name;
                        foreach (explode(',', $group->users) as $user) {
                            $u = User::find($user);
                            self::sendTo($request, $u,$recipients);
                        }

                        flash()->success(__("Message has been sent"));
                        return redirect()->back();

                    } else {
                        flash()->error(__("No user found matching that criteria"));
                        return redirect()->back();
                    }
                    break;
            }
        }

        flash()->error(__("There was an error sending message"));
        return redirect()->back();
    }

    /**
     * queue messages
     * todo set automatic jobs
     * @param $request
     * @param $user
     * @return bool
     */
    function sendTo($request, $user,$recipients)
    {
        if($user==null)
        {
            flash()->error(__("User selected is invalid"));
            return redirect()->back();
        }

        $data = array(
            'email' => $user->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'user' => $user->first_name
        );

        Mail::to($user)->queue(new DefaultMessaging($data));

        //log in db
        $msg = new Messaging();
        $msg->sender = Auth::user()->id;
        $msg->subject = $request->subject;
        $msg->message = $request->message;
        $msg->receipients = $recipients;
        $msg->created_at = date('Y-m-d H:i:s');
        $msg->save();

        return true;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function history()
    {
        $messages = Messaging::simplePaginate(25);
        return view('messaging.history', compact('messages'));
    }

    /**
     * delete message history
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroy($id)
    {
        $msg = DB::table('messaging')->where('id', $id)->delete();
        flash()->success(__("Message deleted"));
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function msgGroups($id = null)
    {
        $groups = DB::table('messaging_groups')->get();
        $group = array();
        if ($id !== null)
            $group = DB::table('messaging_groups')->where('id', $id)->first();
        return view('messaging.mailgroups', compact('groups', 'group'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function msgGroupsStore(Request $request)
    {
        $rules = [
            'name' => 'required|max:50',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = array(
            'name' => $request->name,
            'desc' => $request->desc,
            'active' => $request->active,
            'created_at' => date('Y-m-d H:i:s')
        );
        DB::table('messaging_groups')->insert($data);
        flash()->success(__("Group saved"));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function msgGroupsUpdate(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:50',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (is_array($request->users)) {
            $users = implode(',', $request->users);
        } else {
            $users = $request->users;
        }
        $data = array(
            'name' => $request->name,
            'users' => $users,
            'desc' => $request->desc,
            'active' => $request->active,
            'created_at' => date('Y-m-d H:i:s')
        );
        DB::table('messaging_groups')->whereId($id)->update($data);

        flash()->success(__("Group saved"));
        return redirect()->back();
    }

    //TEMPLATES
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function templates(){
        $templates= EditorTemplates::simplePaginate(25);
        return view('messaging.templates.index',compact('templates'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function createTemplate(){
        return view('messaging.templates.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function storeTemplate(Request $request){
        $rules = [
            'name' => 'required|max:50',
            'desc'=>'required',
            'body'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $temp= new EditorTemplates();
        $temp->name=$request->name;
        $temp->desc=$request->desc;
        $temp->body=preg_replace('/\r?\n|\r/','',$request->body);
        $temp->active=$request->active;
        $temp->save();
        flash()->success(__("Template created"));
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function editTemplate($id){
        $template=EditorTemplates::findOrFail($id);
        return view('messaging.templates.create',compact('template'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateTemplate(Request $request,$id){
        $rules = [
            'name' => 'required|max:50',
            'desc'=>'required',
            'body'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $temp=EditorTemplates::find($id);
        $temp->name=$request->name;
        $temp->desc=$request->desc;
        $temp->body=preg_replace('/\r?\n|\r/','',$request->body);
        $temp->active=$request->active;
        $temp->save();
        flash()->success(__("Template updated"));
        return redirect()->back();

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function destroyTemplate($id){
        $temp=EditorTemplates::find($id);
        $temp->delete();
        flash()->success(__("Template updated"));
        return redirect()->back();
    }
}
