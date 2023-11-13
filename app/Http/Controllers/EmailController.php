<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\SendAnEmail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SendEmailRequest;
use App\Utilities\Helpers\ElasticSearch;

class EmailController extends Controller
{
    public function send(User $user, SendEmailRequest $request): JsonResponse
    {
        foreach ($request->emails as $email) {
            
            $data = [
                'user_name' => $user->name,
                'user_email' => $user->email,
                'email' => $email['email'],
                'subject' => $email['subject'],
                'body' => $email['body']
            ];

            SendAnEmail::dispatch($data);
        }

        return response()->json([
            'message' => 'Email sent.'
        ], 200);
    }

    public function list(Request $request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 10;

        $es = new ElasticSearch();
        $results = $es->listEmail($page, $perPage);
        return response()->json([
            'data' => $results,
        ]);
    }
}
