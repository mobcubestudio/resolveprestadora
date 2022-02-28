<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionPermission;
use App\Models\Employee;
use App\Models\Menu;
use App\Models\MenuAttach;
use App\Models\MenuPermission;
use App\Models\SubmenuPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        $senha = '123456';

        $user = new User();
        $user->employee()->associate($employee->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->matricula = $request->input('registration');
        $user->password = Hash::make($senha);
        $user->save();


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

    public function permission(Employee $employee)
    {
        $menus = Menu::all();
        $user = $employee->user()->first();

        //VERIFICA SE JÁ EXISTE USUARIO PARA O FUNCIONÁRIO E CRIA SE NAO TIVER
        if(count(User::where('employee_id',$employee->id)->get())==0){

            $senha = '123456';

            $user = new User();
            $user->employee()->associate($employee->id);
            $user->name = $employee->name;
            $user->email = $employee->email;
            $user->matricula = $employee->registration;
            $user->password = Hash::make($senha);
            $user->save();
        }


        //dd($user);

        $arrMenu = array();

        foreach ($menus as $menu){

            //VRIFICA SE USUARIO JÁ TEM PERMISSÃO PARA O MENU
            $count_menu = DB::table('menu_permissions')
                            ->where('menu_id',$menu->id)
                            ->where('user_id',$user->id)
                            ->count();
            $menu_checked = '';
            if($count_menu>0) $menu_checked = 'checked';

            $submenus = $menu->menuAttach()->get();

            $arrSubmenu = array();
            foreach ($submenus as $submenu){

                //VRIFICA SE USUARIO JÁ TEM PERMISSÃO PARA O SUBMENU
                $count_submenu = DB::table('submenu_permissions')
                    ->where('menu_id',$menu->id)
                    ->where('submenu_id',$submenu->id)
                    ->where('user_id',$user->id)
                    ->count();
                $submenu_checked = '';
                if($count_submenu>0) $submenu_checked = 'checked';

                $menu_attach = MenuAttach::where('menu_id',$menu->id)->where('submenu_id',$submenu->id)->first();
                $submenu_attaches = $menu_attach->submenuAttach()->get();

                $arrAction = array();
                foreach ($submenu_attaches as $submenu_attach){

                    //VERIFICA SE USUARIO JÁ TEM PERMISSÃO PARA O AÇÃO
                    $count_action = DB::table('action_permissions')
                        ->where('menu_id',$menu->id)
                        ->where('submenu_id',$submenu->id)
                        ->where('action_id',$submenu_attach->id)
                        ->where('user_id',$user->id)
                        ->count();
                    $action_checked = '';
                    if($count_action>0) $action_checked = 'checked';

                    $arrAction[] = [
                                    'action_id'=>$submenu_attach->id,
                                    'action_checked'=>$action_checked,
                                    'action_nome'=>$submenu_attach->name];
                }

                $arrSubmenu[] = [
                                    'submenu_id'=>$submenu->id,
                                    'submenu_nome'=>$submenu->name,
                                    'submenu_checked'=>$submenu_checked,
                                    'actions'=>$arrAction];


            }

            $arrMenu[] = [
                'menu_id'=>$menu->id,
                'menu_nome'=>$menu->name,
                'menu_checked' => $menu_checked,
                'submenus'=>$arrSubmenu
            ];
        }

        return view('admin.employee.permission',[
            'menus_grid'=>$arrMenu,
            'user_id' => $user->id
        ]);
    }


    public function permissionApply(Request $request)
    {
        //ddd($request);

        $user_id = $request->post('user_id');
        $a ='';
        DB::table('menu_permissions')->where('user_id',$user_id)->delete();
        DB::table('submenu_permissions')->where('user_id',$user_id)->delete();
        DB::table('action_permissions')->where('user_id',$user_id)->delete();
        foreach ($request->post('menu_id') as $menu){



            $menu_permission = new MenuPermission;
            $menu_permission->menu_id = $menu;
            $menu_permission->user_id = $user_id;
            $menu_permission->save();


            $submenu_field = "submenu_id_{$menu}";
            if($request->has($submenu_field)) {
                foreach ($request->post($submenu_field) as $submenu) {
                    $submenu_permission = new SubmenuPermission;
                    $submenu_permission->menu_id = $menu;
                    $submenu_permission->submenu_id = $submenu;
                    $submenu_permission->user_id = $user_id;
                    $submenu_permission->save();


                    $action_field = "action_id_" . $menu . "_" . $submenu;

                    if ($request->has($action_field)) {
                        foreach ($request->post($action_field) as $action) {
                            $action_permission = new ActionPermission;
                            $action_permission->menu_id = $menu;
                            $action_permission->submenu_id = $submenu;
                            $action_permission->action_id = $action;
                            $action_permission->user_id = $user_id;
                            $action_permission->save();
                        }
                    }
                }
            }



        }
        //dd($a);

    }
}
