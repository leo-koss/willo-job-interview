<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\HTTP\Response;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Template\Template;

class TemplateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $messages = Message::where("user_id", $user->id)
            ->orWhere('editable', 0)
            ->orderBy('id', 'desc')
            ->get();
        $messages->transform(function ($message) {
            $message->content = strip_tags($message->content);
            return $message;
        });
        return view('template.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (Auth::check()) {
            $request->validate([
                'title' => 'required',
                'type' => 'required',
                'trigger' => 'required',
                'content' => 'required'
            ]);
            $request['writer'] = $user->email;
            $request['user_id'] = $user->id;

            $save_data = Message::create($request->all());

            return response()->json([
                'status' => 'success',
                'data' => $save_data,
            ], Response::HTTP_OK);
        }
        redirect("home");
    }

    /**
     * copy a newly created resource in storage.
     */
    public function copy($id)
    {
        $user = Auth::user();
        if (Auth::check()) {
            $message = Message::find($id);
            $new_message = [
                'title' => $message->title,
                'type' =>  $message->type,
                'trigger' => $message->trigger,
                'content' => $message->content,
                'writer' => $user->email,
                'user_id' => $user->id,
            ];

            $save_data = Message::create($new_message);

            if (!empty($save_data)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $save_data,
                ], Response::HTTP_OK);
            }
            return response()->json([
                'status' => 'failed',
                'data' => $save_data,
                'message' => '操作が失敗しました。',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
        redirect("home");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = Message::find($id);
        if (empty($message)) {
            return redirect()->back();
        }
        return response()->json($message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $message = Message::find($id);
        return view('template.edit', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!empty($user)) {
            $request->validate([
                'title' => 'required',
                'type' => 'required',
                'trigger' => 'required',
                'content' => 'required'
            ]);
            $request['writer'] = $user->email;

            $save_data = Message::find($id);
            $save_data['title'] = $request['title'];
            $save_data['type'] = $request['type'];
            $save_data['trigger'] = $request['trigger'];
            $save_data['content'] = $request['content'];
            $save_data->save();

            return response()->json([
                'status' => 'success',
                'data' => $save_data,
            ], Response::HTTP_OK);
        }
        redirect("home");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = Message::find($id);
        $email = Auth::user()->email;
        if (!empty($message)) {
            if ($email == $message->writer) {
                if ($message->editable == 1) {
                    $message->delete();
                    return response()->json([
                        'status' => 'success',
                        'message' => '削除操作が正常に行われました。'
                    ], Response::HTTP_OK);
                }
                return response()->json([
                    'status' => 'failed',
                    'message' => 'このメッセージは削除できません。'
                ], Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'このメッセージを削除する権限がありません。'

                ], Response::HTTP_BAD_REQUEST);
            }
        }
        return response()->json([
            'status' => 'failed',
            'message' => '削除操作が失敗しました。',
            'data' => $message,
        ], Response::HTTP_BAD_REQUEST);
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $keyword = $request->input('keyword');
        $type = $request->input('type');

        $messages = Message::where('user_id', $user->id)
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where('title', 'LIKE', '%'.$keyword.'%');
            })
            ->when($type, function ($query) use ($type) {
                return $query->where(['type' => $type]);
            })
            ->orderBy('id', 'desc')
            ->get();
        $defaultMessage = Message::where('editable', 0)
        ->when($keyword, function ($query) use ($keyword) {
            return $query->where('title', 'LIKE', '%'.$keyword.'%');
        })
        ->when($type, function ($query) use ($type) {
            return $query->where(['type' => $type]);
        })
        ->get();

        $messages = $defaultMessage->merge($messages);

        return response()->json($messages);
    }
}
