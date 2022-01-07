<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Course;

class authAcademyId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userAuth = auth()->user();
        $idCourse = intval(explode("/",$request->getPathInfo())[2]);
        $course = Course::findOrFail($idCourse);
        
        if ($course->branchOffice->academy_id === $userAuth->academy_id || null === $userAuth->academy_id ) {
            return $next($request);
        }
        return back();         
        
    }
}
