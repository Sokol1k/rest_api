<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Http\Requests\Users\IndexRequest;
use App\Http\Requests\Users\ShowRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Requests\Users\DeleteRequest;
use App\Http\Requests\Users\ConfirmRequest;
use App\Http\Requests\Users\UserBusinnessesRequest;

use App\Models\User;
use App\Models\Business;

use App\Jobs\SendEmailJob;

use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $users = DB::table('model_has_roles')
            ->join('users', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.id', 'users.name', 'users.email', 'roles.name as role', 'users.confirmed');

        if (strtolower($request->unconfirmed) == 'true') {
            $users->where('confirmed', '0');
        }

        if ($request->search) {
            $users->where('users.name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('roles.name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->column && (strtolower($request->direction) == 'asc' || strtolower($request->direction) == 'desc')) {
            $users->orderBy($request->column, strtolower($request->direction));
        }

        return $this->response->array([
            'status_code' => 200,
            'data' => $users->paginate(20)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequest $request, User $user)
    {
        $user = DB::table('model_has_roles')
            ->join('users', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.name', 'roles.name as role', 'users.email', 'users.confirmed', 'users.created_at', 'users.updated_at')
            ->where('users.id', $user->id)
            ->get();
        return $this->response->array([
            'status_code' => 200,
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->all());

        return $this->response->array([
            'status_code' => 200,
            'message' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request, User $user)
    {
        $user->delete();

        return $this->response->array([
            'status_code' => 200,
            'message' => 'User successfully deleted!'
        ]);
    }

    public function confirm(ConfirmRequest $request, User $user)
    {
        $details['email'] = $user->email;
        dispatch(new SendEmailJob($details));
        $user->update(['confirmed' => 1]);
        return $this->response->array([
            'status_code' => 200,
            'message' => $user
        ]);
    }

    public function userBusinnesses(UserBusinnessesRequest $request, User $user)
    {
        $business = Business::select(DB::raw('DATE(created_at) as date, COUNT(name) as count '))
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->from, $request->to])
            ->groupBy(DB::raw('DATE(`created_at`)'));

        return $this->response->array([
            'status_code' => 200,
            'data' => $business->where('user_id', $user->id)->get()
        ]);
    }
}
