<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index() {
        $soft = $request->input('sort');
        if($sort == 'asc' || $sort == 'desc'){
            $reports = Report::orderBy('created_at', $sort)
                ->paginate(8);
        } else {
            $reports=Report::paginate(8);
        }
        $statuses=Status::all();
        return view('report.index', compact('statuses'));
    }

    public function destroy(Report $report) {
        $report -> delete();
        return redirect()->back();
    }

    public function store(Request $request, Report $report) {
        $data = $request->validate([
            'number' => 'string',
            'description' => 'string',
        ]);
        
        $data['user_id']=Auth::user()->id;
        $data['status_id']=1;

        $report->create($data);
        return redirect()->back();
    }

    public function edit(Report $report) {
        return view('report.show', compact('report'));
    }

    public function update(Request $request, Report $report) {
        $data = $request->validate([
            'number' => 'string',
            'description' => 'string',
        ]);

        $report->update($data);
        return redirect()->back();
    }
}