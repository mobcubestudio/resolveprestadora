<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employee.index',[
            'employees' => Employee::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.employee.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $employee = Employee::create([
            'role_id' => $request->input('role_id'),
            'registration' => $request->input('registration'),
            'name' => $request->input('name'),
            'cpf' => $request->input('cpf'),
            'rg' => $request->input('rg'),
            'address' => $request->input('address'),
            'birth_date' =>  date_format(date_create_from_format('d/m/Y',$request->input("birth_date")),'Y-m-d'),
            'marital_status' => $request->input('marital_status'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone')

        ]);
        toastr()->success('Funcionário cadastrado com sucesso');

        // Image Upload
        $this->imageUpload($request, $employee->id);
        return redirect()->route('admin.employees');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('admin.employee.form',['employee'=>$employee]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->get("id");
        $employee = Employee::find($id);

        //dd($id);
        $employee->role_id = $request->input("role_id");
        $employee->registration = $request->input("registration");
        $employee->name = $request->input("name");
        $employee->cpf = $request->input("cpf");
        $employee->rg = $request->input("rg");
        $employee->address = $request->input("address");
        $employee->birth_date = date_format(date_create_from_format('d/m/Y',$request->input("birth_date")),'Y-m-d');
        $employee->marital_status = $request->input("marital_status");
        $employee->email = $request->input("email");
        $employee->phone = $request->input("phone");
        $employee->save();
        toastr()->success($employee->name.' editado com sucesso');

        // Image Upload
        $this->imageUpload($request, $employee->id);
        return redirect()->route('admin.employees');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //dd($employee);
        $employee->delete();
        toastr()->success($employee->name.' movido para a lixeira.');
        return redirect()->route('admin.employees');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function trash()
    {
        return view ('admin.employee.trash',[
            'employees' => Employee::onlyTrashed()->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recycle($id)
    {
        //dd($id);
        $employee = Employee::onlyTrashed()->findOrFail($id);
        $employee->restore();
        toastr()->success($employee->name.' restaurado com sucesso');
        return redirect()->route('admin.employees');
    }

    /**
     * Upload Image
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    private function imageUpload(Request $request, int $id)
    {
        $input = $request->all();


        if ($input['image-crop']!=null) {

            //dd($input['image-crop']);
            $folderPath = public_path('images/employees/');
            $image_parts = explode(";base64,", $input['image-crop']);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            // $file = $folderPath . uniqid() . '.png';
            $filename = $id . '.jpg';
            $file =$folderPath.$filename;
            file_put_contents($file, $image_base64);
        }
        //$msg = 'Image upload successfully.';
        //Session::flash('message', $msg );



        /*if($request->hasFile('image') && $request->file('image')->isValid()){
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = $id . "." . $extension;
            $file_decode = base64_decode()
            $file = 'images/products'.$imageName;
            //$requestImage->move(public_path('images/products'),$imageName);
            file_put_contents($file,)
        }*/

    }
}
