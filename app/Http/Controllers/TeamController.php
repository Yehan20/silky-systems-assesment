<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = request()->user();
        $teams = $user->teams; 
        return response()->json($teams);
    }

    public function getAll(){
                 
        $teams = Team::all();
        return response()->json($teams);
    }

    public function create() {
         return view('teams.create');
    }

    // New API to fetch all users
    public function getAllUsers()
    {
        return response()->json(User::where('role_id',Role::IS_MEMBER)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            // Manually validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:teams,name',  // Validate team name
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return validation errors along with a 422 status code
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Proceed with team creation if validation passes
        try {
            // Create a new team using the validated data
            $team = Team::create(['name' => $request->name]);

            // Return the newly created team with a 201 status code
            return response()->json($team, 201);  
        } catch (\Exception $e) {
            // Return custom error message in case of an exception
            return response()->json(['error' => 'Failed to create team'], 500);
        }
    }

    public function getUsers($teamId)
     {
           
            $team = Team::findOrFail($teamId);

    
            $users = $team->users; 

            return response()->json($users);
     }

    public function addUser(Request $request, $id)
    {

        $team = Team::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Check if the user is already in the team
        if ($team->users()->where('user_id', $request->user_id)->exists()) {
            return response()->json(['errors' => ['user_id' => ['This user is already in the team.']]], 422);
        }
    

        $team->users()->attach($request->user_id);
    
        return response()->json(['message' => 'User added to the team']);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $team = Team::findOrFail($id);

        return  view('teams.add-user',compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
