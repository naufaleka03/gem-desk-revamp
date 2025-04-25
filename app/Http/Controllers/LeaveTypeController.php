<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveTypeRequest;
use App\Http\Requests\UpdateLeaveTypeRequest;
use App\Models\LeaveType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;



class LeaveTypeController extends Controller
{
    public function index(Request $request){
        $query = $request->get('query');
        if($request->ajax()){
            $data = LeaveType::query()->where('name', 'LIKE', $query . '%')
                ->limit(10)
                ->get();
            $output = '';
            $loop = 0;
            if (count($data) > 0){
                foreach ($data as $row){
                    $output .= '
                        <tr>
                            <th scope="row">' . $loop . '</th>
                            <td>' . $row->name . '</td>
                            <td>' . $row->max_duration . '</td>
                            <td>' . $row->status . '</td>
                            <td>
                                <form action="' . route('leaveTypes.approve', $row->id) . '" method="post">
                                    ' . csrf_field() . '
                                    ' . method_field('PATCH') . '
                                    <button type="submit" class="btn btn-submit" href="' . route('leaveTypes.index') . '">Approve</button>
                                </form>
                                <a href="' . route('leaveTypes.show', $row->id) . '" class="btn btn-info" style="margin-right: 2%">Show</a>
                                <a class="btn btn-danger me-1" href="#" onclick="
                                    event.preventDefault();
                                    if(confirm(\'Do you want to delete this?\')){
                                        document.getElementById(\'delete-row-' . $row->id . '\').submit();
                                    }
                                ">Delete</a>
                                <form id="delete-row-' . $row->id . '" action="' . route('leaveTypes.destroy', $row->id) . '" method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    ' . csrf_field() . '
                                </form>
                            </td>
                        </tr>';
                    $loop += 1;
                }
            }else{
                $output .= '<td colspan="5">
                            <div class="d-flex justify-content-center">
                                No Record Found
                            </div>
                        </td>';
            }
            return $output;
        }
        if (auth()->user()->roles == 'admin'){
            $leaveTypes = LeaveType::query()->where('name', 'LIKE', '%' . $query . '%')
                ->simplePaginate(8);
        }else{
            $user_id = auth()->user()->id;
            $leaveTypes = LeaveType::query()
                ->where('name', 'LIKE', '%' . $query . '%')
                ->where('user_id', '=', $user_id)
                ->simplePaginate(8);
        }

        return view('leaveTypes.index', compact('leaveTypes'));
    }

    public function create(){
        return view('leaveTypes.create');
    }

    public function store(StoreLeaveTypeRequest $request): RedirectResponse
    {
        $leaveType = new LeaveType();
        $leaveType->name = $request->name;
        $leaveType->description = $request->description;
        $leaveType->max_duration = $request->max_duration;
        $leaveType->user_id = auth()->user()->id;

        $leaveType->save($request->validated());
        return redirect()->route('leaveTypes.index')
            ->with('success','Leave Type added successfully');
    }


    public function show(LeaveType $leaveType){
        return view('leaveTypes.show', compact('leaveType'));
    }

    public function edit(LeaveType $leaveType)
    {
        return view('leaveTypes.edit', compact('leaveType'));
    }

    public function destroy(LeaveType $leaveType){
        $leaveType->delete();
        return redirect()->route('leaveTypes.index')->with('success','Leave Type has been deleted');
    }

    public function approve(LeaveType $leaveType)
    {
        $leaveType->status = 'approved';
        $leaveType->save();
        return redirect()->route('leaveTypes.index');
    }
}
