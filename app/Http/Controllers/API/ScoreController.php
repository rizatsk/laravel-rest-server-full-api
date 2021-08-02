<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Score;
use App\Models\Student;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
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
        
        foreach($request->list_nilai as $nilai => $value){
            $score = array(
                'student_id' => $student->id,
                'mata_pelajaran' => $value['mata_pelajaran'],
                'nilai' => $value['nilai']
            );
            $score = Score::create($score);
        }

        return response()->json([
            'message' => 'success',
            'data_student' => $student,
            'nilai_student'=> $score
        ],200);  
    }

    public function getUpdate($id)
    {
        $student = Student::with('score')->where('id',$id)->first();
        return response()->json([
            'message' => 'success',
            'data_student' => $student
        ],200);  
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'nim' => 'required|digits:8|numeric',
            'jurusan' => 'required'
        ]);
        
        $student = Student::find($id);
        $student->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan
        ]);
        
        Score::where('student_id',$id)->delete();

        foreach($request->list_nilai as $nilai => $value){
            $score = array(
                'student_id' => $id,
                'mata_pelajaran' => $value['mata_pelajaran'],
                'nilai' => $value['nilai']
            );
            $score = Score::create($score);
        }

        return response()->json([
            'message' => 'success',
            'data_student' => $student,
            'nilai_student'=> $score
        ],200);  
        
    }
}
