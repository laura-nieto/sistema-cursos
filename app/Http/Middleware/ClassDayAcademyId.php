<?php

namespace App\Http\Middleware;

use App\Models\Class_day;
use Closure;
use Illuminate\Http\Request;

class ClassDayAcademyId
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
        $idDay = $request->route()->parameter('classDay');
        $academy_id = Class_day::find($idDay)->course->branchOffice->academy_id;
        
        if($academy_id === $userAuth->academy_id || null === $userAuth->academy_id) {
            return $next($request);
        }
        
        return back();
    }
}
