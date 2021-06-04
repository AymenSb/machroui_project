<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:gestion des utilisateurs|crées utilisateur|modifier utilisateur|supprimer utilisateur', ['only' => ['index', 'show']]);
        $this->middleware('permission:crées utilisateur', ['only' => ['create', 'store']]);
        $this->middleware('permission:modifier utilisateur', ['only' => ['edit', 'update']]);
        $this->middleware('permission:supprimer utilisateur', ['only' => ['destroy']]);
    }
/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(10);
        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }
/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required',
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles_name'));
        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }
/**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function show($id)
    {
// $user = User::find($id);
// return view('users.show',compact('user'));

        return back();
    }
/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }
/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles_name' => 'required',
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles_name'));
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }
/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function destroy(Request $request)
    {$id = $request->user_id;
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }


    //API for users update
    protected function updateUserInfo(Request $request,$id){
        $user=User::findOrfail($id);
        //update one by one info for user

        if($request->name!=''){
            $validator=Validator::make($request->all(),[
                'name'=>'string|between:3,100',
            ],
            [
                'name.between'=>'Le nom est trop court',
            ]
        );
         if($validator->fails()){
            return response()->json($validator->errors());
        }
            $user->update([
                'name'=>$request->name,
            ]);
        }


        if($request->surname!=''){
            $validator=Validator::make($request->all(),[
                'surname'=>'string|between:3,100',
            ],
            [
                'surname.between'=>'Le Prénom est trop court',
            ]
        );
         if($validator->fails()){
            return response()->json($validator->errors());
        }
            $user->update([
                'surname'=>$request->surname,
            ]);
        }


        if($request->email!=''){
            $validator=Validator::make($request->all(),[
                'email'=>'unique:users|email',
            ],
            [
                'email.unique'=>'Cet E-mail existe déjà',
                'email.email'=>'Vérifier votre E-mail',
            ]
        );
         if($validator->fails()){
            return response()->json($validator->errors());
        }
            $user->update([
                'email'=>$request->email,
            ]);
        }



        if($request->phone_number!=''){
            $validator=Validator::make($request->all(),[
                'phone_number'=>'unique:users|integer|digits:8',
            ],
            [
                'phone_number.digits'=>'Vérifiez votre numéro de téléphone',
                'phone_number.integer'=>'Vérifiez votre numéro de téléphone',
                'phone_number.unique'=>'Ce numéro de téléphone déjà utilisé',
            ]
        );
         if($validator->fails()){
            return response()->json($validator->errors());
        }

            $user->update([
                
                'phone_number'=>$request->phone_number,
            ]);
        }

        if($request->newpassword && $request->oldpassword){
        
            $hashedpassword=$user->password;
            if(Hash::check($request->oldpassword,$hashedpassword)){
                if(!Hash::check($request->newpassword,$hashedpassword)){
                    $user->update([
                        'password'=>Hash::make($request->newpassword),
                    ]);
                }

                else{
                    return response()->json([
                        'error'=>'Nouveau mot de passe doit être différent'
                    ]);
                }
            }

            else{
                return response()->json([
                    'error'=>'Vérifier votre mot de passe'
                ]);
            }
        }
                
       //return user info with success message

        return response()->json([
            'message' => 'vos informations ont été mises à jour',
            'user' => $user
        ], 201);
    }

}
