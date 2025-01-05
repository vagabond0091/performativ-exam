<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    protected $personModel;

    function __construct()
    {
        $this->personModel = new Person();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->personModel->getPersonList();
        return response()->json([
            'data'=>$data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstname' => 'string',
            'lastname'  => 'string',
            'address'   => 'string',
            'age'       => 'numeric'
        ]);
        if($validator->fails()){
            return response()->json(['error',$validator->errors()], 422);
        }
        $this->personModel->createPerson([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'address'   => $request->address,
            'age'       => $request->age
        ]);

        return response()->json([
            'message' => 'Person Added'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'firstname' => 'string',
            'lastname'  => 'string',
            'address'   => 'string',
            'age'       => 'numeric'
        ]);
        if($validator->fails()){
            return response()->json(['error',$validator->errors()], 422);
        }
        $updatedPerson = $this->personModel->updatePerson($id, $request->all());

        return response()->json([
            'message' => 'Data Successfully Updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isDeleted = $this->personModel->deletePerson($id);
        if($isDeleted){
            return response()->json([
                'message' => 'Data Deleted Successfully '
            ], 200);
        }
        return response()->json([
            'message' => 'Unable to delete'
        ], 200);
    }
    public function search(string $search){
        $data = $this->personModel->search($search);
        return response()->json([
            'data'=>$data
        ]);
    }
}
