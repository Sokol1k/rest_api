<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Businesses\IndexRequest;
use App\Http\Requests\Businesses\CreateRequest;
use App\Http\Requests\Businesses\ShowRequest;
use App\Http\Requests\Businesses\UpdateRequest;
use App\Http\Requests\Businesses\DeleteRequest;

use App\Models\Business;

use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $businesses = Business::select('id', 'user_id', 'name', 'description', 'category', 'rating', 'is_licensed', 'full_address');

        if ($request->user_id) {
            $businesses->where('user_id', $request->user_id);
        }

        if ($request->search) {
            $businesses->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                ->orWhere('full_address', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->column && (strtolower($request->direction) == 'asc' || strtolower($request->direction) == 'desc')) {
            $businesses->orderBy($request->column, strtolower($request->direction));
        }


        return $this->response->array([
            'status_code' => 200,
            'data' => $businesses->paginate(20)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $path = explode('/', $path);
            $data['image'] = $path[count($path) - 1];
        } else {
            $data['image'] = null;
        }
        $data['user_id'] = Auth::user()->id;
        $business = Business::create($data);

        return $this->response->array([
            'status_code' => 200,
            'message' => $business
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequest $request, Business $business)
    {
        return $this->response->array([
            'status_code' => 200,
            'data' => $business
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Business $business)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $path = explode('/', $path);
            $data['image'] = $path[count($path) - 1];
        }
        $business->update($data);

        return $this->response->array([
            'status_code' => 200,
            'message' => $business
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRequest $request, Business $business)
    {
        $business->delete();

        return $this->response->array([
            'status_code' => 200,
            'message' => 'Post successfully deleted!'
        ]);
    }
}
