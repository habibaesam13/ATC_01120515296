<?php

namespace App\Http\Controllers\system;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    protected  $userService;
    public function __construct(UserService $userService){
        $this->userService=$userService;
    }
    public function create()
    {
        return view("Admin.users.create");
    }
    public function show($id)
    {
        // Call the service to get user and tickets grouped by event
        $data = $this->userService->show($id);
        
        if (!$data) {
            return redirect()->route('admin.dashboard')->with('error', 'User not found');
        }

        return view('Admin.users.show', compact('data'));
    }
    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);
        
        $result=$this->userService->store($data);
        return $result === 1
        ? redirect()->route('admin.dashboard')->with('success', "User added successfully")
        : back()->with('error', "User already exists with this email address.");
    }
    public function edit($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return redirect()->route("admin.dashboard")->with("error", "User not found");
        }
    
        return view("Admin.users.edit", compact('user'));
    }
    
    public function update(Request $request,$id){
        $data=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => [
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);
        $result=$this->userService->update($data,$id);
        if ($result===1){
        return redirect()->route('admin.dashboard')->with('success', "User added successfully");
        }
        return back()->with('error', "Invalid Submitted Data.");
    }
    public function destroy($id){
        $result=$this->userService->destroy($id);
        if ($result===1) return redirect()->route('admin.dashboard')->with('success', "User deleted successfully");
        return back()->with('error', "User not found");
    }
}
