<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class FormController extends Controller
{
    public function students()
    {
        // $student = Student::with('score')->get();
        $student = new Student;
        $student = $student->get();
        return response()->json([
            'message' => 'succsess',
            'data' => $student
        ],200);
    }

    public function student($id)
    {
        $student = Student::with('score')->where('id',$id)->first();
        if($student != null){
            return response()->json([
                'message' => 'Succses',
                'data' => $student
            ],200);
        }else{
            return response()->json([
                'message' => 'Data Not Found !',
                'data' => $student
            ],404);
        }   
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'nim' => 'required|digits:8|numeric',
            'jurusan' => 'required'
        ]);
        
        $student = new Student;
        $student->nama = $request->nama;
        $student->nim = $request->nim;
        $student->jurusan = $request->jurusan;
        $student->save();

        return response()->json([
            'message' => 'Data Berhasil Disimpan',
            'data' => $student
        ],200);
    }

    public function getUpdate($id)
    {
        $student = Student::find($id);
        if($student != null){
            return response()->json([
                'message' => 'Succses',
                'data' => $student
            ],200);
        }else{
            return response()->json([
                'message' => 'Data Not Found !',
                'data' => $student
            ],404);
        } 
    }

    public function update(Request $request,$id)
    {
        $student = Student::find($id);

        $request->validate([
            'nama' => 'required|min:5',
            'nim' => 'required|digits:8|numeric',
            'jurusan' => 'required'
        ]);

        $student->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan
        ]);

        return response()->json([
            'message' => 'Succses Update Data',
            'data' => $student
        ],200);
    }

    public function delete($id)
    {
        $student = Student::find($id);
        if($student != null){
            Student::find($id)->delete();
            return response()->json([
                'data' => $student,
                'message' => 'Data Berhasil Di Hapus'
            ],200);
        }else{
            return response()->json([
                'message' => 'Data Not Found'
            ],404);
        }
    }
}
