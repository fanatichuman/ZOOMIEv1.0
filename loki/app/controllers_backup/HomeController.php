<?php

class HomeController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'HomeController@showWelcome');
    |
    */

    public function getHome()
    {
        $data = array();
        $data['g'] = Group::with(
            array('pictures' => function($query)
            {
                $query->where('deleted', 0);
                $query->orderBy('timestamp', 'asc');
            }))->paginate(100);
        return View::make('home', $data);
    }

    public function getRemovePicFromGroup()
    {
        $pic = Input::get('pic');
        $picObj = Picture::find($pic);
        if($picObj) {
            $picObj->group_id = 0;
            $picObj->save();
        }
        return Response::json(array('message' => 'success'));
    }

    public function getRemoveGroup()
    {
        $group = Input::get('group');
        $groupObj = Group::find($group);
        if($groupObj) {
            $groupObj->delete();
        }
        return Response::json(array('message' => 'success'));
    }

    public function getAddPicToGroup()
    {
        $group = Input::get('group');
        $pic = Input::get('pic');
        $groupObj = Group::find($group);
        $picObj = Picture::find($pic);
        if($groupObj && $picObj) {
            $picObj->group_id = $groupObj->id;
            $picObj->save();
        }
        return Response::json(array('message' => 'success'));
    }

    public function getCreateGroup()
    {
        $groupObj = new Group();
        $groupObj->save();
        return Response::json(array('group' => $groupObj->id));
    }

    public function getDeleteGuy()
    {
        $pic = Input::get('id');
        $picObj = Picture::find($pic);
        if($picObj) {
            $picObj->deleted = true;
            $picObj->save();
        }
        return Response::json(array('message' => 'success'));
    }

}
