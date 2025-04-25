<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query  =  $request->get('query');
        if($request->ajax()){
            $data = User::query()->where('name', 'LIKE', $query . '%')
                ->limit(10)
                ->get();
            $output = '';
            $loop = 0;
            if (count($data) > 0){
                foreach ($data as $row){
                    $output .= '
                                    <tr>
                                        <td>' . $loop+1 . '</td>
                                        <td>' . $row->name . '</td>
                                        <td>' . $row->username . '</td>
                                        <td>' . $row->email . '</td>
                                        <td>' . $row->employee_id . '</td>
                                        <td>' . $row->department_name . '</td>
                                        <td>' . $row->roles . '</td>
                                        <td>' . $row->mobile . '</td>
                                        <td class="d-flex justify-content-center">
                                            <a class="btn btn-success me-1" href="' . route('userManagements.show', $row->id) . '">Show</a>';
                                        if (auth()->user()->roles == 'admin') {
                                            $output .= '
                                        <a class="btn btn-primary me-1" href="' . route('userManagements.edit', $row->id) . '">Edit</a>
                                        <form action="' . route('userManagements.destroy', $row->id) . '" method="post">
                                            ' . csrf_field() . '
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger me-1">Delete</button>
                                        </form>';
                                        }
                    $loop+=1;
                }
            }else{
                $output .= '<td colspan="9">
                            <div class="d-flex justify-content-center">
                                No Record Found
                            </div>
                        </td>';
            }
            return $output;
        }


        $users = User::query()->where('name', 'LIKE', '%' . $query . '%')
            ->simplePaginate(8);
        return view('userManagements.index', compact('users'));
    }

    public function create()
    {
        $organizations = Organization::all();

        return view('userManagements.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'email' => 'required|email|unique:users',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // other validation rules...
        ]);
        
        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'employee_id' => $request->employee_id,
            'department_name' => $request->department_name,
            'organization_id' => $request->organization_id,
            'roles' => $request->roles,
            'mobile' => $request->mobile,
        ];
        
        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profiles', 'public');
            $userData['profile_picture'] = $imagePath;
        }
        
        $user = User::create($userData);
        
        return redirect()->route('userManagements.index')
            ->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('userManagements.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $organizations = Organization::all();
        
        return view('userManagements.edit', compact('user', 'organizations'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // other validation rules...
        ]);
        
        // Update basic information
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->employee_id = $request->employee_id;
        $user->department_name = $request->department_name;
        $user->organization_id = $request->organization_id;
            $user->roles = $request->roles;
        $user->mobile = $request->mobile;
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $imagePath = $request->file('profile_picture')->store('profiles', 'public');
            $user->profile_picture = $imagePath;
        }

        $user->save();

        return redirect()->route('userManagements.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $oldPicture = $user->profile_picture;
        if ($oldPicture && file_exists(storage_path('app/public/') . $oldPicture)) {
            unlink(storage_path('app/public/') . $oldPicture);
        }
        $user->delete();

        return redirect()->route('userManagements.index')
            ->with('success', 'User has been deleted');
    }

    public function getDepartments(Organization $organization)
    {
        return response()->json($organization->departments);
    }
}
