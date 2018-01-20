<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $userRepository = new UserRepository();
        $user = $userRepository->getById($id);
        return view('profile.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $rules = array(
            'name' => 'required',
            'email' => 'required|email'
        );
        $validator = Validator::make(\Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('profile/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput(\Input::except('password'));
        } else {
            // store    
            $userRepository = new UserRepository();

            if ($request->hasFile('pp_image')) {
                $image = $request->file('pp_image');
                $pp_image = time() . '.' . $image->getClientOriginalExtension();


                $destinationPath = public_path('/thumbnail');
                $img = \Image::make($image->getRealPath());
                $img->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $pp_image);


                $destinationPath = public_path('/images');
                $image->move($destinationPath, $pp_image);

                $request->pp_image_path = $pp_image;
            }

            $userRepository->update($request, $id);

            // redirect
            \Session::flash('message', 'Successfully updated profile!');
            return redirect()->route('profile.edit', ['id' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
