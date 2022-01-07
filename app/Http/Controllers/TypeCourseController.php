<?php

namespace App\Http\Controllers;

use App\Models\Course_type;
use Illuminate\Http\Request;

class TypeCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:course_types.index')->only('index','show');
        $this->middleware('permission:course_types.create')->only('create','store');
        $this->middleware('permission:course_types.edit')->only('edit','update');
        $this->middleware('permission:course_types.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course_type  $courseType
     * @return \Illuminate\Http\Response
     */
    public function show(Course_type $courseType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course_type  $courseType
     * @return \Illuminate\Http\Response
     */
    public function edit(Course_type $courseType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course_type  $courseType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course_type $courseType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course_type  $courseType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course_type $Course_type)
    {
        //
    }   
}
