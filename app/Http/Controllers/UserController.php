<?php

namespace App\Http\Controllers;

use App\Mail\MailOTP;
use App\Mail\MyEmail;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login()
    {
        return view("login");
    }
    public function checkLogin(Request $request)
    {
        // Giả sử bạn đã xác thực người dùng và lấy được $user
        $user = User::where("email", $request->email)->first();
        if ($user && $user->role != "admin") {
            return redirect('/login')->with('message', 'Bạn không có quyền');
        }
        if ($user && Hash::check($request->password, $user->password)) {
            // Lưu user_id vào session
            $request->session()->put('userLogin', $user);
            // Redirect người dùng đến trang chủ
            $OTPCode = Str::upper(Str::random(6));
            Mail::to($user->email)->send(new MailOTP($OTPCode));
            $user->update([
                "otp" => $OTPCode
            ]);
            return redirect('/otp');
        }
        // Xử lý khi thông tin đăng nhập không đúng
        return redirect('/login')->with('message', 'Tên đăng nhập hoặc mật khẩu không đúng');
    }
    public function viewOTP()
    {
        $userInfo = Session::get('userLogin');
        if ($userInfo) {
            return view("otp");
        } else {
            return redirect('/login')->with('message', 'Chưa xác thực bước 1 login');
        }

    }
    public function checkOTP(Request $request)
    {
        $userInfo = Session::get('userLogin');
        if ($userInfo) {
            if ($request->otp == $userInfo->otp) {
                $request->session()->put('userConfirmOTP', $userInfo);
                return redirect('/admin');
            }
            return redirect('/otp')->with('message', 'Mã OTP không hợp lệ');
        } else {
            return redirect('/login')->with('message', 'Chưa xác thực bước 1 login');
        }
    }
    public function logout()
    {
        // Xóa thông tin người dùng khỏi session
        session()->forget('userLogin');
        session()->forget('userConfirmOTP');
        return redirect('/login')->with('message', 'Đăng xuất thành công!');
    }
    public function index(Request $request)
    {
        //join thu cong
        // $users = DB::table('users')
        //     ->join('courses', 'users.course_id', '=', 'courses.id')
        //     ->select('users.*', 'courses.name as courses_name')
        //     ->get();
        //join voi Eloquent ORM 
        $users = User::with('courses')->get();
        $courses = Course::all();
        $search = $request->search;
        if ($search != "") {
            $users = $users->where('class', $search);
        }
        return view('admins.user.index', compact('users', 'courses'));
    }

    public function addUserCourse(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2|max:40',
                'phone' => 'required|regex:/^[0-9]{10,15}$/',
                'email' => 'required|email'
            ]);
            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->toArray() as $field => $messages) {
                    foreach ($messages as $message) {
                        $errors[] = [
                            'field' => $field,
                            'message' => $message,
                        ];
                    }
                }
                // dd($errors);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $errors,
                ], 400);
            }
            $adminEmailExisting = User::where("role", "admin")->first();
            if ($adminEmailExisting->email == $request->email) {
                $errors[] = [
                    'field' => "email",
                    'message' => "Opp email đã tồn tại",
                ];
                return response()->json([
                    'status' => 'error',
                    'message' => 'Opp email đã tồn tại',
                    'errors' => $errors
                ], 400);
            }
            $toMail = $request->email;
            $courseId = $request->course_id;
            $course = Course::find($courseId);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => "user",
                'password' => Hash::make("netgencode"),
                'phone' => $request->phone,
                'course_id' => $request->course_id,
                'class' => $request->class,
                'status' => $request->status
            ]);
            Mail::to($toMail)->send(new MyEmail($course));
            // Nếu mọi thứ đều ổn, commit giao dịch
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'user created successfully',
                'data' => $user,
            ], 201);
        } catch (\Exception $ex) {

            DB::rollBack();
            dd($ex);
        }
    }
    public function create()
    {
        $courses = Course::all();
        return view("admins.user.create", compact('courses'));
    }
    public function register(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'regex:/^[0-9]{10,15}$/'
        ]);

        $course = Course::find($request->course_id);
        $class = null;
        if ($course != null) {
            $class = $course->class;
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => "user",
            'password' => Hash::make("netgencode"),
            'phone' => $request->phone,
            'course_id' => $request->course_id,
            'class' => $class
        ]);

        // Redirect to login page
        return redirect()->route('admin.user.index')->with('success', 'User registered successfully');
    }
    public function viewPassAdmin()
    {
        return view('change_pas');
    }
    public function changePassAdmin(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => "required|email",
            'password' => 'required',
            'newpassword' => 'required|confirmed|min:8',

        ]);
        try {
            $user = User::where("email", $request->email)->first();
            if (!$user) {
                return redirect()->back()->withInput()->with('message', 'Email không tồn tại');
            }
            if (Hash::check($request->password, $user->password)) {
                $user->update([
                    "password" => Hash::make("$request->newpassword")
                ]);
                return redirect()->route("admin.user.index")->with('message', 'Change password successfully');
            }
            return redirect()->back()->withInput()->with('message', 'Current Password không đúng');
        } catch (\Throwable $th) {
            return redirect()->route("admin.user.index")->with('message', 'Opp something went wrong');
        }
    }
    public function edit($id)
    {
        $user = User::find($id);
        $courses = Course::all();
        return view("admins.user.edit", compact('user', 'courses'));
    }
    public function update(Request $request, User $user)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'regex:/^[0-9]{10,15}$/'
        ]);

        $course = Course::find($request->course_id);
        $class = null;
        if ($course != null) {
            $class = $course->class;
        }
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'course_id' => $request->course_id,
            'class' => $class
        ]);

        // Redirect to login page
        return redirect()->route('admin.user.index')->with('success', 'User registered successfully');
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'delete user successfully');
    }
    public function activeUser($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            "status" => !($user->status)
        ]);
        return redirect()->route('admin.user.index')->with('success', 'Change status successfully');
    }
    public function payUser($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            "status" => !($user->status)
        ]);
        $courseId = Session::get('courseId');
        return redirect()->route("admin.course.detail", $courseId);
        // return redirect()->route('admin.user.index')->with('success', 'Change status successfully');
    }
}
