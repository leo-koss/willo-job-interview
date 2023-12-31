<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\Company;
use App\Models\InvitedUsers;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $candidates = Candidate::join('companies', 'candidates.company_id', 'companies.id')
            ->join('jobs', 'candidates.job_id', 'jobs.id')
            ->where('candidates.user_id', '=', $user->id)
            ->where('candidates.status', '!=', 'init')
            ->select('candidates.*', 'jobs.title as job_title', 'companies.name as company_name')
            ->get();
        $jobs = Job::where('jobs.user_id', $user->id)
            ->orderBy('title', 'desc')
            ->get();
        $companies = Company::where(['owner' => $user->id])->orderBy('name', 'asc')->get();
        $owners = InvitedUsers::join('users', 'invited_users.inviter', '=', 'users.email')
            ->where(['invited_users.inviter' => $user->email])
            ->where('invited_users.user_id', '!=', 0)
            ->select("users.name as name", "invited_users.*")
            ->get();
        return view('member.index', compact('candidates', 'companies', 'owners', 'jobs', 'user'));
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $name = $request->input('name');
        $companies = $request->input('companies');
        $owners = $request->input('owners');
        $statuses = $request->input('statuses');
        $jobs = $request->input('jobs');
        $rates = $request->input('rates');

        $candidates = Candidate::join('companies', 'candidates.company_id', '=', 'companies.id')
            ->join('users', 'candidates.user_id', '=', 'users.id')
            ->join('jobs', 'candidates.job_id', '=', 'jobs.id')
            ->where('candidates.user_id', $user->id)
            ->where('candidates.status', '!=', 'init')
            ->when($name, function ($query) use ($name) {
                return $query->where('candidates.name', 'LIKE', '%' . $name . '%');
            })
            ->when($companies, function ($query) use ($companies) {
                return $query->whereIn('companies.id', $companies);
            })
            ->when($owners, function ($query) use ($owners) {
                return $query->whereIn('companies.owner', $owners);
            })
            ->when($statuses, function ($query) use ($statuses) {
                return $query->whereIn('candidates.status', $statuses);
            })
            ->when($jobs, function ($query) use ($jobs) {
                return $query->whereIn('jobs.id', $jobs);
            })
            ->when($rates, function ($query) use ($rates) {
                return $query->whereIn('candidates.review', $rates);
            })
            ->orderBy('candidates.created_at', 'desc')
            ->select('candidates.*', 'companies.name as company_name', 'jobs.title as job_title', 'users.name as user_name', 'users.email as email')
            ->get();

        return response()->json($candidates);
    }
    
    public function reject(Request $request, int $candidate_id)
    {
        $user = Auth::user();
        $candidate = Candidate::find($candidate_id);
        if(empty($user) || empty($candidate)){
            return response('', 400);
        }
        $candidate['status'] = "rejected";
        $reason = $request['reason'];
        $candidate->save();
        $activity = [
            'candidate_id' => $candidate->id,
            'content' => '候補者が'.$user->name.'によって拒否されました',
            'type' => 'reject',
            'name' => $user->name,
        ];
        Activity::create($activity);
        return response(['status' => 'success']);
    }

    public function candidate_share(Request $request, string $candidate_id)
    {
        $candidate = Candidate::where(['id' => $candidate_id])
        ->first();
        $user = Auth::user();
        if(empty($candidate) || empty($user)){
            return response()->json(['status' => 'failed', 'message' => 'Request Failed']);
        }
        $flag = $request['flag'] ? 1 : 0;
        $candidate['share_allow'] = $flag;
        $candidate->save();
        return response()->json(['status' => 'success', 'message' => 'The operation is successed.']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
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
