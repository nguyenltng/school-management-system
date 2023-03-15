<?php

namespace App\Http\Controllers\Backend;

use App\Mark;
use App\User;
use App\IClass;
use App\Section;
use App\Student;
use App\Subject;
use App\UserRole;
use Carbon\Carbon;
use App\AcademicYear;
use App\Registration;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Exports\StudentExport;
use App\Http\Helpers\AppHelper;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stage = AppHelper::STUDENT_STAGE['LEAD'];
        $status = $request->get('status');

        $students = Student::if($status, 'status', '=', $status)
            ->where('stage', $stage)
            ->orderBy('id', 'asc')
            ->get();

        //if section is mention then full this class section list
        return view('backend.lead.list', compact('students', 'status', 'stage'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = IClass::where('status', AppHelper::ACTIVE)
            ->orderBy('order', 'asc')
            ->pluck('name', 'id');
        $student = null;
        $gender = 0;
        $source = 0;
        $bloodGroup = 0;
        $nationality = '';
        $group = 'None';
        $shift = 'Day';
        $regiInfo = null;
        $sections = [];
        $iclass = null;
        $section = null;
        $acYear = null;
        $esubject = null;
        $csubjects = [];
        $ssubjects = [];
        $electiveSubjects = [];
        $selectiveSubjects = [];
        $coreSubjects = [];
        $academic_years = [];
        $classInfo = null;

        // check for institute type and set gender default value
        $settings = AppHelper::getAppSettings();
        if (isset($settings['institute_type'])) {
            $gender = intval($settings['institute_type']);
            if ($gender == 3) {
                $gender = 0;
            }
        }


        return view('backend.lead.add', compact(
            'regiInfo',
            'student',
            'gender',
            'source',
            'bloodGroup',
            'nationality',
            'classes',
            'sections',
            'group',
            'shift',
            'iclass',
            'section',

        ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //todo: wrong class section entry student bug fixed.
        //validate form
        $rules = [
            'name' => 'required|min:5|max:255',
            'nick_name' => 'nullable|min:2|max:50',
            'photo' => 'mimes:jpeg,jpg,png|max:200|dimensions:min_width=150,min_height=150',
            'dob' => 'min:10|max:10',
            'gender' => 'required|integer',
            'source' => 'nullable|integer',
            'compagin' => 'nullable|integer',
            'nationality' => 'required|max:50',
            'phone_no' => 'nullable|max:15',
            'extra_activity' => 'nullable|max:15',
            'note' => 'nullable|max:500',
            'father_name' => 'nullable|max:255',
            'father_phone_no' => 'nullable|max:15',
            'mother_name' => 'nullable|max:255',
            'mother_phone_no' => 'nullable|max:15',
            'guardian' => 'nullable|max:255',
            'guardian_phone_no' => 'nullable|max:15',
            'present_address' => 'nullable|max:500',
            'permanent_address' => 'required|max:500',
        ];

        $this->validate($request, $rules);
        $data = $request->all();
        $data['stage'] = AppHelper::STUDENT_STAGE['LEAD'];
        DB::beginTransaction();
        try {
            // now save employee
            Student::create($data);
            // now commit the database
            DB::commit();

            //now notify the admins about this record
            $msg = $data['name'] . " Lead added by " . auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end
            return redirect()->route('lead.create')->with('success', 'Lead added!');
        } catch (\Exception $e) {
            DB::rollback();
            $message = str_replace(array("\r", "\n", "'", "`"), ' ', $e->getMessage());
            return redirect()->route('lead.create')->with("error", $message);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //get student
        $student = Student::find($id);
        if (!$student) {
            abort(404);
        }

        $username = '';
        if ($student->user_id) {
            $user = User::find($student->user_id);
            $username = $user->username;
        }


        //find siblings
        if (strlen($student->siblings)) {
            $siblingsRegiNumbers = array_map('trim', explode(',', $student->siblings));
            if (count($siblingsRegiNumbers)) {
                $siblingStudents = Registration::whereIn('regi_no', $siblingsRegiNumbers)
                    ->with(['info' => function ($q) {
                        $q->select('id', 'name');
                    }])
                    ->select('id', 'student_id')
                    ->get()
                    ->reduce(function ($siblingStudents, $record) {
                        $siblingStudents[] = $record->info->name;
                        return $siblingStudents;
                    });

                $student->siblings = $siblingStudents ? implode(',', $siblingStudents) : '';
            }
        }

        return view('backend.lead.view', compact('student', 'username'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regiInfo = true;
        $student =  Student::find($id);
        if (!$student) {
            abort(404);
        }

        $gender = $student->getOriginal('gender');
        $source = $student->getOriginal('source');
        $nationality = ($student->nationality != "Bangladeshi") ? "Other" : "";


        return view('backend.lead.add', compact(
            'regiInfo',
            'student',
            'gender',
            'source',
            'nationality',
        ));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $student =  Student::find($id);
        if (!$student) {
            abort(404);
        }

        $messages = [
            'photo.max' => 'The :attribute size must be under 200kb.',
            'photo.dimensions' => 'The :attribute dimensions min 150 X 150.',
        ];
        $rules = [
            'name' => 'required|min:5|max:255',
            'nick_name' => 'nullable|min:2|max:50',
            'photo' => 'mimes:jpeg,jpg,png|max:200|dimensions:min_width=150,min_height=150',
            'dob' => 'min:10|max:10',
            'gender' => 'required|integer',
            'source' => 'nullable',
            'compaign' => 'nullable',
            'nationality' => 'required|max:50',
            'phone_no' => 'nullable|max:15',
            'extra_activity' => 'nullable|max:15',
            'note' => 'nullable|max:500',
            'father_name' => 'nullable|max:255',
            'father_phone_no' => 'nullable|max:15',
            'mother_name' => 'nullable|max:255',
            'mother_phone_no' => 'nullable|max:15',
            'guardian' => 'nullable|max:255',
            'guardian_phone_no' => 'nullable|max:15',
            'present_address' => 'nullable|max:500',
            'permanent_address' => 'required|max:500',
        ];

        $this->validate($request, $rules);
        $data = $request->all();

        DB::beginTransaction();
        try {

            $messageType = "success";
            $message = "Lead updated!";

            // now save student
            $student->fill($data);
            if (($student->isDirty('email') || $student->isDirty('phone_no'))
                && ($student->user_id || isset($data['user_id']))
            ) {
                $userId = $data['user_id'] ?? $student->user_id;
                $user = User::where('id', $userId)->first();
                $user->email = $data['email'];
                $user->phone_no = $data['phone_no'];
                $user->save();
            }
            $student->save();

            // now commit the database
            DB::commit();


            return redirect()->route('lead.index')->with($messageType, $message);
        } catch (\Exception $e) {
            DB::rollback();
            $message = str_replace(array("\r", "\n", "'", "`"), ' ', $e->getMessage());
            //            dd($message);
        }

        return redirect()->route('lead.edit', $student->id)->with("error", $message);;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            abort(404);
        }
        $message = 'Something went wrong!';
        DB::beginTransaction();
        try {

            $student->delete();
            DB::commit();


            //now notify the admins about this record
            $msg = $student->name . " student deleted by " . auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end
            //invalid dashboard cache
            Cache::forget('studentCount');
            Cache::forget('student_count_by_class');
            Cache::forget('student_count_by_section');

            return redirect()->route('lead.index')->with('success', 'Lead deleted.');
        } catch (\Exception $e) {
            DB::rollback();
            $message = str_replace(array("\r", "\n", "'", "`"), ' ', $e->getMessage());
        }
        return redirect()->route('lead.index')->with('error', $message);
    }

    /**
     * status change
     * @return \Illuminate\Http\Response
     */
    public function changeStage(Request $request)
    {
        $student =  Student::find($request->id);
        if (!$student) {
            abort(404);
        }

        $student->stage = (int)$request->stage + 1;
        // var_dump($student); die;
        $message = 'Something went wrong!';

        DB::beginTransaction();
        try {
            $student->save();

            DB::commit();
            return redirect()->route('lead.index')->with('success', 'Stage change successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            $message = str_replace(array("\r", "\n", "'", "`"), ' ', $e->getMessage());
        }
        return redirect()->route('lead.index')->with('error', $message);
    }

    /**
     * Get student list by filters
     */
    public function studentListByFitler(Request $request)
    {
        $classId = $request->query->get('class', 0);
        $sectionId = $request->query->get('section', 0);
        $acYear = $request->query->get('academic_year', 0);
        $rollNo = $request->query->get('roll_no', '');
        $regiNo = $request->query->get('regi_no', '');

        if (AppHelper::getInstituteCategory() != 'college') {
            $acYear = AppHelper::getAcademicYear();
        }

        $students = Registration::if($acYear, 'academic_year_id', '=', $acYear)
            ->if($classId, 'class_id', '=', $classId)
            ->if($sectionId, 'section_id', '=', $sectionId)
            ->if(strlen($regiNo), 'regi_no', '=', $regiNo)
            ->if(strlen($rollNo), 'roll_no', '=', $rollNo)
            ->where('status', AppHelper::ACTIVE)
            ->where('is_promoted', '0')
            ->with(['student' => function ($query) {
                $query->select('name', 'id');
            }])
            ->select('id', 'roll_no', 'regi_no', 'student_id')
            ->orderBy('roll_no', 'asc')
            ->get();

        return response()->json($students);
    }

    public function import(Request $request)
    {
        try {

            $stage = (int)$request->get('stage');
            Excel::import(new StudentsImport($stage), request()->file('file'));
            return back()->with('success', 'Leads Imported Successfully.');
        } catch (\Exception $exception) {
            // return back();
            var_dump($exception->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $status = $request->query->get('status', 0);
            $stage = $request->query->get('stage');
            return Excel::download(new StudentExport($status, $stage), 'lead.xlsx');
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            die;
        }
    }

    public function showImport()
    {
        try {
            return view('backend.lead.import');
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            die;
        }
    }
}
