<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['firstname', 'lastname','address','age'];

    public function createPerson($person)
    {
        return $this->create($person);
    }
    
    public function getPersonList(){
        return $this->all();
    }

    public function updatePerson($id,$request){
        $person = $this->find($id);
        if($person){
            $person->update($request);
        }
    }
    public function deletePerson($id){
        $person = $this->find($id);
        if($person){
            $person->delete();
            return true;
        }
        return false;
    }
    public function search($search){
       return $this->where('firstname', 'LIKE', "%$search%")
                   ->orWhere('lastname', 'LIKE', "%$search%")
                   ->orWhere('address', 'LIKE', "%$search%")
                   ->orWhere('age', 'LIKE', "%$search%")
                   ->get();
    }
}
